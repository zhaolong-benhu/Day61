<?php
require __DIR__ . '/../@yii.php';
if(ENVIRONMENT == 'local'){
	$config = array(
			'db'=>array(
					'connectionString' => 'mysql:host=10.10.29.238;dbname=weixin_activities',
					'emulatePrepare' => false,
					'username' => 'test',
					'password' => 'test',
					'charset' => 'utf8',
					'tablePrefix' => 'wams_',
					'schemaCachingDuration' => 100,
					'autoConnect' => false,
					'enableProfiling'=>true,
			),
	);
	Yii::app()->setComponent('db',$config['db']);
}
$class = new Admin();
$action = Yii::app()->getRequest()->getParam('a','index');
$class->$action();

/**
 * 后台操作接口
 * @author Andy.Gao@veryeast.cn
 * @invoked application.controllers.EnrollAmangerController
 */
class Admin{
	public function index(){}

	/**
	 * 后台审核接口
	 */
	public function audit(){
		$audit = Yii::app()->getRequest()->getParam('audit',0);
		$id = Yii::app()->getRequest()->getParam('id',0);
		$dbCommand = Yii::app()->db->createCommand();
		$updateData = array(
			'audit'=>$audit,
			'add_time'=>time(),
		);
		if($dbCommand->update('wams_contest_user',$updateData,'id='.$id)){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	 * 后台删除用户接口
	 */
	public function del(){
		$id = Yii::app()->getRequest()->getParam('id',0);
		$number = Yii::app()->getRequest()->getParam('number',0);
		$dbCommand = Yii::app()->db->createCommand();
		if($dbCommand->delete('wams_contest_user','id='.$id)){
			$dbCommand->delete('wams_contest_votelog','number=:number',array(':number'=>$number));
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	 * 统计数据(展示)缓存接口
	 */
	public function showData(){
		$userCount = Yii::app()->getRequest()->getParam('userCount',0);
		$voteCount = Yii::app()->getRequest()->getParam('voteCount',0);
		$visitCount = Yii::app()->getRequest()->getParam('visitCount',0);
		$statData = compact('userCount','voteCount','visitCount');
		$file = Yii::getPathOfAlias('application').'/views/20150510/stat.txt';
		if(file_put_contents($file, serialize($statData))){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	 * 修改获票数量(展示)
	 */
	public function changevote(){
		$id = Yii::app()->getRequest()->getParam('id',0);
		$vote_show = Yii::app()->getRequest()->getParam('vote_show',0);
		$dbCommand = Yii::app()->db->createCommand();
		if($dbCommand->update('wams_contest_user',array('vote_show'=>$vote_show),'id='.$id)){
			echo 1;
		}else{
			echo 0;
		}
	}
}