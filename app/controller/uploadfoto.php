<?php

require_once(LIBS.'twitteroauth/tmhOAuth-master/tmhOAuth.php');

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

    // pr($_SESSION);
		global $CONFIG, $basedomain;

    FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
    $helper = new FacebookRedirectLoginHelper($basedomain.'uploadfoto/index/?get=true');
    $session = false;
    if(isset($_GET['get'])){
      $session = $helper->getSessionFromRedirect();
      
      /* Buat posting message */
      
      // $post = (new FacebookRequest(
     //      $session, 'POST', '/me/feed',array ('message' => 'This is a test message from bot',)
     //    ))->execute()->getGraphObject();


      $album = (new FacebookRequest(
                  $session,'GET','/me/photos'
                ))->execute()->getGraphObject();
      /*
      $album = (new FacebookRequest(
                  $session,'GET','/me/albums'
                ))->execute()->getGraphObject();*/
      

      $userAlbum = $album->getPropertyAsArray('data');

     
      foreach ($userAlbum as $key => $value) {
       
        $data[$key]['id'] = $value->getProperty('id');
        $data[$key]['from'] = $value->getProperty('from');
        $data[$key]['name'] = $value->getProperty('name');
        $data[$key]['picture'] = $value->getProperty('picture');
        $data[$key]['source'] = $value->getProperty('source');
        $data[$key]['height'] = $value->getProperty('height');
        $data[$key]['width'] = $value->getProperty('width');
        // $data[$key]['images'] = $value->getProperty('images');

      }
      // pr($data);
      $this->view->assign('albumfb',$data);

    }else{
      $loginUrl = $helper->getLoginUrl(array('scope' => 'user_photos,publish_actions',)); 
      $this->view->assign('accessUrlFb',$loginUrl);
    }
        


		if (isset($_SESSION['fb-logout'])){
      $this->view->assign('fbalbum',true);
    }else{
      $this->view->assign('fbalbum',false);
    }

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

		global $CONFIG, $basedomain, $IMAGE, $LOCALE;

		// pr($_SESSION);
		
    $file_path = "";
    $getMyPhoto = $this->contentHelper->getMyPhoto();
    if ($getMyPhoto){
      // pr($getMyPhoto);
      $file_path = $IMAGE[0]['imageframed'].$getMyPhoto['thumbnail'];

      $this->view->assign('myfoto',$getMyPhoto);
    }


    if (isset($_SESSION['fb-logout'])){

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
        $arr["message"] = $LOCALE['fb']['status-message'];

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
        $this->view->assign('accessUrl',$loginUrl);
      }
    
    }else{

    
        if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        
          $this->view->assign('accessUrl',$basedomain.'uploadfoto/twitterRedirectShare');
        }
        

    }
		
  	return $this->loadView('upload/share');
  }

  function twitterCallBackShare()
    {

        global $CONFIG, $basedomain, $IMAGE;
        // require_once(LIBS.'twitteroauth/twitteroauth/twitteroauth.php');
        
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
          $_SESSION['oauth_status'] = 'oldtoken';
          // header('Location: ./clearsessions.php');
          redirect($basedomain.'uploadfoto');
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth($CONFIG['twitter']['CONSUMER_KEY'], $CONFIG['twitter']['CONSUMER_SECRET'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        $_SESSION['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) {
          /* The user has been verified and the access tokens can be saved for future use */
            $_SESSION['status'] = 'verified';
          // header('Location: ./index.php');
            // pr('berhasil login');

            /* Get user access tokens out of the session. */
            $access_token = $_SESSION['access_token'];

            /* Create a TwitterOauth object with consumer/user tokens. */
            $connection = new TwitterOAuth($CONFIG['twitter']['CONSUMER_KEY'], $CONFIG['twitter']['CONSUMER_SECRET'], $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* If method is set change API call made. Test is called by default. */
            $content = $connection->get('account/verify_credentials');
            // pr($content);
            
            
            $getMyPhoto = $this->contentHelper->getMyPhoto();
            if ($getMyPhoto){
              // pr($getMyPhoto);
              $file_path = $IMAGE[0]['imageframed'].$getMyPhoto['thumbnail'];

            }


            $params['media[]'] = "@{$file_path}";
            $params['status'] = 'test API image upload ';
            
            
            $access_token = $_SESSION['access_token'];

            $tmhOAuth = new \tmhOAuth(array(
                        'consumer_key' => $CONFIG['twitter']['CONSUMER_KEY'],
                        'consumer_secret' => $CONFIG['twitter']['CONSUMER_SECRET'],
                        'token' => $access_token['oauth_token'],
                        'secret' => $access_token['oauth_token_secret'],
                        ));

            $response = $tmhOAuth->user_request(array(
                        'method' => 'POST',
                        'url' => $tmhOAuth->url("1.1/statuses/update_with_media"),
                        'params' => $params,
                        'multipart' => true
                        ));
            
            
            redirect($basedomain.'uploadfoto/changephoto');
        } else {
          /* Save HTTP status for error dialog on connnect page.*/
          // header('Location: ./clearsessions.php');
          redirect($basedomain.'login/index');
        }
    }


    function twitterRedirectShare()
    {

        global $CONFIG,$basedomain;

        // require_once(LIBS.'twitteroauth/twitteroauth/twitteroauth.php');
        
        $twitterRedirectShare = $basedomain.'uploadfoto/twitterCallBackShare/';

        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth($CONFIG['twitter']['CONSUMER_KEY'], $CONFIG['twitter']['CONSUMER_SECRET']);
         
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken($twitterRedirectShare);

        /* Save temporary credentials to session. */
        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
         
        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
          case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            // header('Location: ' . $url); 
            redirect($url);
            break;
          default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
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

  function getFromFb()
  {
    global $IMAGE;
    
    $fileName = _p('fileName'); 
    $idPhoto = sha1($fileName).'.jpg'; 

      $url = $fileName;
      $img = $IMAGE[0]['pathfile'].$idPhoto;

      $download = file_put_contents($img, file_get_contents($url));

      
      if ($download>0){

        $saveUserFoto = $this->contentHelper->updateUserFoto(false,$idPhoto,true);

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
