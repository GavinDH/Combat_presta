<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once('../../init.php');
// Array with names

$hint = '';
$cookie = new Cookie('psAdmin');
if ($cookie->id_employee){
//code
    if(isset($_REQUEST["pid"]) && isset($_REQUEST['var'])){
        $var = $_REQUEST["var"];
        $pid = $_REQUEST["pid"];
        if(is_numeric($pid)){
            $hint = placeString($id,$pid);
        }elseif(isset($_REQUEST["pid"])){
        	$pid = $_REQUEST["pid"];
        	$hint = getString($pid);
        }
    }
    echo $hint === "" ? "no suggestion" : $hint;
}else{
    echo "WOOP : You are not logged in as a administrator";
}




function noHtmlString($string)
    {
        return htmlspecialchars($string);
    }

function search($q){
        $productObj = new Product();
        $products = $productObj -> getProducts(1, 0, 0, 'id_product', 'DESC' );
        $return = "";
        foreach($products as &$row){
            if ($row['name'] !== "")
            {
                if (strpos($row['name'],$q)){
                    $return.= "<div class='all-products-holder'><a href='#' onclick='addProductToProject(\"".$row['id_product']."\")'><img src='".getImage($row['id_product'])."' height='30px'> ".$row['name']."</a></div>";
                }   
            }
            
        }
        return $return;
}

    function makeStringSave($string)
    {
        $string = pSQL(utf8_decode($string));
        return $string;
    }

function getString($pid){
		$sql = "SELECT * FROM `"._DB_PREFIX_."module_workplace` WHERE pid = ".makeStringSave($pid);
		return Db::getInstance()->executeS($sql)['text'];
}

function placeString($id,$pid){
       
                    $sql = "INSERT INTO `"._DB_PREFIX_."module_workplace_log` 
                    (`project_id`,`text`) 
                    VALUES  ('".makeStringSave($id)."','".makeStringSave($var)."')";

                    Db::getInstance()->execute($sql);


        return $return;
}



           

            

 

?>