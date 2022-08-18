<!-- Reviewer Information Display Page -->


<?php
session_start();

if(!isset($_COOKIE['user_id']))
header("Location: ../Home.php");

if($_SESSION['ACreate']==1)
{
    echo "<script>alert('Assignment Created');</script>";
    $_SESSION['ACreate']=0;
}

require_once('connect.php');
$R_array=$_SESSION['Rarr'];//stores the row of the matching reviewer from the database

$res=$conn->query("SELECT * FROM Assignment");
$n=$res->num_rows;

if(isset($_POST['logout']))
{
    unset($_POST["logout"]);

    $st=$conn->prepare("DELETE FROM Per_Sessions WHERE token=?");//remove cookie from database
    $st->bind_param('s',$_COOKIE['user_id']);
    $st->execute();
            
    setcookie("user_id","",time()-3600,"/");//remove cookie from browser

    header("Location: ../Home.php");
}
?>





<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="R_Page.css">
        <title><?php echo $R_array[1] ?></title>
    </head>

    
    <body>
        <div>
        <h1 style="text-align:center;">Welcome User</h1>
        <h2 style="text-align:center"><u>Reviewer Profile</u></h1><hr><br><br>
        <div class="flex-container" style="display:flex;justify-content:space-around;font-size:25px">
            <div><b>ID : </b><?php echo $R_array[0] ?></div>
            <div><b>NAME: </b><?php echo $R_array[1] ?></div>
            <div><b>BRANCH : </b><?php echo $R_array[3] ?></div>
            <div><b>YEAR : </b><?php echo $R_array[4] ?></div>
            </div>
        </div>
        
        
        <br><br><hr><br><br>

        <!-- The following dashboard displays the contents of the MYSQL Student table, and in the assignment status columns, 
        the reviewer can make the necessary updates of any student's assignment status by just clicking on that cell -->
        
        
        <div>
        <h2 style="text-align:center"><u>Reviewer Dashboard</u></h1>
            
        <div style="margin-left:5vw"><u><h1>Assignment Info</u></h1>
            <ul style="font-size:20px">
                <?php $i=0; while($arr=$res->fetch_array(MYSQLI_NUM)) {?>
                <li>Assignment <?php echo ++$i." : ".$arr[0] ?></li>
                <?php } ?>
            </ul>
        </div>
        
        <div style="margin:5vw">
            <h1><u>Student Data</u></h1>
            
            <table>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>BRANCH</th>
                    <th>YEAR</th>
                    <?php for($i=1;$i<=$n;$i++) { ?>
                    <th>ASSIGNMENT <?php echo $i ?> STATUS</th>
                    <?php } ?>
                </tr>

                <?php $S_table=$conn->query('SELECT * FROM StudentData');
                 while($S_array=$S_table->fetch_array(MYSQLI_NUM)) { 
                     ?>
                <tr>
                    <td><?php echo $S_array[0]; ?></td>
                    <td><?php echo $S_array[1]; ?></td>
                    <td><?php echo $S_array[3]; ?></td>
                    <td><?php echo $S_array[4]; ?></td>
                    <?php  $res=$conn->query("SELECT * FROM Assignment");$i=0;
                        while($ar=$res->fetch_array(MYSQLI_NUM)){?>
                            <td class="A" id="<?php echo $i++.'_'.$S_array[0] ?>"><u><?php echo $ar[$S_array[0]] ?></u></td>
                    <?php } ?>
                </tr>
                <?php } ?>

            </table>

            </div>
            </div>

        
        
        <div><a href="Assignment_create.php">Create Assignment</a></div>
        
        
        
    <div>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <input type="submit" name="logout" Value="Log Out">
        </form>
    </div>



        <hr><br><br><br>


        <div id="update_stat"><!--this is the textarea for writing down updated status of the student's assignment, and it only appears after any cell of the assignment status columns is clicked-->
                <a href="Assignment.php">Open Assignment</a><!--Assignment link not implementted, but it is through which the uploaded assignment would be reviewed-->
                <br><br><br>
                <h3>Suggest Corrections</h3>
                <textarea id="txt" name="new_status" cols="100px" rows="5px" placeholder="Enter new status" ></textarea><br>
                <button onclick="update()">Update</button>
        </div>
        
        
        
        <script>
            
            ele=document.getElementsByClassName('A');
            var identity;

            for(i=0;i<ele.length;i++)
            {
             ele[i].addEventListener("click", function()
             {
                document.getElementById('update_stat').style.display='block';
                identity=this.id;
                
                window.scrollBy(0,5000);
             });
             
             ele[i].setAttribute('title','Click to change');
            
            }

        function update()//on clicking update button of the assignment status update textarea , it makes AJAX request to the 'update.php' file and reflects the changes in this page 
        {
            
            var txt=document.getElementById("txt").value;
            document.getElementById('update_stat').style.display='none';//as soon as the assignment status is updated, the textarea disappears
                    
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.open("POST","Assignmentphp.php");
            xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xmlhttp.send("upd="+txt+"&id="+identity);
            
            xmlhttp.onload=function(){
                location.reload();
                alert("Successfully updated");
            }
        }
        </script>
        
    </body>
</html>