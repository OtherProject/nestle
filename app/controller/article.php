<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;




class article extends Controller {
	
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

		$getArticle = $this->contentHelper->getArticle();
    if ($getArticle){
      foreach ($getArticle as $key => $value) {
        $getArticle[$key]['changeDate'] = changeDate($value['posted_date']);
      }
    }
		// pr($getArticle);
    $this->view->assign('article',$getArticle);

  	return $this->loadView('article/index');
  }

  function loginFbValid(){
    global $CONFIG, $basedomain;

    FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);

      $helper = new FacebookRedirectLoginHelper($basedomain.'article/loginFbValid/');
      // $session = false;

        try{
          $session = $helper->getSessionFromRedirect();
          
        }catch(FacebookRequestException $ex){

        }catch(\Exception $ex) {

        }


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

            $getUserInfo = $this->loginHelper->getUserInfo($setLoginUser['id']);
            
            $this->log('welcome','login success',$getUserInfo['id']);

            if ($getUserInfo['verified']>0){
              redirect($basedomain.'uploadfoto/pilihframe');
            }else{
              redirect($basedomain.'home/formRegister');
            }

            exit;
          }
          
        
  }

	function detail(){

		global $CONFIG, $basedomain;
      // pr($CONFIG);
 
      FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
      $helper = new FacebookRedirectLoginHelper($basedomain.'article/detail/?try=login');
      // $session = false;

      if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
        // create new session from saved access_token
        $session = new FacebookSession( $_SESSION['fb_token'] );
        // validate the access_token to make sure it's still valid
        try {
          if ( !$session->validate() ) {
          $session = null;
          }
        } catch ( Exception $e ) {
        // catch any exceptions
        $session = null;
        }
      }

      if ( !isset( $session ) || $session === null ) {
        // no session exists
        
        try {
        $session = $helper->getSessionFromRedirect();
        } catch( FacebookRequestException $ex ) {
        // When Facebook returns an error
        // handle this better in production code
        print_r( $ex );
        } catch( Exception $ex ) {
        // When validation fails or other local issues
        // handle this better in production code
        print_r( $ex );
        }
      }

      if ( isset( $session ) ) {
        if ($session) {
         
            $fbsession1 = new FacebookSession($session->getToken());
            $params = $basedomain.'logout.php';

            $logoutUrl = $helper->getLogoutUrl($fbsession1,$params); 


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

            $getUserInfo = $this->loginHelper->getUserInfo($setLoginUser['id']);
            
            $this->log('welcome','login success',$getUserInfo['id']);

            if ($getUserInfo['verified']>0){
              redirect($basedomain.'uploadfoto/pilihframe');
            }else{
              redirect($basedomain.'home/formRegister');
            }

            exit;
          
        }

      } else {
        $loginUrl = false;  
        $loginUrl = $helper->getLoginUrl(array('scope' => 'email',)); 
        $this->view->assign('accessUrlFb',$loginUrl);
      }


      
     
      /* Twitter login */

      if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        
        $this->view->assign('accessUrlTwitter',$basedomain.'login/twitterRedirect');

      }

      $id = _g('id');
      
		  $getArticle = $this->contentHelper->getArticle($id);
      if ($getArticle){
        foreach ($getArticle as $key => $value) {
          $getArticle[$key]['changeDate'] = changeDate($value['posted_date']);
          $getArticle[$key]['content'] = html_entity_decode($value['content']);
        }
      }

      $getNextArticle = $this->contentHelper->getNextArticle($id);
      $getRandomArticle = $this->contentHelper->getRandomArticle($id);
      if ($getRandomArticle){
        foreach ($getRandomArticle as $key => $value) {
          $getRandomArticle[$key]['changeDate'] = changeDate($value['posted_date']);
          $getRandomArticle[$key]['content'] = html_entity_decode($value['content']);
        }
      }
      // pr($getNextArticle);
      $this->view->assign('article',$getArticle);
      $this->view->assign('prevNextArticle',$getNextArticle);
      $this->view->assign('getRandomArticle',$getRandomArticle);
      $this->view->assign('user',$this->user);

    	return $this->loadView('article/detail');
    }

  function ajax()
  {

    $page = intval(_p('page'));
    $getArticle = $this->contentHelper->getArticle(false,$page);
    if ($getArticle){
      foreach ($getArticle as $key => $value) {
        $getArticle[$key]['changeDate'] = changeDate($value['posted_date']);
      }

      print json_encode(array('status'=>true, 'res'=>$getArticle));
    }else{

      print json_encode(array('status'=>false));
    }
    

    exit;
  }
	
	
}

?>
