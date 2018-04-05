<?php

class content{

public $projects;
	public function getAllProjects($query)
	{
		$toLate = false;
		$actual_url= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$result = $this->getAllProjectsFromDatabase($query);
		$var = $row["end_date"];
		$date = str_replace('/', '-', $var);

		if (strtotime($date) > strtotime(date('d-m-y'))){
			$toLate = true;
		}

		foreach($result as &$row){
		if($row['customer_id'] !== "0"){
			$sql = "SELECT firstname,lastname FROM `"._DB_PREFIX_."customer` WHERE id_customer = '".$row['customer_id']."' ";
		$name = Db::getInstance()->executeS($sql);
		if ($row['done'] == "1"){
			$done = '<span class="label label-success"><i class="icon-check"></i></span>';
		}elseif($toLate){
			$done = '<span class="label label-error"><i class="icon-close"></i></span>';
		}else{
			$done = '<span class="label label-warning"><i class="icon-close"></i></span>';
		}
						$this->projects.='<div class=" col-lg-6">
								<div class="all-products-holder">
									<div class="basic-info">
                            			<a href="'.$actual_url.'&project='.$row["project_id"].'">'.$name[0]['firstname'].' '.$name[0]['lastname'].'</a> '.$done.'<br>
                            			'.$row["merk_replica"].' '.$row['model_replica'].'
                            		</div>
                            		<div class="special-info">
                            			'.$date.'
                            		</div>
                            		<div class="clear"></div>
                    			</div>
                 			</div>';
		}

		
		}
		return $this->projects;
	}

	private function getAllProjectsFromDatabase($query){
		$sql = "SELECT project_id,merk_replica,model_replica,end_date,customer_id,done FROM `"._DB_PREFIX_."module_workplace` ".$query;
		return Db::getInstance()->executeS($sql);
	}
}