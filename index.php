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

$action = Yii::app()->request->getParam('a','Index');
$c = new MostBeautifulGirl();
$c->$action();

class MostBeautifulGirl{
	public $title = '追忆最嗨学生时代';
	public $registDuration = '6.03 — 6.23';
	public $voteDuration = '6.03 — 6.30';
	public $registDuration1 = '2016年5月30日-2016年6月8日 24:00前';
	public $voteDuration2 = '2015年6月03日-2015年6月30日';
	public $interpretation = '本活动最终解释权归先之公众号所有';
	public $activityRule = array(
		'1、在公共号平台进入“我要报名”或者回复“报名”，按提示上传图片；',
		'2、在微信其他平台进入“我要报名”。',
		'插旗方式：',
		'直接点击或公共号回复“六一”按提示操作',
		'插旗限制',
		'每个微信号每天只能插5旗，但每天只能给同一人插1旗。',
	);
	public $activityRule2 = array(
		'1、报名需提交真实照片，否则无效；',
		'2、活动公平公正，拒绝刷屏，否则无效；',
		'3、不投评委，红旗数依序排名；',
		'4、本次活动内容最终解释权归先之酒店业教育培训网所有。',
		'电话： 0571-87672155',
	);
	public $award = array(
		'一等奖:',
		'zhaolong:',
		'二等奖:',
		'奖  品:',
		'三等奖:',
		'奖  品:',
		'奖品说明:',
		'（本次奖品由IHMA友情赞助）',
		'<a href="http://m.9first.com/ihma/index" style="color:#fe7a70">IHMA</a>,只为证明酒店人的胜任力！',
	);
	public $award2 = array(
		'一名',
		'星际酒店房券3张，一罐雨前一级龙井茶，一架小黄人遥控飞机，500元先之学习券',
		'两名',
		'星际酒店房券2张，一罐雨前一级龙井茶，一架小黄人遥控飞机，388元先之学习券',
		'六名',
		'一罐雨前一级龙井茶，一架小黄人遥控飞机，188元先之学习券',
		'1、覆盖全国主要城市星际酒店房券或由我方根据情况预约订房即可;',
		'2、6月13日公布及陆续发放奖品，获奖者必须提供真实的报名信息(姓名，电话)造成无法发放奖品的不再补发;',


		'（本次奖品由IHMA友情赞助）',
		'<a href="http://m.9first.com/ihma/index" style="color:#fe7a70">IHMA</a>,只为证明酒店人的胜任力！',
	);
	public $uploadPath = './upload';
	/**
	 * 酒店人公众号信息
	 */
	public $jiudianrenConfig = array(
		'appId'=>'wxadec56d0be885364',
		'appSecret'=>'380391c5476a9c66e681fafa15e0e017',
	);
	/**
	 * 东方网升公众号信息
	 */
	public $veryeastConfig = array(
		'appId'=>'wx79d2d0883bd09bf7',
		'appSecret'=>'8facb71c17feef00c4078cde5f2b38e7',
	);
	public $wechatApi;

	public $userInfo;
    protected $component_id;
    protected $controller;
    public $isSubscribe = 1;//当前访问用户是否已关注  默认关注
    //报名，投票，分享之前必须成为粉丝
    public $subscribeUrl = 'http://mp.weixin.qq.com/s?__biz=MzA4NTg2NzEwMw==&mid=209838609&idx=1&sn=e2141e2cf0fdf9ea528fd5022fce5877#rd';

    public $tbl_user = 'wams_contest_user';
    public $tbl_vote = 'wams_contest_votelog';
    public $tbl_visit = 'wams_contest_statistic';

    public function __construct(){
		$this->cache_time=0;
		$this->caching = false;
    	//$this->component_id = 34;
    	$this->component_id = 26;
    	$this->controller = new Controller(get_class($this));
    	Yii::app()->setViewPath(dirname(__FILE__).DIRECTORY_SEPARATOR.'views');
    	Yii::app()->name = $this->title;
    	require 'api/WechatApi.php';
    	$this->wechatApi = new WechatApi($this->veryeastConfig);
    	if($openid=Yii::app()->getRequest()->getQuery('openid')){
    		$this->userInfo = array(
    			'openid'=>$openid,
    		);
    		$this->isSubscribe = 1;
    	}else{
    		$this->event = new ComponentEvent($this);
    		$this->event->appName = 'veryeast';
    		$this->component = new UserComponent();
    		$this->component->onGetSnsUserInfo($this->event);
    		$this->userInfo = $this->event->result;
    		if (!isset($this->userInfo['openid'])){
    			//self::redirect();
    		}
    		//$this->_checkSubscribe();
    	}
$this->userInfo = array(
    			'openid'=>'2342141232154789xsfsgas',
    		);
    	//布局文件公用数据
    	$this->_addClip();
    }

    public static function redirect()
    {
//    	$host     = 'http://wams.veryeast.cn';
//    	$redirect = $host . $_SERVER['REQUEST_URI'].'index.php?a=index';
//    	$baseUrl  = 'https://open.weixin.qq.com/connect/oauth2/authorize';
//    	$params   = array(
//    			'appid'         => 'wx79d2d0883bd09bf7',
//    			'redirect_uri'  => 'http://m.veryeast.cn/redirect/weixin?url=' . urlencode($host . '/api/user/weixinAuth?redirect=' . urlencode($redirect)),
//    			'response_type' => 'code',
//    			'scope'         => 'snsapi_userinfo',
//    	);
//
//    	$s = array();
//
//    	foreach ($params as $k => $v) {
//    		$s[] = $k . '=' . urlencode($v);
//    	}
//
//    	$url = $baseUrl . '?' . implode('&', $s) . '#wechat_redirect';
//    	header("Location:" . $url);
//    	exit;
    }

    /**
     * 判断当前访问者是否已经关注酒店人公众号
     */
    private function _checkSubscribe(){
    	$dbCommand = Yii::app()->db->createCommand();
    	//来自微信授权
    	$userInfo = $this->userInfo;
    	//来自本地数据库
    	$nickname = md5($userInfo['nickname']);
    	$sql = "select count(id) as count from wams_user_hotelier where nickname='{$nickname}' and unsubscribe_time=0";
    	$arr = $dbCommand->setText($sql)->queryRow();
    	//已经关注
    	if($arr['count'] != 0){
    		$this->isSubscribe = 1;
    	}
    }

    /**
     * 首页列表
     */
    public function actionIndex(){
    	$userList = $this->getUserList(10);
    	$this->controller->layout = 'waterfall';
    	$this->controller->render('/index',array('userList'=>$userList));
    	$this->_addVisitLog('index');
    }

    /**
     * 瀑布方式加载$limit个选手
     * @param number $limit
     * @return void
     */
    public function getUserList($limit=1,$offset=0){
    	$currentPage = Yii::app()->getRequest()->getParam('sp',0);
    	if(!empty($currentPage)){
    		$offset = 10+$currentPage*$limit;
    	}
    	$dbCommand = Yii::app()->getDb()->createCommand();
    	$dbCommand->select('id,number,fullname,cover')
    	->from($this->tbl_user)
    	->where('audit=1 and component_id = '.$this->component_id)
    	->order('add_time desc')
    	->limit($limit)
    	->offset($offset);
    	$userList = $dbCommand->queryAll();
    	$rankList = $this->_getRankList();
    	foreach((array)$userList as $k=>$v){
    		$userList[$k]['voteCount'] = 0;
    		$userList[$k]['isVoted'] = 0;
    		if(isset($rankList[$v['number']])){
    			$userList[$k]['voteCount'] = $rankList[$v['number']]['voteCount'];
    		}
    		//标记当前openid是否对该选手投过票
    		$where = array('and',"number='{$v["number"]}'","openid='{$this->userInfo["openid"]}'");;
    		if($dbCommand->reset()->select('id')->from($this->tbl_vote)->where($where)->queryAll()){
    			$userList[$k]['isVoted'] = 1;
    		}
    	}
    	if(!Yii::app()->getRequest()->getIsAjaxRequest()){
    		return $userList;
    	}
    	$return = array('status'=>1,'data'=>array('html'=>''));
    	foreach($userList as $v){
    		$return['data']['html'] .= $this->controller->renderPartial('/_userBlock',array('userInfo'=>$v),true);
    	}
    	echo json_encode($return);
    }

    /**
     * 选手详情页
     */
    public function actionDetail(){
    	$dbCommand = Yii::app()->db->createCommand();
    	$dbCommand->select('id,number,fullname,signature,cover,picture')
    	->from($this->tbl_user)
    	->limit(1);
    	$id = Yii::app()->getRequest()->getQuery('id',0);
    	if($id){
    		//列表进入
    		$dbCommand->where('id=:id',array(':id'=>$id));
    	}else{
    		//姓名或者号码搜索
    		if($filterValue = Yii::app()->getRequest()->getParam('s',0)){
    			$params = array(
    				':number'=>$filterValue,
    				':fullname'=>'%'.$filterValue.'%',
    			);
    			$dbCommand->where('audit=1 and component_id = '.$this->component_id)->andWhere(array('or','number=:number','fullname like :fullname'),$params);
    		}
    	}
    	$userDetail = $dbCommand->queryRow();
    	if($userDetail === false){
    		$referer = Yii::app()->request->getUrlReferrer();
    		$referer .= strpos($referer,'?')?'&notexist=1':'?notexist=1';
    		$this->controller->redirect($referer);
    	}
    	$userDetail['picture'] = unserialize($userDetail['picture']);
    	//票数排名信息
    	$rankList = $this->_getRankList();
    	if(isset($rankList[$userDetail['number']])){
    		$userDetail['voteCount'] = $rankList[$userDetail['number']]['voteCount'];
    		$userDetail['rank'] = $rankList[$userDetail['number']]['rank'];
    	}else{
    		$userDetail['voteCount'] = 0;
    		$lastRank = end($rankList);
    		$userDetail['rank'] = $lastRank['rank']+1;
    	}

    	//详情页分享
    	$this->_getSignPackage($userDetail['cover']);
    	$this->controller->render('/contents_page',array('userDetail'=>$userDetail));
    }

    /**
     * ajax投票
     */
    public function giveAVote(){
    	$openId = $this->userInfo['openid'];
    	$number = Yii::app()->getRequest()->getParam('number');
    	$dbCommand = Yii::app()->db->createCommand();
    	$row = $dbCommand->select('count(id)')
    	->from($this->tbl_vote)
    	->where(array('and','openid=:openid','number=:number'),array(':openid'=>$openId,':number'=>$number))
    	->queryColumn();
    	if(isset($row[0]) && $row[0]>0){
    		//已经投过
    		echo 0;
    	}else{
    		$insert = array(
    			'openid'=>$openId,
    			'component_id'=>$this->component_id,
    			'number'=>$number,
    			'add_time'=>time()
    		);
    		$affected_rows = $dbCommand->insert($this->tbl_vote,$insert);
    		echo 1;
    	}
    }

    /**
     * 选手报名
     */
    public function actionSignup(){
    	//如果此人已报名跳转到个人中心
			$this->userInfo['openid'] = 9999999999888;
    	$row = ContestUser::model()->find(array('select'=>'id,audit','condition'=>'openid=:openid','params'=>array(':openid'=>$this->userInfo['openid'])));
    	if(!empty($row)){
    		Yii::app()->getRequest()->redirect('index.php?a=viewProfile&id='.$row->id.'&audit='.$row->audit);
    	}
    	$model = new ContestUser();
    	$model->openid = $this->userInfo['openid'];
    	if(Yii::app()->getRequest()->getIsPostRequest()){
    		$insertData = $picArr = array();
    		//封面和展示图片上传处理
    		$uploadPath1 = $this->uploadPath.'/cover/';
    		$uploadPath2 = $this->uploadPath.'/picture/'.$this->userInfo['openid'].'/';
    		!is_dir($uploadPath1) && mkdir($uploadPath1,0777,true) &&chmod($uploadPath1,0777);
    		!is_dir($uploadPath2) && mkdir($uploadPath2,0777,true) &&chmod($uploadPath2,0777);
    		if($tmpPath = Yii::app()->getRequest()->getPost('p_img1')){
    			$savePath = $uploadPath1.uniqid().'.jpg';
    			if(copy($tmpPath, $savePath)){
    				unlink($tmpPath);
    				$insertData['cover'] = $savePath;
    			}
    		}
    		foreach(array('p_img2','p_img3','p_img4','p_img5') as $v){
    			if($tmpPath = Yii::app()->getRequest()->getPost($v)){
    				$savePath = $uploadPath2.uniqid().'.jpg';
    				if(copy($tmpPath,$savePath)){
    					unlink($tmpPath);
    					$picArr[] = $savePath;
    				}
    			}
    		}
    		$insertData['picture'] = serialize($picArr);
    		$insertData['fullname'] = Yii::app()->getRequest()->getPost('fullname','');
    		$insertData['mobile'] = Yii::app()->getRequest()->getPost('mobile',0);
    		$insertData['signature'] = Yii::app()->getRequest()->getPost('signature','');
    		$row = ContestUser::model()->find(array('select'=>'max(number) as number'));
    		if($row === null){
    			$insertData['number'] = '001';
    		}else{
    			$insertData['number'] = str_pad($row->number+1, 3,'0',STR_PAD_LEFT);
    		}
    		$insertData['component_id'] = $this->component_id;
    		$insertData['add_time'] = time();
    		$insertData['audit'] = 0;
    		$model->setAttributes($insertData,false);
    		if($this->_customValidate($model) && $model->save()){
    			Yii::app()->getRequest()->redirect(Yii::app()->getRequest()->getBaseUrl().'/index.php?a=viewProfile&audit=0&id='.$model->id);
    		}
    	}
    	$model->picture = unserialize($model->picture);
    	$this->controller->render('/join_page',array('model'=>$model));
    	Yii::app()->end();
    }

    /**
     * 报名结果页(个人中心)
     */
    public function actionViewProfile(){
    	$id = Yii::app()->getRequest()->getQuery('id',0);
    	if(!$id || !($model = $this->_loadModel('ContestUser',$id))){
    		//$this->_userNotExist();
    	}
    	//分享链接点击过来转向到详情页
    	if(Yii::app()->getRequest()->getUrlReferrer() === null){
    		$this->controller->redirect('/activity/20150510/index.php?a=detail&id='.$id);
    	}
    	$model->picture = unserialize($model->picture);
    	$rankList = $this->_getRankList();
    	$rankInfo = array();
    	if(!isset($rankList[$model->number])){
    		$rankInfo['voteCount'] = 0;
    		$rankList = array_keys($rankList);
    		$rankInfo['rank'] = empty($rankList)?1:max($rankList)+1;
    	}else{
    		$rankInfo['voteCount'] = $rankList[$model->number]['voteCount'];
    		$rankInfo['rank'] = $rankList[$model->number]['rank'];
    	}

    	//报名审核过的用户可以分享自己的个人中心
    	if($model->audit == 1){
    		$shareAble = 1;
    		$this->_getSignPackage($model->cover);
    	}else{
    		$shareAble = 0;
    	}
    	$this->controller->render('/myphoto_page',array('model'=>$model,'rankInfo'=>$rankInfo,'shareAble'=>$shareAble));
    }

    /**
     * 修改报名信息
     */
    public function actionEditProfile(){
    	$id = Yii::app()->getRequest()->getQuery('id');
    	$model = $this->_loadModel('ContestUser',$id);
    	if(!$model){
    		$this->_userNotExist();
    	}
    	if(Yii::app()->getRequest()->getIsPostRequest()){
    		//封面和展示图片上传处理
    		$uploadPath1 = $this->uploadPath.'/cover/';
    		$uploadPath2 = $this->uploadPath.'/picture/'.$this->userInfo['openid'].'/';
    		!is_dir($uploadPath1) && mkdir($uploadPath1,0777,true) &&chmod($uploadPath1,0777);
    		!is_dir($uploadPath2) && mkdir($uploadPath2,0777,true) &&chmod($uploadPath2,0777);
    		if($tmpPath = Yii::app()->getRequest()->getPost('p_img1')){
    			$savePath = $uploadPath1.uniqid().'.jpg';
    			if($tmpPath != $model->cover && copy($tmpPath, $savePath)){
    				unlink($tmpPath);
    				$model->cover = $savePath;
    			}
    		}elseif(!empty($model->cover)){
    			$model->cover = '';
    		}
    		$model->picture = unserialize($model->picture);
    		foreach(array('p_img2','p_img3','p_img4','p_img5') as $k=>$v){
    			if($tmpPath = Yii::app()->getRequest()->getPost($v)){
    				$savePath = $uploadPath2.uniqid().'.jpg';
    				if(!in_array($tmpPath,(array)$model->picture) && copy($tmpPath, $savePath)){
    					unlink($tmpPath);
    					$picture = $model->picture;
    					$picture[] = $savePath;
    					$model->picture = $picture;
    				}
    			}elseif(!empty($model->picture[$k])){
    				$picture = $model->picture;
    				unset($picture[$k]);
    				$model->picture = $picture;
    			}
    		}
    		$model->picture = serialize($model->picture);
    		$updateData = array(
    			'fullname'=>Yii::app()->getRequest()->getPost('fullname',''),
    			'mobile'=>Yii::app()->getRequest()->getPost('mobile',0),
    			'signature'=>Yii::app()->getRequest()->getPost('signature',''),
    		);
    		$model->setAttributes($updateData);
    		if($model->validate() && $model->update()){
    			Yii::app()->getRequest()->redirect(Yii::app()->getRequest()->getBaseUrl().'/index.php?a=viewProfile&id='.$id);
    		}
    	}

    	$model->picture = unserialize($model->picture);
    	$this->controller->render('/updatephoto_page',array('model'=>$model));
    }

    /**
     * 赛事介绍
     */
    public function actionContestIntro(){
    	$intro = array(
    		'registerDuration'=>$this->registDuration1,
    		'voteDuration'=>$this->voteDuration2,
    		'activityRule'=>$this->activityRule,
				'activityRule2'=>$this->activityRule2,
    		'award'=>$this->award,
				'award2'=>$this->award2,

    		'interpretation'=>$this->interpretation,
    	);
    	$this->controller->render('/info_page',array('intro'=>$intro));
    }

    /**
     * 排名榜
     */
    public function actionRank(){
    	$rankList = $this->getRankList(10);
    	$this->controller->layout = 'waterfall';
    	$this->controller->render('/rank_page',array('rankList'=>$rankList));
    }

    /**
     * 获取指定个数名次默认10个
     * @param number $limit
     * @return unknown
     */
    public function getRankList($limit=10){
    	$rankList = $this->_getRankList();
    	$offset = Yii::app()->getRequest()->getParam('sp',0);
    	$rankList = array_chunk($rankList,$limit,true);
    	$rankList = isset($rankList[$offset])?$rankList[$offset]:array();
    	$dbCommand = Yii::app()->getDb()->createCommand();
    	//根据名次拉取用户信息
    	$userList = $dbCommand
    	->select('id,number,fullname')
    	->from($this->tbl_user)
    	->where(array('and','audit=1',array('in','number',array_keys($rankList))))
    	->queryAll();
    	foreach($userList as $v){
    		$rankList[$v['number']]['id'] = $v['id'];
    		$rankList[$v['number']]['number'] = $v['number'];
    		$rankList[$v['number']]['fullname'] = $v['fullname'];
    	}
    	if(!Yii::app()->getRequest()->getIsAjaxRequest()){
    		return $rankList;
    	}
    	//ajax返回
    	$return = array('status'=>1,'data'=>array('html'=>''));
    	foreach($rankList as $v){
    		$return['data']['html'] .= $this->controller->renderPartial('/_rankBlock',array('rankInfo'=>$v),true);
    	}
    	echo json_encode($return);
    }

    /**
     * 上传图片到临时目录
     * 图片压缩要求最宽400最高600px
     */
    public function upload(){
    	$tagName = array_keys($_FILES);
		var_dump($_FILES);
    	if(!empty($tagName)){
    		$tagName = $tagName[0];
    		$uploadedFile = $this->uploadPath.'/tmp/'.$tagName.$this->userInfo['openid'];
    		if(move_uploaded_file($_FILES[$tagName]['tmp_name'], $uploadedFile)){
    			require 'util/image.php';
    			Image::thumb($uploadedFile,$uploadedFile,'','400','600');
    		}
    	}
    }

    /**
     * js分享成功回调，统计页面分享数据
     */
    public function shareSuccess(){}

    public function __call($name, array $params = array()){
    	$methodName = 'action' . ucfirst($name);
    	if (method_exists($this, $methodName)) {
    		call_user_func_array(array($this, $methodName), $params);
    	} else {
    		header('HTTP/1.1 404 Not Found');
    		print '404 Not Found';
    		exit;
    	}
    }

    private function _addClip(){
    	/**
    	 * activity duration clip
    	 */
    	$this->controller->beginClip('duration');
//     	echo <<<EOT
//     			<span class="font22 line_h36 dis_b fl">报名时间：{$this->registDuration}</span>
// 				<span class="fonts_Arial ml10 font23 line_h40 dis_b fl"></span>
//            		<span class="font22 line_h26 dis_b fl">投票时间：{$this->voteDuration}</span>
//            		<span class="fonts_Arial ml10 font23 line_h30 dis_b fl"></span>
// EOT;
    	$this->controller->endClip();

    	$statData = file_get_contents(Yii::getPathOfAlias('application').'/views/20150510/stat.txt');
    	$statData = unserialize($statData);

    	if(empty($statData['userCount'])){
    		$statData['userCount'] = ContestUser::model()->count('component_id=:component_id',array(':component_id'=>$this->component_id));
    	}
    	if(empty($statData['voteCount'])){
    		$statData['voteCount'] = ContestVotelog::model()->count('component_id=:component_id',array(':component_id'=>$this->component_id));
    	}
    	if(empty($statData['visitCount'])){
    		$statData['visitCount'] = ContestStatistic::model()->count('component_id=:component_id',array(':component_id'=>$this->component_id));
    	}
    	/**
    	 * statistic data clip
    	 */
    	$this->controller->beginClip('statData');
    	echo <<<EOF
    			<li class="mt4">
             		<span class="col_01 line_h32 font24">参赛选手</span><br>
             		<span class="col_01 line_h36 font_Br font30">{$statData['userCount']}</span>
           		</li>
           		<li class="mt4 ml12">
             		<span class="col_01 line_h32 font24">累计红旗</span><br>
             		<span class="col_01 line_h36 font_Br font30">{$statData['voteCount']}</span>
           		</li>
           		<li class="mt4 ml12">
             		<span class="col_01 line_h32 font24">访问量</span><br>
             		<span class="col_01 line_h36 font_Br font30">{$statData['visitCount']}</span>
           		</li>
EOF;
    	$this->controller->endClip();
    	/**
    	 * public data used in templates
    	 */
    	$this->controller->clips['publicData'] = array(
    		'openid'=>$this->userInfo['openid'],
    		'uploadPath'=>$this->uploadPath,
    	);
    }

    /**
     * 统计页面(首页)访问量
     * @param string $page
     */
    private function _addVisitLog($page='index'){
    	$insert = array(
    		'openid'=>$this->userInfo['openid'],
    		'component_id'=>$this->component_id,
    		'page'=>$page,
    		'add_time'=>time(),
    	);
    	Yii::app()->getDb()->createCommand()->insert($this->tbl_visit,$insert);
    }

    /**
     * 所有参赛选手名次列表
     * @return array
     */
    private function _getRankList(){
    	$dbCommand = Yii::app()->getDb()->createCommand();
    	$countList = $dbCommand
    	->select('number,count(id) as count')
    	->from($this->tbl_vote)
    	->group('number')
    	->order('count desc')
    	->queryAll();
    	$userList = $dbCommand
    	->setText('select number,vote_show as count from wams_contest_user where audit=1 and vote_show>0')
    	->queryAll();
    	$userListAssoc = $countListAssoc = array();
    	foreach($countList as $v){
    		$countListAssoc[$v['number']] = $v;
    	}
    	foreach($userList as $v){
    		$userListAssoc[$v['number']] = $v;
    	}
    	//考虑后台修改过的票数
    	$rankList = array_merge($countListAssoc,$userListAssoc);
    	unset($countList,$countListAssoc,$userList,$userListAssoc);
    	$rankList = array_values($rankList);
    	//排序
    	uasort($rankList,function($x,$y){return $x['count']<$y['count'];});
    	$rankList = array_values($rankList);
    	//添加名次
    	$rank = 1;
    	$rankListAssoc = array();
    	foreach($rankList as $k=>$v){
    		if(isset($rankList[$k-1]) && $v['count'] == $rankList[$k-1]['count']){//票数重叠
    			$rank--;
    			$rankListAssoc[$v['number']] = array('voteCount'=>$v['count'],'rank'=>$rank);
    		}else{
    			$rankListAssoc[$v['number']] = array('voteCount'=>$v['count'],'rank'=>$rank);
    		}
    		$rank++;
    	}
    	unset($rankList);
    	return $rankListAssoc;
    }

    private function _loadModel($name,$id){
    	switch($name){
    		case 'ContestUser':
    			return ContestUser::model()->findByPk($id);
    			break;
    	}
    }

    private function _userNotExist(){
    	Yii::app()->end('Sorry, The competitor is not exist.');
    }

    /**
     * 自定义一些字段验证规则
     * @param object $model
     */
    private function _customValidate($model){
    	if(!preg_match('/^([\x80-\xff]|[a-zA-Z0-9]|\.){1,20}$/i', $model->fullname)){
    		$model->addError('fullname','姓名格式不对');//要求.字母汉字数字20字符以内
    		return false;
    	}
    	if(!preg_match('/^1[\d]{10}$/', $model->mobile)){
    		$model->addError('mobile','手机号格式不对');//要求11位数字开头是1
    		return false;
    	}
    	if(!preg_match('/^([\x80-\xff]|[a-zA-Z0-9]|\.){1,100}$/i', $model->signature)){
    		$model->addError('signature','个性签名格式不对');//个性签名只允许字母汉字数字和.100字符以内
    		return false;
    	}
    	if($model->cover==''){
    		$model->addError('cover','封面不能空');
    		return false;
    	}
    	return true;
    }

    /**
     * ajax判断是否已经关注
     * 如果未关注返回关注引导页面
     */
    public function getSubscribe(){
    	if($this->isSubscribe){
    		echo 0;
    	}else{
    		echo $this->subscribeUrl;
    	}
    }

    /**
     * 生成jssdk配置
     */
    private function _getSignPackage($cover){
    	$signPackage = common\apis\veryeast\Weixin::getSignPackage($this->jiudianrenConfig['appId'], $this->jiudianrenConfig['appSecret']);
    	$signPackage['title'] = '追忆最嗨学生时代';
    	$signPackage['desc'] = '小的们，快来给女王大人我插红旗吧！';
    	$signPackage['imgUrl'] = Yii::app()->request->getHostInfo().'/activity/20150510'.trim($cover,'.');
    	$this->controller->clips['signPackage'] = $signPackage;
    	$this->controller->layout = 'share';
    }

}
