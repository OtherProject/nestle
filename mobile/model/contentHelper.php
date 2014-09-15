<?php
class contentHelper extends Database {
	var $prefix = "nestle";
	function getArticle($id=false, $start=0, $limit=3)
	{

		$filter = "";
		if ($id) $filter = "AND id = {$id}";

		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 {$filter} ORDER BY posted_date DESC LIMIT {$start},{$limit}";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	function getData()
	{
		$sql = "SELECT * FROM code_activity";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function getMessage()
	{
		$sql = "SELECT m.*, um.name,um.email FROM my_message m LEFT JOIN user_member um ON m.receive = um.id ";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function saveMessage($data)
	{
		foreach ($data as $key => $val){
			$tmpfield[] = $key;
			$tmpdata[] = "'$val'";
		}
		// from,to,subject,content,createdate,n_status
		$tmpfield[] = 'fromwho';
		$tmpfield[] = 'createdate';
		$tmpfield[] = 'n_status';
		
		$date = date('Y-m-d H:i:s');
		$tmpdata[] = 0;
		$tmpdata[] = "'{$date}'";
		$tmpdata[] = 1;
		
		$field = implode(',',$tmpfield);
		$data = implode(',',$tmpdata);
		
		$sql = "INSERT INTO my_message ({$field}) 
				VALUES ({$data})";
		// pr($sql);
		// exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}
	
	function get_user($data)
	{
		$query = "SELECT * FROM user_member WHERE email = '{$data}'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function importData($name=null)
	{
		$query = "INSERT INTO import (name,n_status) VALUES ('{$name}', 1)";
		// pr($query);
		$result = $this->query($query);
		
		return $result;
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
		$sql = "SELECT id FROM {$this->prefix}_news_content
				where (
				        id = IFNULL((SELECT min(id) from {$this->prefix}_news_content WHERE id > {$id}),0)
				        OR  id = IFNULL((SELECT max(id) from {$this->prefix}_news_content WHERE id < {$id}),0)
				      ) AND n_status = 1";
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
}
?>