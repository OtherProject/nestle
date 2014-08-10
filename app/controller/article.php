<?php

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class article extends Controller {
	
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
    $this->contentHelper = $this->loadModel('contentHelper');
	}
	
	function index(){

		global $CONFIG, $basedomain;

		$getArticle = $this->contentHelper->getArticle();
    if ($getArticle){
      foreach ($getArticle as $key => $value) {
        $getArticle[$key]['changeDate'] = changeDate($value['posted_date']);
      }
    }
		// pr($getArticle);
    $this->view->assign('article',$getArticle);

  	return $this->loadView('article/index');
  }

	function detail(){

		global $CONFIG, $basedomain;

      $id = _g('id');
		  $getArticle = $this->contentHelper->getArticle($id);
      if ($getArticle){
        foreach ($getArticle as $key => $value) {
          $getArticle[$key]['changeDate'] = changeDate($value['posted_date']);
          $getArticle[$key]['content'] = html_entity_decode($value['content']);
        }
      }
      // pr($getArticle);
      $this->view->assign('article',$getArticle);
    	return $this->loadView('article/detail');
    }
	
	
}

?>
