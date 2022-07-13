<!-- Opening Page -->

<?php
session_start();

//variable initialization
$_SESSION['Home_visited']=true;//User cannot open any other page directly at first, he has to go through this home page
//user credentials error variable set to 0
$_SESSION['errSCred']=0;
$_SESSION['errRCred']=0;
?>
<html>
    <head>
        <title>
            Assignment Review System
        </title>
    </head>
    <body>
        <h1 style="text-align:center; font-size:60px"><u>Welcome to Assignment Review System</u></h1><hr>

    <div style="border:2px solid black;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);width:40vw;height:30vh;">
        <h2 style="text-align:center">Select if you are reviewer or student</h2><hr>
        <form id="frm" style="text-align:center; position:relative;top:20px" >
           <div style="display:inline-block;text-align:left"> <input type="radio" id="Student" name="SelectionForm" style="height:15px;width:15px;position:relative;bottom:5px;">
            <label for="Student" style="font-size:50px">Student</label><br>
            <input type="radio" id="Reviewer" name="SelectionForm" style="height:15px;width:15px;position:relative;bottom:5px;">
            <label for="Reviewer" style="font-size:50px">Reviewer</label></div><br><br>
            <input type="submit" value="Submit" onclick="fillaction()" style="height:50px;width:100px;font-size:20px">
        </form>   
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