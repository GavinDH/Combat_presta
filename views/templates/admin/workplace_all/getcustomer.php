<?php
require_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once('../../init.php');
// Array with names
$q = $_REQUEST["q"];
$hint = '';

$sql = "SELECT firstname,lastname FROM `"._DB_PREFIX_."customer` WHERE firstname LIKE '%".$q."%' ";
        $name = Db::getInstance()->executeS($sql);

        foreach($name as &$row){
            $hint.= $row['firstname'].' '.$row['lastname'].'<br>'.$row['email'];
        }
       

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?>