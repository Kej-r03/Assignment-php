<!-- Reviewer Login Page -->


<?php
session_start();
if($_SESSION['Home_visited']==false)//if user has directly entered this page without opening Home page, he is redirected there
header("Location: ../Home.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reviewer Login</title>
    </head>
    <body>
    <h1 style="text-align:center; font-size:60px"><u>Reviewer Login</u></h1><hr>
    <?php if($_SESSION['errRCred']==1)//if credentials are wrong, user is alerted
        {
            echo "<script>window.alert('Wrong Credentials');</script>" ;
            $_SESSION['errRCred']=0;
        }
        ?>
        <div style="border:2px solid black;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);width:25vw;height:30vh;padding:40px">
        <form action="R_login.php" method="post">
            <label for="user" style="font-size:30px">Enter Username</label><br>
            <input type="text" id="user" name="Ruser" required style="width:22vw; height:30px"><br><br><br>
            <label for="pass" style="font-size:30px">Enter Password</label><br>
            <input type="password" id="pass" name="Rpass" required style="width:22vw; height:30px"><br><br><br><br>
            <input type="submit" value="Log In" style="width:200px;height:50px;font-size:25px">
        </form>
    </div>
    </body>
</html>