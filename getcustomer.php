<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once('../../init.php');
// Array with names

$hint = '';
$cookie = new Cookie('psAdmin');
if ($cookie->id_employee){
//code
    if(isset($_REQUEST["id"])){
        $id = $_REQUEST["id"];
        $hint = select($id);
    }elseif(isset($_REQUEST["q"])){
        $q = $_REQUEST["q"];
        $hint = search($q);
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
    $fix_users = '<div class="all-products-holder">';
    $hint = "";
    $sql = "SELECT firstname,lastname,email,id_customer FROM `"._DB_PREFIX_."customer` WHERE CONCAT(firstname, ' ', lastname) LIKE '%".makeStringSave($q)."%' ";
        $name = Db::getInstance()->executeS($sql);

        foreach($name as &$row){
            $hint.= $fix_users.'<input id="radios" type="radio" name="userSelect" onchange="getCustomerInfo(this.value,this.checked)" value="'.noHtmlString($row['id_customer']).'" style="float:left;"><div style="float:left;">'.noHtmlString($row['firstname']).' '.noHtmlString($row['lastname']).'<br>'.noHtmlString($row['email']).'</div></div>';
        }
        return $hint;
}

function select($id){
        $sql = "SELECT firstname,lastname,email,id_customer FROM `"._DB_PREFIX_."customer` WHERE id_customer = '".makeStringSave($id)."' ";
        $name = Db::getInstance()->executeS($sql);

        $hint = "[".noHtmlString($name[0]['firstname'])." ".noHtmlString($name[0]['lastname']).",FALSE,".noHtmlString($name[0]['email'])."]";
        return $hint;
}

    function makeStringSave($string)
    {
        $string = pSQL(utf8_decode($string));
        return $string;
    }
?>