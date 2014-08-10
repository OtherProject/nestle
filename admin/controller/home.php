<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class home extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('marticle');
	}
	
	public function index(){
		
		$data = $this->models->get_article();

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

				if($val['n_status'] == '1') {
					$data[$key]['n_status'] = 'Publish';
					$data[$key]['status_color'] = 'green';
				} else {
					$data[$key]['n_status'] = 'Unpublish';
					$data[$key]['status_color'] = 'red'; 
				}
			}
		}
		
		// pr($data);exit;
		$this->view->assign('data',$data);

		return $this->loadView('home');

	}
	
	function listBerita()
	{
		global $basedomain;
		
		$table="dtataruang_news_content";
		$categoryid="4";
		$articletype="1";
		$orderby=array('postdate','DESC');
       
		// $result_data = $this->contentHelper->getData_news($table,$categoryid,$articletype,$orderby);
		
		// pr($result_data);
		if ($result_data) return $result_data;
	}
    
	public function informasi_gallery(){
        
		global $basedomain;
		
		
		// $result_data = $this->contentHelper->getData_gallery('dtataruang_news_content','6','2');
		
		
		if ($result_data) return $result_data;

	}
	
	public function ajax()
	{
		
		$idLocation = explode("_",$_POST['idLocation']);
		
		
		if ($_POST['idLocation']){
			// $data = $this->contentHelper->getChildLoc($idLocation[0]);
			echo json_encode($data);
		}
		exit;
	} 
}

?>
