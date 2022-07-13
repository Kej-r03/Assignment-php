<?php
$SERVERNAME='localhost';
$USERNAME='root';
$PASSWORD='Rose!1234';
$DATABASE='Assignment_Review';

$conn=new mysqli($SERVERNAME,$USERNAME,$PASSWORD,$DATABASE);

if($conn->connect_error)
die("Connection failed".$conn.connect_error);
?>