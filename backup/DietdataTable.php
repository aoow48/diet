<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dietdata Model
 *
 * @method \App\Model\Entity\Dietdata get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dietdata newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dietdata[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dietdata|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dietdata patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dietdata[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dietdata findOrCreate($search, callable $callback = null, $options = [])
 */
class DietdataTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('dietdata');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('userid', 'create')
            ->notEmpty('userid');

        $validator
            ->numeric('weight')
            ->requirePresence('weight', 'create')
            ->notEmpty('weight');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        return $validator;
    }

    //体重データを取得するメソッド
    public function getWeight($userid){
    	$datanum = $this->find()->where(["userid = " => $userid])->count();
    	if($datanum < 30){
    		$datanum = 30;
    	}
    	$data = $this->find()->where(["userid = " => $userid])->orderAsc("date")->orderAsc("id")->limit(30)->offset($datanum - 30);
    	$weightdata = array();
    	foreach ($data as $data){
    		$weightdata[] = $data->weight;
    	}

    	return $weightdata;
    }

    //BMIを計算するメソッド
    public function getBmi($userid, $height){
    	//BMIの作成
    	$weightdata = $this->find()->where(["userid = " => $userid])->orderDesc("date")->orderDesc("id")->first();
    	if($weightdata == null){
    		$bmi = 0;
    	}else{
    		$bmi = $weightdata->weight / ($height / 100) / ($height / 100);
    	}

    	return $bmi;
    }

    //最小二乗法によって算出する回帰直線の傾きを計算するメソッド
    public function getA($userid){
    	$sumX = 0;
    	$sumY = 0;
    	$sumXY = 0;
    	$sumXsq = 0;
    	//計算用数値の生成
    	$weightnum = $this->find()->where(["userid = " => $userid])->orderDesc("date")->orderDesc("id")->count();
    	if($weightnum > 30){
    		$weightnum = 30;
    	}

    	$weightdata = $this->getWeight($userid);

    	if($weightnum > 1){
    		for($i = 0; $i < $weightnum; $i++){
    			$sumX += $i * 20;
    			$sumY += $weightdata[$i];
    			$sumXY += $i * 20 * $weightdata[$i];
    			$sumXsq += $i * 20 * $i * 20;
    		}
    		//傾き計算
    		$a = ($weightnum * $sumXY - $sumX * $sumY) / ($weightnum * $sumXsq - ($sumX * $sumX));
    	}else{
    		$a = 0;
    	}

    	return $a;
    }
}
