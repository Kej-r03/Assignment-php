<!-- File to handle AJAX request and make changes in MYSQL database-->

<?php
session_start();
require_once('connect.php');
$v1=$_POST['id'];
$v2=$_POST['upd'];

$row_num=substr($v1,0,strpos($v1,'_'));
$col_num=substr($v1,strpos($v1,'_')+1);



if($col_num==6)
$a_name='Assignment_1_Status';//these are MYSQL Table headings, and we have to store the rignt one in $a_name to update that column
else if($col_num==8)
$a_name='Assignment_2_Status';
else if($col_num==10)
$a_name='Assignment_3_Status';

$stt=$conn->prepare("UPDATE Student SET $a_name=? WHERE ID=?");
$stt->bind_param('si',$v2,$row_num);
$stt->execute();//changes made in the database

$_SESSION['login']=1;

?>