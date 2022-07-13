<!-- To verify credentials and to redirect to  proper page (that is to profile display page or back to login page) -->
<!-- This page cannot be entered into without credentials -->

<?php
if($_SERVER['REQUEST_METHOD']!==POST)//to open this page only through Login Page
header("Location: Student.php");

session_start();
require_once ('connect.php');
$username=$_POST['Suser'];//storing the variables obtained via post command
$password=$_POST['Spass'];
$flag=0;
$result = $conn -> query("SELECT * FROM Student");//->query makes a mysql query

while($array=$result->fetch_array(MYSQLI_NUM))//find the row of the user
{
    if($username==$array[1] && $password==$array[2])
    {
        $flag=1;
        break;
    }
}

if($flag==1)//if credentials are correct, indicate success via login session variable, and store the student row of database in another session variable
{
$_SESSION['login']=1;
$_SESSION['arr']=$array;
header("Location: SPage.php");
}

else if($flag==0 && $_SERVER['REQUEST_METHOD']==POST)//if user has entered this page in proper flow by entering credentials, but they are incorrect
{
    $_SESSION['errSCred']=1;
    header("Location:Student.php");
}

?>