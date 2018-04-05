<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once('../../init.php');
// Array with names

$hint = '';
$cookie = new Cookie('psAdmin');
if ($cookie->id_employee){
//code
    if(isset($_REQUEST["id"]) && isset($_REQUEST['pid'])){
        $id = $_REQUEST["id"];
        $pid = $_REQUEST["pid"];
        if(is_numeric($pid) && is_numeric($id)){
            $hint = getProductByid($id,$pid);
        }
    }elseif(isset($_REQUEST["q"])){
        $q = $_REQUEST["q"];
        $hint = search($q);
    }elseif(isset($_REQUEST['did']) && isset($_REQUEST['pid'])){
        $did = $_REQUEST['did'];
        $pid = $_REQUEST["pid"];
        if(is_numeric($did) && is_numeric($pid)){
            $hint = removeProductById($did,$pid);
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

function getImage($id)
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

function getProductByid($id,$pid){
            $productObj = new Product();
        $products = $productObj -> getProducts(1, 0, 0, 'id_product', 'DESC' );
        $return = "";
        foreach($products as &$row){
            if ($row['id_product'] == $id)
            {       

                    $sql = "INSERT INTO `"._DB_PREFIX_."module_workplace_products` 
                    (`product_id`,`project_id`) 
                    VALUES  ('".makeStringSave($id)."','".makeStringSave($pid)."')";

                    Db::getInstance()->execute($sql);
                    $return.= "<div class='all-products-holder'><img src='".getImage($row['id_product'])."' height='30px'> ".$row['name']."<button class='btn btn-danger btn-left' onclick='dellProductFromProject(\"refresh\")'>Verwijder</button></div>";  
            }
            
        }
        return $return;
}


function removeProductById($id,$pid){

    $sql="UPDATE `"._DB_PREFIX_."module_workplace_products` SET visible='0' WHERE id_project_item = '".$id."' and project_id = '".$pid."'";
    if(!Db::getInstance()->execute($sql)){
        return "error";
    }

    return "removed";
}

           

            

 

?>