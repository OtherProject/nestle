<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class uploadfoto extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
    $this->loginHelper = $this->loadModel('loginHelper');
	}
	function index(){

		global $CONFIG, $basedomain;

		// pr($_SESSION);
		
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
      	

  	return $this->loadView('upload/upload');
  }
  function chooseframe(){

		global $CONFIG, $basedomain;

		// pr($_SESSION);
		
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
      	

  	return $this->loadView('upload/chooseframe');
  }
	 function share(){

		global $CONFIG, $basedomain;

		// pr($_SESSION);
		
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
      	

  	return $this->loadView('upload/share');
  }
   function changephoto(){

		global $CONFIG, $basedomain;

		// pr($_SESSION);
		
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
      	

  	return $this->loadView('upload/changephoto');
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
}

?>
