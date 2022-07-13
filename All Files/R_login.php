<!-- To verify credentials and to redirect to  proper page (that is to profile display page or back to login page) -->
<!-- This page cannot be entered into without credentials -->


<?php
if($_SERVER['REQUEST_METHOD']!==POST)//to open this page only through Login Page
header("Location: Reviewer.php");

session_start();
require_once('connect.php');
$USERNAME=$_POST['Ruser'];
$PASSWORD=$_POST['Rpass'];
$flag=0;
$result=$conn->query('SELECT * FROM Reviewer');

while($array=$result->fetch_array(MYSQLI_NUM))
{
    if($USERNAME==$array[1] && $PASSWORD==$array[2])
    {$flag=1;
    break;}
}

if($flag==1)//if credentials are correct, indicate success via login session variable, and store the reviewer row of database in another session variable
{
    $_SESSION['login']=1;
    $_SESSION['Rarr']=$array;
    header("Location:RPage.php");
}
else if($flag==0 && $_SERVER['REQUEST_METHOD']==POST)//if user has entered this page in proper flow by entering credentials, but they are incorrect
{
    $_SESSION['errRCred']=1;
    header("Location:Reviewer.php");
}
?>