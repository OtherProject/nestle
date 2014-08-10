<?php
class contentHelper extends Database {
	
	function __construct()
	{
		$this->prefix = "nestle";
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
}
?>