<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class login extends Controller {
	
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
        $this->userHelper = $this->loadModel('userHelper');
        $this->loginHelper = $this->loadModel('loginHelper');
        $this->activityHelper = $this->loadModel('activityHelper');
        // $this->helper_model = $this->loadModel('helper_model');

	}
	
	function index(){

        global $CONFIG, $basedomain;

        
        FacebookSession::setDefaultApplication($CONFIG['fb']['appId'], $CONFIG['fb']['secret']);
        $helper = new FacebookRedirectLoginHelper($basedomain.'login/index/?try=login');
        $session = false;
        if(isset($_GET['try'])){
            $session = $helper->getSessionFromRedirect();
             // pr($session);
            if ($session) {
              // Logged in
              // echo '<pre>';
              
            $fbsession = new FacebookSession($session->getToken());
            $params = $basedomain.'logout.php';

            $logoutUrl = $helper->getLogoutUrl($fbsession,$params); 


            $_SESSION['fb-logout'] = $logoutUrl;
            // print_r($_SESSION);exit;
            $me = (new FacebookRequest(
                  $session, 'GET', '/me'
                ))->execute()->getGraphObject();
                
            $dataUser = array('id','email','first_name','gender','last_name','link','middle_name','name','quotes');
            foreach ($dataUser as $value) {
                $user[$value] = $me->getProperty($value);
            }
            
            $setLoginUser = $this->loginHelper->loginSosmed(1,$user); 

            }
            // $post = (new FacebookRequest(
            //   $session, 'POST', '/me/feed',array ('message' => 'This is a test message',)
            // ))->execute()->getGraphObject();

            // pr($post);exit;
            redirect($basedomain);
            
            $this->view->assign('login',true);

        }else{
            
            $loginUrl = $helper->getLoginUrl(array('scope' => 'email,user_photos,publish_actions',)); 
            $this->view->assign('accessUrlFb',$loginUrl);
            

        }

        
        
        // pr($album);
        /* Twitter login */

        if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
            // header('Location: ./clearsessions.php');
         
            
            $this->view->assign('accessUrlTwitter',$basedomain.'login/twitterRedirect');

        }
        
        return $this->loadView('login');
    }
	
    function fbAPIV3()
    {
        $facebook = new Facebook(array(
                      'appId'  => $CONFIG['fb']['appId'],
                      'secret' => $CONFIG['fb']['secret'],
                    ));
        
        $user = $facebook->getUser();

        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');

                
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            } 
        }

        if ($user) {

            pr($user_profile);
            $logoutUrl = $facebook->getLogoutUrl();
            $this->view->assign('user',$user);
            $this->view->assign('accessUrlFb',$logoutUrl);
        } else {
            $loginUrl = $facebook->getLoginUrl();
             $this->view->assign('accessUrlFb',$loginUrl);
        }

    }

    function twitterCallBack()
    {

        global $CONFIG, $basedomain;
        // require_once(LIBS.'twitteroauth/twitteroauth/twitteroauth.php');
        
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
          $_SESSION['oauth_status'] = 'oldtoken';
          // header('Location: ./clearsessions.php');
          redirect($basedomain.'login/index');
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
            
            $dataUser = array('id_str','name','screen_name','description','url','location');
            foreach ($dataUser as $value) {

                if ($value=='id_str'){
                    $user['id'] = $content->$value;
                }else{
                    $user[$value] = $content->$value;
                }
                
            }

            

            $setLoginUser = $this->loginHelper->loginSosmed(2,$user); 


            redirect($basedomain.'uploadfoto');
        } else {
          /* Save HTTP status for error dialog on connnect page.*/
          // header('Location: ./clearsessions.php');
          redirect($basedomain.'login/index');
        }
    }


    


    function twitterRedirect()
    {

        global $CONFIG;

        // require_once(LIBS.'twitteroauth/twitteroauth/twitteroauth.php');
        

        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth($CONFIG['twitter']['CONSUMER_KEY'], $CONFIG['twitter']['CONSUMER_SECRET']);
         
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken($CONFIG['twitter']['OAUTH_CALLBACK']);

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

    

    /**
     * @todo create new user
     *           
     * @return $statusName and $msgName = status and message for validating name
     * @return $statusEmail and $msgEmail = status and message for validating email
     * @return $statusUsername and $msgUsername = status and message for validating username
     * @return $statusTwitter and $msgTwitter = status and message for validating twitter                  
     */    
    function doSignup(){
        
        global $CONFIG;
        $data = $_POST;
        
        $checkEmail = $this->loginHelper->checkEmail($data['email']); 
        $checkUsername = $this->loginHelper->checkUsername($data['username']);       
        $checkTwitter = $this->loginHelper->checkTwitter($data['twitter']);
        
        if($checkEmail !== true || $checkUsername !== true || $checkTwitter !== true){
            $statusEmail = "";
            $msgEmail = "";
            $statusUsername = "";
            $msgUsername = "";
            $statusTwitter = "";
            $msgTwitter = "";
            
            if($checkEmail !== true){
                $statusEmail = "exist";
                $msgEmail = "Email already exist";
            }
            if($checkUsername !== true){
                $statusUsername = "exist";
                $msgUsername = "Username already exist";
            }
            if($checkTwitter !== true){
                $statusTwitter = "exist";
                $msgTwitter = "Twitter already exist";
            }
                echo json_encode(array('statusEmail' => $statusEmail, 'msgEmail' => $msgEmail, 'statusUsername' => $statusUsername, 'msgUsername' => $msgUsername, 'statusTwitter' => $statusTwitter, 'msgTwitter' => $msgTwitter));
                exit;
        }
        // else{
        //     echo json_encode(array('status' => 'error'));
        //     exit;
        // }
        
        if($checkEmail && $checkUsername && $checkTwitter){

        
            $signup = $this->loginHelper->createUser($data);
            if ($signup){

                $getToken = $this->loginHelper->getEmailToken($data['username']);

                // send mail before activate account
                $dataArr['email'] = $data['email'];
                $dataArr['username'] = $data['username'];
                $dataArr['password'] = $data['password'];
                $dataArr['token'] = sha1('register'.$data['email']);
                $dataArr['validby'] = $getToken['email_token'];
                $dataArr['regfrom'] = 1;

                $inflatData = encode(serialize($dataArr));
                logFile($inflatData);


                $to = $data['email'];
                $from = $CONFIG['email']['EMAIL_FROM_DEFAULT'];
                // $msg = "To activate your account please <a href='{$basedomain}login/validate/?ref={$inflatData}'>click here</a>";
                $this->view->assign('email',$data['email']);
                $this->view->assign('username',$data['username']);
                $this->view->assign('encode',$inflatData);
                $msg = "<p>Hi ".$data['username']."!</p>";
                $msg .= $this->loadView('emailTemplate');
                // try to send mail 
                $sendMail = sendGlobalMail($to, $from, $msg,true);
                logFile('mail send '.serialize($sendMail));

                $this->activityHelper->updateEmailLog(false,$to,'account',0);

            }

            echo json_encode(array('status' => true));
            exit;
        }
        exit;
    }
    
    /**
     * @todo enter the site as user
     */        
    function doLogin(){

        global $basedomain;
        //query data
        $getUserappData = $this->loginHelper->goLogin();
        // pr($getUserappData);
        if ($getUserappData){
            
            if ($getUserappData['login_count']>0){
                redirect($basedomain);    
            }else{
                // echo 'ada';exit;
                redirect($basedomain.'setting/category');
            }
            
        }else{
            redirect($basedomain);
        }

        exit;
    }
    


}

?>
