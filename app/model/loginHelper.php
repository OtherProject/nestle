<?php

class loginHelper extends Database {
	var $salt;
    function __construct()
    {
        global $basedomain;
        $this->loadmodule();
        $this->salt = '1nf0k0mun1t4s';
        $this->session = new Session();
        $this->user = $this->session->get_session();
    }
    
    function loadmodule()
    {
        // include APP_MODELS.'activityHelper.php';
        // $this->activityHelper = new helper_model;
       
    }

    function goLogin()
    {
        // pr($_POST);
        $email = _p('email');
        $password = _p('password');
        
        // pr($data);       
        $data['status'] = false;
        $newCred = array();

        $sql = "SELECT * FROM social_member WHERE email = '{$email}' AND usertype IN (1) AND n_status = 1 LIMIT 1";
        // pr($sql);
        $res = $this->fetch($sql);
        // pr($res);
        // exit;
        if ($res){
            
            $salt = sha1($res['salt'].$password);
            
            // pr($salt);exit;
            if ($res['password'] == $salt){
                
                $loginCount = intval($res['login_count'] +1);
                $lastLogin = date('Y-m-d H:i:s');
                
                $sqlu = "UPDATE social_member SET last_login = '{$lastLogin}' ,login_count = {$loginCount} WHERE id = {$res['id']} LIMIT 1";
                $result = $this->query($sqlu);
                
                // $_SESSION['user'] = $res;

                $ignoreFIeld = array('salt','password','email_token','email','username');

                foreach ($res as $key=> $val){
                    
                    if (!in_array($key, $ignoreFIeld))$newCred[$key] = $val;
                }

                $this->session->set_session($newCred);
                
                return $newCred;
            }
        }
        
        return false;
    }

    function loginSosmed($sosmed=1,$data=array())
    {

        if (!$data) return false;

        foreach ($data as $key => $value) {
            $$key = $value;
        }
        
        $date = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM social_member WHERE sosmed_id = '{$data['id']}' AND usertype = {$sosmed} LIMIT 1";
        // pr($sql);
        $result = $this->fetch($sql);
        if ($result){

            $loginCount = intval($result['login_count'] +1);
            $lastLogin = date('Y-m-d H:i:s');
            
            $sqlu = "UPDATE social_member SET last_login = '{$lastLogin}' ,login_count = {$loginCount} WHERE id = {$result['id']} LIMIT 1";
            $res = $this->query($sqlu);

            $dataSession = $result;
        }else{

            if ($sosmed==1){
                $sql = "INSERT IGNORE INTO social_member (sosmed_id, name, email, register_date, middle_name, last_name, sex, link, usertype,n_status) 
                        VALUES ('{$id}','{$first_name}','{$email}','{$date}', '{$middle_name}','{$last_name}','{$gender}','{$link}',1,1)";
                // pr($sql);
                $res = $this->query($sql);
                
            }else{

                $sql = "INSERT IGNORE INTO social_member (sosmed_id, name, register_date, username, description, link, city, usertype,n_status)
                        VALUES ('{$data['id']}', '{$data['name']}', '{$date}',  '{$data['screen_name']}', '{$data['description']}','{$data['url']}','{$data['location']}',2,1)";
                // pr($sql);
                $res = $this->query($sql);
            }
            
            usleep(500);
            $sql = "SELECT * FROM social_member WHERE sosmed_id = '{$data['id']}' LIMIT 1";
            // pr($sql);
            $result = $this->fetch($sql);

            // pr($sql);
            $dataSession = $result;
        }
        // pr($dataSession);
        // exit;
        $this->session->set_session($dataSession);

        return $dataSession;
    }

	
    
    function getUserInfo($id=false){

        $userid = false;
        if ($id) $userid = $id;
        else $userid = $this->user['default']['id'];

        if (!$userid) return false;
        $sql1 = "SELECT * FROM social_member WHERE id = {$userid} LIMIT 1";
        // pr($sql1);
        $res1 = $this->fetch($sql1);

        if ($res1) return $res1;
        return false;
    }

   
}
?>