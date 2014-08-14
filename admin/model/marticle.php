<?php
class marticle extends Database {
	
	function article_inp($data)
	{
		
		$date = date('Y-m-d H:i:s');
		$datetime = array();
		
		if(!empty($data['postdate'])) $data['postdate'] = date("Y-m-d",strtotime($data['postdate'])); 

		if($data['action'] == 'insert'){
			
			$query = "INSERT INTO  
						nestle_news_content (title,brief,content,image,file,articletype,
												created_date,posted_date,authorid,n_status)
					VALUES
						('".$data['title']."','".$data['brief']."','".$data['content']."','".$data['image']."'

							,'".$data['image_url']."','".$data['articletype']."','".$date."','".$data['postdate']."'
							,'".$data['authorid']."','".$data['n_status']."')";

		} else {
			$query = "UPDATE nestle_news_content
						SET 
							title = '{$data['title']}',
							brief = '{$data['brief']}',
							content = '{$data['content']}',
							image = '{$data['image']}',
							file = '{$data['image_url']}',
							posted_date = '".$date."',
							authorid = '{$data['authorid']}',
							n_status = {$data['n_status']}
						WHERE
							id = '{$data['id']}'";
		}
// pr($query);
		$result = $this->query($query);
		
		return $result;
	}
	
	function get_article($type=1)
	{
		$query = "SELECT * FROM nestle_news_content WHERE n_status = '1' OR n_status = '0' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

			$username = $this->fetch($query,0);

			$result[$key]['username'] = $username['username'];
		}
		
		return $result;
	}
	
	function get_article_slide()
	{
		$query = "SELECT nc.*, cc.category, ct.type FROM cdc_news_content nc LEFT JOIN cdc_news_content_category cc 
					ON nc.categoryid = cc.id LEFT JOIN cdc_news_content_type ct ON nc.articletype = ct.id 
					WHERE nc.n_status < 2 AND nc.articletype > 0  ORDER BY nc.createdate DESC";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function get_article_trash()
	{
		$query = "SELECT * FROM nestle_news_content WHERE n_status = '2' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

			$username = $this->fetch($query,0);

			$result[$key]['username'] = $username['username'];
		}
		
		return $result;
	}
	
	function article_del($id)
	{
		foreach ($id as $key => $value) {
			
			$query = "UPDATE nestle_news_content SET n_status = '2' WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
	
	function article_delpermanent($id)
	{
		$query = "DELETE FROM cdc_news_content WHERE id = '{$id}'";
		
		$result = $this->query($query);
		
		return $result;
		
	}
	
	function article_restore($id)
	{
		foreach ($id as $key => $value) {
			
			$query = "UPDATE nestle_news_content SET n_status = '0' WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
	
	function get_article_id($data)
	{
		$query = "SELECT * FROM nestle_news_content WHERE id= {$data} LIMIT 1";
		
		$result = $this->fetch($query,0);

		if($result['posted_date'] != '') $result['posted_date'] = dateFormat($result['posted_date'],'dd-mm-yyyy');
		($result['n_status'] == 1) ? $result['n_status'] = 'checked' : $result['n_status'] = '';

		return $result;
	}
	
	function frame_inp($data){

		foreach ($data as $key => $val) {
			$tmpfield[] = $key;
			$tmpvalue[] = "'$val'";
		}

		$field = implode(',', $tmpfield);
		$value = implode(',', $tmpvalue);

		$query = "INSERT INTO nestle_news_content_repo ({$field}) VALUES ($value)";

		$result = $this->query($query);

		return true;
	}

	function get_frameList(){

		$query = "SELECT * FROM nestle_news_content_repo ORDER BY created_date DESC";

		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			($value['gallerytype'] == 1) ? $result[$key]['gallerytype'] = 'frame' : $result[$key]['gallerytype'] = 'cover';
		}
		
		return $result;
	}
}
?>