<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

	public function beforeFilter(\Cake\Event\Event $event){
		parent::beforeFilter($event);
		$this->Auth->allow("add");
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        if($this->request->is("post")){
        	$user = $this->Auth->identify();
        	if($user){
        		$this->Auth->setUser($user);
        		$this->Flash->success("ログインに成功しました。");
        		$this->request->session()->write("LOGINUSER.userid", $this->request->getData("userid"));
        		$height = $this->Users->find()->where(["userid = " => $this->request->getData("userid")])->first();
        		$this->request->session()->write("LOGINUSER.height", $height->height);
        		return $this->redirect(($this->Auth->redirectUrl()));
        	}
        	$this->Flash->error("ログインID又はパスワードが間違っています。");
        }
    }

    public function logout(){
    	$this->request->session()->destroy();
    	return $this->redirect(($this->Auth->logout()));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        //同一のユーザーIDがないかどうかのチェック
        $useridNum = $this->Users->find()->where(["userid = " => $this->request->getData("userid")])->count();
        if($useridNum > 0){
        	$this->Flash->error("このユーザーIDは登録できません。");
        }else{
        	//パスワードが２回同じものを入力されているかどうかチェック
	        if($this->request->getData("password") != $this->request->getData("passwordcheck")){
	        	$this->Flash->error("１回目と２回目に入力されたパスワードが異なっています。");
	        }else{

	       		if ($this->request->is('post')) {
    	   	    	$user = $this->Users->patchEntity($user, $this->request->getData());
            		if ($this->Users->save($user)) {
                		$this->Flash->success(__('新規登録が完了しました。'));

		                return $this->redirect(['action' => 'login']);
    		        }
		            $this->Flash->error(__('新規登録に失敗しました。'));
		        }
        	}
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
    	//SESSIONからIDの取得
    	$userData = $this->Users->find()->where(["userid =" => $this->request->session()->read("LOGINUSER.userid")])->first();

        $user = $this->Users->get($userData->id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	if($this->request->getData("password") != $this->request->getData("passwordcheck")){
        		$this->Flash->error("１回目と２回目に入力されたパスワードが異なっています。");
        	}else{
            	$user = $this->Users->patchEntity($user, [
            			"id" => $user->id,
            			"userid" => $user->userid,
            			"password" => $this->request->getData("password"),
            			"height" => $this->request->getData("height")
            	]);
            	if ($this->Users->save($user)) {
                	$this->Flash->success(__('変更が完了しました。'));
                	$this->request->session()->write("LOGINUSER.height", $user->height);

                	return $this->redirect(["controller" => "Dietdata",'action' => 'index']);
            	}
            	$this->Flash->error(__('変更に失敗しました。'));
        	}
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('ユーザー情報を削除しました。'));
        } else {
            $this->Flash->error(__('ユーザー情報削除に失敗しました。'));
        }

        return $this->redirect(['action' => 'login']);
    }
}
