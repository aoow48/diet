<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Dietdata Controller
 *
 * @property \App\Model\Table\DietdataTable $Dietdata
 *
 * @method \App\Model\Entity\Dietdata[] paginate($object = null, array $settings = [])
 */
class DietdataController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
    	//SESSIONからユーザIDの取得
    	$userid = $this->request->session()->read("LOGINUSER.userid");

    	//体重データのjavascript受け渡し用データ作成
    	$weightdata = $this->Dietdata->getWeight($userid);
    	$weight = json_encode($weightdata);
    	$this->set("weight", $weight);

    	//テーブルに表示するデータの作成
    	$dietdata = $this->Dietdata->find()->where(["userid = " => $userid])->orderDesc("date")->orderDesc("id");
        $this->set("userid", $userid);
        $this->set(compact('dietdata'));
        $this->set('_serialize', ['dietdata']);

        //BMIの作成
        $height = $this->request->session()->read("LOGINUSER.height");
        $bmi = $this->Dietdata->getBmi($userid, $height);
        $this->set("bmi", $bmi);

        //グラフの回帰直線の傾きの計算
        $a = $this->Dietdata->getA($userid);
        if($a > 0){
        	$result = "増加傾向";
        	$colorid = "plus";
        }elseif ($a < 0){
        	$result = "減少傾向";
        	$colorid = "minus";
        }else{
        	$result = "横ばい";
        	$colorid = "zero";
        }
        $this->set("result", $result);
        $this->set("colorid", $colorid);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	//SESSIONからユーザIDの取得
    	$userid = $this->request->session()->read("LOGINUSER.userid");
    	$this->set("userid" ,$userid);


        $dietdata = $this->Dietdata->newEntity();
        if ($this->request->is('post')) {
            $dietdata = $this->Dietdata->patchEntity($dietdata, [
            		"userid" => $userid,
            		"weight" => $this->request->getData("weight"),
            		"date" => $this->request->getData("date")

            ]);
            if ($this->Dietdata->save($dietdata)) {
                $this->Flash->success(__('データを追加しました。'));

                return $this->redirect(['action' => 'index', $userid]);
            }
            $this->Flash->error(__('データの追加に失敗しました。'));
        }
        $this->set(compact('dietdata'));
        $this->set('_serialize', ['dietdata']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dietdata id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dietdata = $this->Dietdata->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	if($dietdata->userid == $this->request->session()->read("userid")){
            	$dietdata = $this->Dietdata->patchEntity($dietdata, [
            			"id" => $dietdata->id,
            			"userid" => $this->request->session()->read("userid"),
            			"weight" => $this->request->getData("weight"),
            			"date" => $this->request->getData("date")

            	]);
            	if ($this->Dietdata->save($dietdata)) {
                	$this->Flash->success(__('編集に成功しました。'));

                	return $this->redirect(['action' => 'index']);
            	}
            	$this->Flash->error(__('編集に失敗しました。'));
        	}else{
        		$this->Flash->error("不正な操作です。");
        		return $this->redirect(["action" => "index"]);
        	}
        }
        $this->set(compact('dietdata'));
        $this->set('_serialize', ['dietdata']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Dietdata id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	$this->request->allowMethod(['post', 'delete']);
        $dietdata = $this->Dietdata->get($id);
        if($dietdata->userid == $this->request->session()->read("LOGINUSER.userid")){
        	if ($this->Dietdata->delete($dietdata)) {
           		$this->Flash->success(__('データを削除しました。'));
        	} else {
            	$this->Flash->error(__('データの削除に失敗しました。'));
        	}
        }else{
        	$this->Flash->error("不正な操作です。");
        }
        return $this->redirect(['action' => 'index']);
    }
}
