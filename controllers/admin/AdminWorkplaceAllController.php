<?php
include('content.php');

class AdminWorkplaceAllController extends ModuleAdminController
{
	public $projects = "";
	private $workplace_link = false;
	private $new_project = false;
	public $search_query = 'ORDER BY project_id DESC';
	public $contentClass;

	public function WorkplaceConstruct(){
		$this->contentClass = new content();

		if (isset($_GET['project'])){
			if($_GET['project'] !== '' && is_numeric($_GET['project'])){
				$this->workplace_link = $_GET['project'];
				$this->search_query = 'WHERE project_id = "'.$this->makeStringSave($this->workplace_link).'"'; 
			}
		}
		if (isset($_GET['NEW'])){
			if($_GET['NEW'] === "TRUE"){
				$this->new_project = true;
			}
		}

		if (isset($_GET['search'])){
			if($_GET['search'] !== ''){
				$this->search_query = 'WHERE discription LIKE "%'.$this->makeStringSave($_GET['search']).'%" OR CONCAT(merk_replica, " ", model_replica) LIKE "%'.$this->makeStringSave($_GET['search']).'%"'; 
			}
		}

	if (isset($_GET['done'])){
			if($_GET['done'] !== '' && $_GET['done'] === "FALSE"){
				$this->search_query = 'WHERE done = "0" ORDER BY project_id DESC';
			}
		}
	}

	public function init()
	{
		$this->WorkplaceConstruct();
		parent::init();
		$this->bootstrap = true;
	}
	public function initContent()
	{
		parent::initContent();	
		$this->context->smarty->assign(["homeLink" => $this->getWorkplaceLink()]);
		if ($this->workplace_link !== false){
			$this->projectContentPage();
		}else if($this->new_project){
			$this->newContentPage();
		}else{
			$this->allContentPage();
		}
		

	}

	private function newContentPage(){
		$this->context->smarty->assign(["date" => date('d-m-y')]);
		$this->setTemplate('new.tpl');
	}

	private function allContentPage(){
		$this->context->smarty->assign(["allProjects" => $this->contentClass->getAllProjects($this->search_query)]);
		$this->setTemplate('all.tpl');
	}

	private function projectContentPage(){
		$row = $this->getProjectFromDatabase()[0];
		$user = $this->getCustomerFromDatabase($this->makeStringSave($row['customer_id']));
		$productsAddedToProject = '';

        $products = $this->getProductsForProject();
        foreach($products as &$pruductRow){  
        	$product = new Product($pruductRow['product_id']);   
            $productsAddedToProject.= "<div class='all-products-holder'><img src='".$this->getImage($pruductRow['product_id'])."' height='30px'> ".$product->name[1]."<button class='btn btn-danger btn-left' onclick='dellProductFromProject(\"".$pruductRow['id_project_item']."\")'>Verwijder</button></div>";
        }
        
		$this->context->smarty->assign([
			"nameWorker" 	=> 	$this->noHtmlString($row['name_worker']),
			"name"			=> 	$this->noHtmlString($user['firstname']." ".$user['lastname']),
			"email"			=> 	$this->noHtmlString($user['email']),
			"dateAdded"		=> 	$this->noHtmlString($row['date_started']),
			"endDate"		=> 	$this->noHtmlString($row['end_date']),
			"projectBudget"	=> 	$this->noHtmlString($row['project_budget']),
			"brand"			=>	$this->noHtmlString($row['merk_replica']),
			"kind"			=>	$this->noHtmlString($row['model_replica']),
			"problem"		=>	$this->noHtmlString($row['problem_replica']),
			"included"		=>	$this->noHtmlString($row['included_replica']),
			"phone"			=>	$this->noHtmlString($row['phone']),
			"projectID"		=> 	$this->workplace_link,
			"products" 		=>	$productsAddedToProject


		]);
		$this->setTemplate('project.tpl');
	}


	private function getProjectFromDatabase(){
		$sql = "SELECT * FROM `"._DB_PREFIX_."module_workplace` ".$this->search_query;
		return Db::getInstance()->executeS($sql);
	}
	private function getCustomerFromDatabase($string){
		$sql = "SELECT * FROM `"._DB_PREFIX_."customer` WHERE id_customer = '".$string."'";
		return Db::getInstance()->executeS($sql)[0];
	}

	private function getProductsForProject(){
		$sql = "SELECT * FROM `"._DB_PREFIX_."module_workplace_products` WHERE project_id = '".$this->makeStringSave($this->workplace_link)."'";
		return Db::getInstance()->executeS($sql);
	}
	private function getImage($id)
	{
    	$images = Image::getImages(1, (int)$id);
    	$id_image = Product::getCover($id);
   		// get Image by id
    	if (sizeof($id_image) > 0)
    	{
        	$image = new Image($id_image['id_image']);
        	// get image full URL
        	return _PS_BASE_URL_._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
    	}
	}

	public function getWorkplaceLink()
    {
    	if(isset($_GET['controller']) && isset($_GET['token'])){
    		return '?controller='.$_GET['controller'].'&token='.$_GET['token'];
    	}else{
    		return '';
    	}
    }


	public function makeStringSave($string)
	{
		$string = pSQL(utf8_decode($string));
		return $string;
	}

	public function noHtmlString($string)
	{
		return htmlspecialchars($string);
	}

}