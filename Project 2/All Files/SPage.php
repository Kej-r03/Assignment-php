<!-- Student Information Display Page -->


<?php
session_start();

if(!isset($_COOKIE['user_id']))
header("Location: ../Home.php");

require_once('connect.php');
$S_array=$_SESSION['Sarr'];//stores the row of the matching student from the database

if(isset($_POST['logout']))
{
    unset($_POST["logout"]);

    $user_id=$_COOKIE['user_id'];
    $st=$conn->prepare("DELETE FROM Per_Sessions WHERE token=?");
    $st->bind_param('s',$user_id);
    $st->execute();
            
    setcookie("user_id","",time()-3600,"/");

    header("Location: ../Home.php");
}
?>





<!DOCTYPE HTML>
<HTML>
    <head>
        <title><?php echo $S_array[1]; ?></title>
    </head>
    <body>
        
        <div>
            <h1 style="text-align:center;">Welcome User</h1>
            <h2 style="text-align:center"><u>User Profile</u></h1><hr><br><br>
            <div class="flex-container" style="display:flex;justify-content:space-around;font-size:25px">
            <div><b>ID : </b><?php echo $S_array[0] ?></div>
            <div><b>NAME: </b><?php echo $S_array[1] ?></div>
            <div><b>BRANCH : </b><?php echo $S_array[3] ?></div>
            <div><b>YEAR : </b><?php echo $S_array[4] ?></div>
            </div>
        </div>
        
        
        <br><br><hr><br><br>


        <div>
            <h2 style="text-align:center"><u>User Dashboard</u></h1>
           
           <?php $res=$conn->query('SELECT * FROM Assignment');
            while($arr=$res->fetch_array(MYSQLI_NUM)){?>

            <div style="margin:60px">
                <h1><u>ASSIGNMENT <?php echo $i+1 ?></u></h1>
                <ul style="font-size:20px;">
                    <li><b>Name: </b><?php echo $arr[0] ?></li>
                    <li><b>Status: </b><?php echo $arr[$S_array[0]] ?></li>
                </ul>
            </div>
            
            <?php } ?>  

        </div> 

        <a href="Assignment.php" style="position: relative;left: 45%;">Assignment Submission Link</a><!--the submission link has not been implemented, it has just been mentioned-->
        
        <br><br><br>

        <div>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="submit" name="logout" Value="Log Out">
            </form>
        </div>

    </body>
</HTML>