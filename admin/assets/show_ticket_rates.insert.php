<?php
include_once ('../db_config.php');
include_once ('../functions.php');

$show_id =  $_POST['shows'];
$category = json_encode($_POST['category']);
$fullRate = json_encode($_POST['fullRate']);
$ticketID = get_ticketID($db,$show_id);

$sql = "INSERT INTO `tbl_show_ticket_rates` ( `show_id`,`ticket_category_id`, `category`, `ticket_rate`) VALUES ( '$show_id', '$ticketID', '$category', '$fullRate');";
$query = $db->query($sql);
if($query){
    echo "Success";
}else{
    echo "Error";
}

?>