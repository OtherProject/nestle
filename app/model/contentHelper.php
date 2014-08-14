<?php
class contentHelper extends Database {
	
	function __construct()
	{
		$this->prefix = "nestle";
		$session = new Session();
		$this->user = $session->get_session();
	}

	function getNews()
	{
		
		$sql = "SELECT n.title, cr.friendlyUrl FROM tbl_news n LEFT JOIN code_url_redirect cr ON n.id = cr.articleId
				WHERE cr.n_status = 1";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function readNews($url=false)
	{
		if(!$url) return false;
		
		$urlArticle = clean($url);
		global $CONFIG;
		
		if ($CONFIG['uri']['short']) $field = " shortUrl ";
		if ($CONFIG['uri']['friendly']) $field = " friendlyUrl ";
		
		
		$sql = "SELECT n.* FROM tbl_news n LEFT JOIN code_url_redirect cr 
				ON n.id = cr.articleId WHERE cr.{$field} = '{$urlArticle}' LIMIT 1";
		// pr($sql);
		$res = $this->fetch($sql);
		if ($res) return $res;
		return false;
		
	}
	
	function getArticle($id=false, $start=0, $limit=3)
	{

		$filter = "";
		if ($id) $filter = "AND id = {$id}";

		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 {$filter} ORDER BY posted_date DESC LIMIT {$start},{$limit}";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}

	function getRandomArticle($id=false, $start=0, $limit=3)
	{

		$filter = "";
		if ($id) $filter = "AND id <> {$id}";

		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 {$filter} ORDER BY rand() DESC LIMIT {$start},{$limit}";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	function getNextArticle($id=false)
	{

		if(!$id) return false;
		$sql = "select id from nestle_news_content 
				where ( 
				        id = IFNULL((select min(id) from nestle_news_content where id > {$id}),0) 
				        or  id = IFNULL((select max(id) from nestle_news_content where id < {$id}),0)
				      )";
		$res = $this->fetch($sql,1);
		// pr($res);
		if ($res){

			// logikanya dibalik (prev/next) untuk menyesuaikan dengan posted_date

			if (count($res)>1){
				
				foreach ($res as $key => $value) {
					if ($value['id']<$id){
						$data['next'] = intval($value['id']);
					}
					if ($value['id']>$id){
						$data['prev'] = intval($value['id']);
					} 
				}

			}else{

				foreach ($res as $key => $value) {
					if ($value['id']<$id){
						$data['next'] = intval($value['id']);
						$data['prev'] = "#";
					}

					if ($value['id']>$id){
						$data['next'] = "#";
						$data['prev'] = intval($value['id']);
					}
				}
			}
			

			return $data;
		}
		
		return false;
	}

	function saveUserFoto($data=array())
	{

		$useraccount = $this->user['default'];
		
		$date = date('Y-m-d H:i:s');
		// pr($useraccount);
		$title = "Upload foto from local store";
		$sql = "INSERT INTO {$this->prefix}_news_content_repo (title,typealbum, files, userid, created_date, n_status)
				VALUES ('{$title}', 1, '{$data['full_name']}', {$useraccount['id']}, '{$date}',1)";
		// pr($sql);
		$res = $this->query($sql);
		if($res) return true;
		return false;
	}

	function getMyPhoto()
	{
		$userid = $this->user['default']['id'];
		$sql = "SELECT * FROM {$this->prefix}_news_content_repo WHERE userid = {$userid} 
				AND n_status = 1 {$filter} ORDER BY created_date DESC LIMIT 1";
		$res = $this->fetch($sql);
		if ($res) return $res;
		return false;
	}

	function getFrame()
	{
		
		$sql = "SELECT * FROM {$this->prefix}_news_content_repo WHERE gallerytype IN (1) 
				AND n_status = 1 {$filter} ORDER BY created_date DESC LIMIT 4";
		$res = $this->fetch($sql,1);
		if ($res){

			foreach ($res as $key => $value) {
				$sql1 = "SELECT * FROM {$this->prefix}_news_content_repo WHERE gallerytype IN (2) 
						AND n_status = 1 AND otherid = {$value['id']} {$filter} ORDER BY created_date DESC LIMIT 1";
				$res1 = $this->fetch($sql1);

				$res[$key]['cover'] = $res1;
			}


			return $res;	
		} 
		return false;
	}

	function getCreateImage()
	{
		$useraccount = $this->user['default'];
		$sql1 = "SELECT * FROM {$this->prefix}_createimage WHERE userid = {$useraccount['id']} ORDER BY created_date DESC LIMIT 1";
		$res1 = $this->fetch($sql1);

		
		if ($res1) return $res1;
		return false;
	}

	function updateUserFoto($id, $filename, $fromonline=false)
	{
		
		if ($fromonline){

			$useraccount = $this->user['default'];
		
			$date = date('Y-m-d H:i:s');
			// pr($useraccount);
			$title = "Upload foto from album facebook";
			$sql = "INSERT INTO {$this->prefix}_news_content_repo (title,typealbum, files, userid, created_date, n_status)
					VALUES ('{$title}', 1, '{$filename}', {$useraccount['id']}, '{$date}',1)";
			// pr($sql);
			$res = $this->query($sql);

		}else{
			// $sql = "UPDATE {$this->prefix}_news_content_repo SET thumbnail = '{$filename}' WHERE id = {$id} LIMIT 1";
			$sql = "UPDATE {$this->prefix}_createimage SET profil = '{$filename}' WHERE id = {$id} LIMIT 1";
			// pr($sql);

			$res = $this->query($sql);
		}
		
		if ($res) return true;
		return false;
	}

	function updateUserFrame($data=array())
	{

		$useraccount = $this->user['default'];
		
		$date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO {$this->prefix}_createimage (userid,cover, frame, created_date, n_status)
				VALUES ({$useraccount['id']}, '{$data['cover']}', '{$data['frame']}', '{$date}',1)";
		// pr($sql);
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}

	function updateCreateImageStatus()
	{
		$useraccount = $this->user['default'];

		$user = $this->getCreateImage();

		$sql = "UPDATE {$this->prefix}_createimage SET n_status = 2 WHERE id = {$user['id']} AND userid = {$user['userid']} LIMIT 1";
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}
}
?>