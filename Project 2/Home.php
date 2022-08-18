<!-- Opening Page -->

<?php
require_once('All Files/connect.php');
session_start();

//variable initialization
$_SESSION['Home_visited']=true;//User cannot open any other page directly at first, he has to go through this home page
//user credentials error variable set to 0
$_SESSION['errSCred']=0;
$_SESSION['errRCred']=0;
if(isset($_COOKIE["user_id"]))
    {
        // retrieve id from database
        $cookieval=$_COOKIE["user_id"];
        $res=$conn->query("SELECT * FROM Per_Sessions WHERE token='$cookieval'");
        $arr=$res->fetch_array(MYSQLI_NUM);
        $id=substr($arr[0],0,strpos($arr[0],'_'));
        $yr=substr($arr[0],strpos($arr[0],'_')+1);

        if($yr=='4')
        {
            $Rres=$conn->query("SELECT * FROM Reviewer WHERE ID='$id'");
            $ar=$Rres->fetch_array(MYSQLI_NUM);
            $_SESSION['Rarr']=$ar;
            header("Location:All Files/RPage.php");
        }
        else if($yr=='2')
        {
            $Sres=$conn->query("SELECT * FROM StudentData WHERE ID='$id'");
            $ar=$Sres->fetch_array(MYSQLI_NUM);
            $_SESSION['Sarr']=$ar;
            header("Location:All Files/SPage.php");
        }
    }    
?> 





<html>
    <head>
        <title>
            Assignment Review System
        </title>
        <link rel="stylesheet" href="Home.css">
    </head>
    <body style="margin:0">
     <div id="header"><p style="text-align:center; font-size:30px;margin=0">Welcome to Assignment Review System</p><hr> </div>



<div id="main-body">
    <div id="select-box">
        <div style="background-color: rgb(28, 182, 87);border-radius:30px 30px 0px 0px; padding-top:5px;color:white;">
        <h2 style="text-align:center;margin:0;font-family: 'Arial'">Select if you are reviewer or student</h2>
        <hr style="background-color:black;">
       </div>
        <form id="frm" style="text-align:center; position:relative;top:20px" >

           <div style="display:inline-block;text-align:left"> 
            <input type="radio" id="Student" name="SelectionForm" style="height:15px;width:15px;position:relative;bottom:5px;">
            <label for="Student" style="font-size:50px">Student</label><br>
            <input type="radio" id="Reviewer" name="SelectionForm" style="height:15px;width:15px;position:relative;bottom:5px;">
            <label for="Reviewer" style="font-size:50px">Reviewer</label>
          </div>
          
          <br><br><br>

            <input id="submit" type="submit" value="Submit" onclick="fillaction()">
        </form>   
    </div>
</div>

        <script>
            function fillaction(){
                if(document.getElementById("Student").checked)
                document.getElementById("frm").setAttribute(`action`,`All Files/Student.php`);
                else if(document.getElementById("Reviewer").checked)
                document.getElementById("frm").setAttribute(`action`,`All Files/Reviewer.php`);
            }
        </script>
    </body>
</html>