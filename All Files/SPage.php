<!-- Student Information Display Page -->


<?php
session_start();

if($_SESSION['login']!==1)//if this page has not been opened after a successful login,, redirect to login page
header("Location: Student.php");
else
$_SESSION['login']=0;//this session variable just becomes 1 for the login instant, and then  becomes 0 again


require_once('connect.php');
$array=$_SESSION['arr'];//stores the row of the mathcing student from the database

?>
<!DOCTYPE HTML>
<HTML>
    <head>
        <title><?php echo $array[1]; ?></title>
    </head>
    <body>
        
        <div>
            <h1 style="text-align:center;">Welcome User</h1>
            <h2 style="text-align:center"><u>User Profile</u></h1><hr><br><br>
            <div class="flex-container" style="display:flex;justify-content:space-around;font-size:25px">
            <div><b>ID : </b><?php echo $array[0] ?></div>
            <div><b>NAME: </b><?php echo $array[1] ?></div>
            <div><b>BRANCH : </b><?php echo $array[3] ?></div>
            <div><b>YEAR : </b><?php echo $array[4] ?></div>
</div>
        </div><br><br>
        <hr><br><br>
        <div>
            <h2 style="text-align:center"><u>User Dashboard</u></h1>
            <div style="margin:60px">
                <h1><u>ASSIGNMENT 1</u></h1>
                <ul style="font-size:20px;">
                    <li><b>Name: </b><?php echo $array[5] ?></li>
                    <li><b>Status: </b><?php echo $array[6] ?></li>
                </ul>
            </div>
            <div style="margin:60px">
                <h1><u>ASSIGNMENT 2</u></h1>
                <ul style="font-size:20px;">
                    <li><b>Name: </b><?php echo $array[7] ?></li>
                    <li><b>Status: </b><?php echo $array[8] ?></li>
                </ul>
            </div>
            <div style="margin:60px">
            <h1><u>ASSIGNMENT 3</u></h1>
                <ul style="font-size:20px;">
                    <li><b>Name: </b><?php echo $array[9] ?></li>
                    <li><b>Status: </b><?php echo $array[10] ?></li>
                </ul>
            </div>
        </div>

        <a href="Assignment.php" style="position: relative;left: 45%;">Assignment Submission Link</a><!--the submission link has not been implemented, it has just been mentioned-->
        <br><br><br>
        <div>
            <button onclick="document.location.href='../Home.php'" style="position: relative;left: 50%;transform: translate(-50%, 0);width:20vw;height:7vh;font-size:20px;">Home</button>
        </div>
    </body>
</HTML>