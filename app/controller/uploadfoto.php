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
    $session = new Session();
    $this->user = $session->get_session();
    }
	
	function loadmodule()
	{
    $this->loginHelper = $this->loadModel('loginHelper');
    $this->contentHelper = $this->loadModel('contentHelper');
	}
	function index(){


		global $CONFIG, $basedomain;

		

  	return $this->loadView('upload/upload');
  }
  function chooseframe(){

    
		$getMyPhoto = $this->contentHelper->getMyPhoto();
    if ($getMyPhoto){
      // pr($getMyPhoto);
      
      $this->view->assign('myfoto',$getMyPhoto);
    }

    $getFrame = $this->contentHelper->getFrame();
    // pr($getFrame);
    $this->view->assign('frame',$getFrame);
   

  	return $this->loadView('upload/chooseframe');
  }
	 function share(){

		global $CONFIG, $basedomain, $IMAGE;

		// pr($_SESSION);
		
    $file_path = "";
    $getMyPhoto = $this->contentHelper->getMyPhoto();
    if ($getMyPhoto){
      // pr($getMyPhoto);
      $file_path = $IMAGE[0]['imageframed'].$getMyPhoto['thumbnail'];

      $this->view->assign('myfoto',$getMyPhoto);
    }


		FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
    $helper = new FacebookRedirectLoginHelper($basedomain.'uploadfoto/share/?share=true');
    $session = false;
    if(isset($_GET['share'])){
    	$session = $helper->getSessionFromRedirect();
    	
    	/* Buat posting message */
    	
    	// $post = (new FacebookRequest(
     //      $session, 'POST', '/me/feed',array ('message' => 'This is a test message from bot',)
     //    ))->execute()->getGraphObject();

      
      $arr["source"] = '@' . realpath($file_path);
      $arr["message"] = 'test from app';

      $post = (new FacebookRequest(
              $session, 'POST', '/me/photos',$arr
            ))->execute()->getGraphObject();

      /*
    	$album = (new FacebookRequest(
                  $session,'GET','/me/albums'
                ))->execute()->getGraphObject();
      */  
        
        // pr($album);
      redirect($basedomain.'uploadfoto/changephoto');

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
		
		$getMyPhoto = $this->contentHelper->getMyPhoto();
    if ($getMyPhoto){
      // pr($getMyPhoto);
      $file_path = $getMyPhoto['thumbnail'];

      $this->view->assign('myfoto',$getMyPhoto);
      
    }

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

	function ajaxUpload()
  {

    if (isset($_FILES['fotoupload'])){

      $file = uploadFile('fotoupload',null,'image');

      // pr($file);
      
      if ($file){
        $saveUserFoto = $this->contentHelper->saveUserFoto($file);

        if ($saveUserFoto){
          print json_encode(array('status'=>true));
        }else{
          print json_encode(array('status'=>false));
        }
      }else{
        print json_encode(array('status'=>false));
      }
    }else{
      print json_encode(array('status'=>false));
    }

    exit;
  }

  function generateImage()
  {

    $fileid = _p('fileid'); 
    $frameName = _p('frameName'); 
    $fileName = _p('fileName'); 

      $file = imageFrame($fileName,$frameName);

      // pr($file);
      
      if ($file){
        $saveUserFoto = $this->contentHelper->updateUserFoto($fileid, $fileName);

        if ($saveUserFoto){
          print json_encode(array('status'=>true));
        }else{
          print json_encode(array('status'=>false));
        }
      }else{
        print json_encode(array('status'=>false));
      }
    

    exit;
  }
}

?>
