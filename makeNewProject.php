<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once('../../init.php');
// Array with names

$hint = '';
$cookie = new Cookie('psAdmin');
if ($cookie->id_employee){
    $hint = addToDB();
    echo $hint === "" ? "WOOPS : Somthing went wrong" : $hint;
}else{
    echo "WOOP : You are not logged in as a administrator";
}

function addToDB()
{
           if(isset($_REQUEST['NW']) && isset($_REQUEST['CI']) && isset($_REQUEST['DD']) && isset($_REQUEST['BT']) && isset($_REQUEST['BD']) && isset($_REQUEST['TY']) && isset($_REQUEST['PM']) && isset($_REQUEST['INC']) && isset($_REQUEST['P'])){

           

            $sql = "INSERT INTO `"._DB_PREFIX_."module_workplace` 
                    (`name_worker`,`customer_id`,`end_date`,`project_budget`,`merk_replica`,
                    `model_replica`,`problem_replica`,`included_replica`,`phone`,`date_started`) 
                    VALUES  ('".makeStringSave($_REQUEST['NW'])."','".makeStringSave($_REQUEST['CI'])."','".makeStringSave($_REQUEST['DD'])."','".makeStringSave($_REQUEST['BT'])."','".makeStringSave($_REQUEST['BD'])."','".makeStringSave($_REQUEST['TY'])."','".makeStringSave($_REQUEST['PM'])."','".makeStringSave($_REQUEST['INC'])."','".makeStringSave($_REQUEST['P'])."','".date('d-m-y')."')";

            return Db::getInstance()->execute($sql);

        }else{
            return "WOOPS : We dit not get all the forms";
        }
 
}



function noHtmlString($string)
    {
        return htmlspecialchars($string);
    }

    function makeStringSave($string)
    {
        $string = pSQL(utf8_decode($string));
        return $string;
    }
?>