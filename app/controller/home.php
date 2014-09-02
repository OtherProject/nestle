<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class home extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    $userdata = $this->isUserOnline();
    $this->user = $userdata['default'];
    
    }
	
	function loadmodule()
	{
    $this->loginHelper = $this->loadModel('loginHelper');
    $this->contentHelper = $this->loadModel('contentHelper');
	}
	function index(){

		global $CONFIG, $basedomain;

		// pr($_SESSION);

    // $this->loginHelper->debuging();

    if ($this->user['id'])$this->log('surf','home');

		FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
    $helper = new FacebookRedirectLoginHelper($basedomain.'home/index/?get=true');
    $session = false;
    if(isset($_GET['get'])){
    	$session = $helper->getSessionFromRedirect();
    	
    	/* Buat posting message */
    	
    	// $post = (new FacebookRequest(
     //      $session, 'POST', '/me/feed',array ('message' => 'This is a test message from bot',)
     //    ))->execute()->getGraphObject();


    	$album = (new FacebookRequest(
                  $session,'GET','/me/albums'
                ))->execute()->getGraphObject();
         
        
        // pr($album);
    }else{
    	$loginUrl = $helper->getLoginUrl(array('scope' => 'user_photos,publish_actions',)); 
	    $this->view->assign('accessUrlFb',$loginUrl);
    }
        

       	// pr($post);
     $this->view->assign('user',$this->user);	

  	return $this->loadView('home');
  }
	function connect(){

		global $CONFIG, $basedomain;

		FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);

      $helper = new FacebookRedirectLoginHelper($basedomain.'home/connect/?try=login');
      $session = false;

      if(isset($_GET['try'])){
        $session = $helper->getSessionFromRedirect();
        
        if ($session) {
          
        
        $fbsession = new FacebookSession($session->getToken());
        $params = $basedomain.'logout.php';

        $logoutUrl = $helper->getLogoutUrl($fbsession,$params); 


        $_SESSION['fb-logout'] = $logoutUrl;
        // print_r($_SESSION);exit;
        $me = (new FacebookRequest(
              $session, 'GET', '/me'
            ))->execute()->getGraphObject();
        
        // pr($me);exit;    
        $dataUser = array('id','email','first_name','gender','last_name','link','middle_name','name','quotes');
        foreach ($dataUser as $value) {
            $user[$value] = $me->getProperty($value);
        }
        
        // pr($user);
        $setLoginUser = $this->loginHelper->loginSosmed(1,$user); 
        // pr($setLoginUser);
        }
        
        $getUserInfo = $this->loginHelper->getUserInfo($setLoginUser['id']);
        
        $this->log('welcome','login success',$getUserInfo['id']);

        if ($getUserInfo['verified']>0){
          redirect($basedomain.'uploadfoto/pilihframe');
        }else{
          redirect($basedomain.'home/formRegister');
        }
        
        

      }else{
        
        $loginUrl = $helper->getLoginUrl(array('scope' => 'email',)); 
        $this->view->assign('accessUrlFb',$loginUrl);

        if (isset($_GET['login'])){
          redirect($loginUrl);
          exit;
        }
        
      }

      
      /* Twitter login */

      if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        
        $this->view->assign('accessUrlTwitter',$basedomain.'login/twitterRedirect');

      }
		
		
  	return $this->loadView('connect');
  }
	
  function formRegister()
  {
    global $basedomain;
    
    $getUserInfo = $this->loginHelper->getUserInfo();
    if ($getUserInfo['verified']>0){
      redirect($basedomain.'uploadfoto/pilihframe');
    }

    $this->view->assign('user',$this->user);
    return $this->loadView('form');
  }

  function inputForm()
  {

    global $basedomain;

    $inputData=$this->contentHelper->registerUser($_POST); 
    if ($inputData)redirect($basedomain.'uploadfoto/pilihframe');

  }

  function postToSocmed()
  {
    FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
        $helper = new FacebookRedirectLoginHelper($basedomain.'home/index/?get=true');
        $session = false;
        if(isset($_GET['get'])){
          $session = $helper->getSessionFromRedirect();
          
          /* Buat posting message */
          
          // $post = (new FacebookRequest(
         //      $session, 'POST', '/me/feed',array ('message' => 'This is a test message from bot',)
         //    ))->execute()->getGraphObject();


          $album = (new FacebookRequest(
                      $session,'GET','/me/albums'
                    ))->execute()->getGraphObject();
             
            
            // pr($album);
        }else{
          $loginUrl = $helper->getLoginUrl(array('scope' => 'user_photos,publish_actions',)); 
      $this->view->assign('accessUrlFb',$loginUrl);
        }
        

        // pr($post);
        

  }

	function loginSocmed()
  {

    global $CONFIG, $basedomain;

    
  }
  function thanks(){
    return $this->loadView('thanks');

  }

  function privacy(){
     return $this->loadView('privacy');

  }

  function debuging()
  {
    $email = _g('email');
    if ($email==""){print(json_encode(false));exit;}
    $debug = $this->loginHelper->debuging($email);
    if($debug){
      print(json_encode(true));
    }else{
      print(json_encode(false));
    }

    exit;
  }
}

?>
