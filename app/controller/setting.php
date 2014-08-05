<?php

class setting extends Controller {
	
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
	}
	
	function index(){

		// pr($_SESSION);
    	return $this->loadView('home');
    }
	
	function category()
	{

		$getCategory = $this->userHelper->getCategory();

		$this->view->assign('category',$getCategory);
		return $this->loadView('setting/chooseCategory');

	}

	function setCategory()
	{
		global $basedomain;
		// pr($_POST);

		$catImpl = false;

		$category = $_POST['category'];
		if ($category){
			$catImpl = implode(',', $category);
			$setCategory = $this->userHelper->setCategory($catImpl);
			if ($setCategory) redirect($basedomain);
		}else{
			redirect($basedomain.'setting/category');
		}

		
		exit;
		

		

	}
}

?>
