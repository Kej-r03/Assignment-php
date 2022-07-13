<!-- Reviewer Information Display Page -->


<?php
session_start();

if($_SESSION['login']!==1)//if this page has not been opened after a successful login, redirect to login page
header("Location: Reviewer.php");
else
$_SESSION['login']=0;//this session variable just becomes 1 for the login instant, and then  becomes 0 again

require_once('connect.php');
$R_array=$_SESSION['Rarr'];//stores the row of the matching reviewer from the database


$S_table=$conn->query('SELECT * FROM Student');
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
</div><br><br>
        <hr><br><br>

        <!-- The following dashboard displays the contents of the MYSQL Student table, and in the assignment status columns, 
        the reviewer can make the necessary updates of any student's assignment status by just clicking on that cell -->
        
        
        <div>
        <h2 style="text-align:center"><u>Reviewer Dashboard</u></h1>
            
        <div style="margin-left:5vw"><u><h1>Assignment Info</u></h1>
            <ul style="font-size:20px">
                <li>Assignment 1: HTML CSS</li>
                <li>Assignment 2: OOPS</li>
                <li>Assignment 3: PHP</li>
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
                    <th>ASSIGNMENT 1 STATUS</th>
                    <th>ASSIGNMENT 2 STATUS</th>
                    <th>ASSIGNMENT 3 STATUS</th>
                </tr>

                <?php while($S_array=$S_table->fetch_array(MYSQLI_NUM)) {  ?>
                    <tr>
                        <td><?php echo $S_array[0]; ?></td>
                        <td><?php echo $S_array[1]; ?></td>
                        <td><?php echo $S_array[3]; ?></td>
                        <td><?php echo $S_array[4]; ?></td>
                        <td class="A" id="<?php echo $S_array[0]?>_6"><u><?php echo $S_array[6]; ?></u></td><!--id of each of these three column cells are stored as `rownumber_columnnumber` of the corresponding cells in the MYSQL database, like 1_6, 2_8, which helps in easier updation in the database by using id value-->
                        <td class="A" id="<?php echo $S_array[0]?>_8"><u><?php echo $S_array[8]; ?></u></td>
                        <td class="A" id="<?php echo $S_array[0]?>_10"><u><?php echo $S_array[10]; ?></u></td>
                    </tr>
                <?php } ?>
            </table>
                </div>
            </div>

        
        
        
        <div>
        <button onclick="document.location.href='../Home.php'" style="position: relative;left: 50%;transform: translate(-50%, 0);width:20vw;height:7vh;font-size:20px;">Home</button>
        </div>
        <hr>
        <br><br><br>


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
                alert('Scroll Down to Make Changes');
             });
             
             ele[i].setAttribute('title','Click to change');
            
            }

        function update()//on clicking update button of the assignment status update textarea , it makes AJAX request to the 'update.php' file and reflects the changes in this page 
        {
            
            var txt=document.getElementById("txt").value;
            document.getElementById('update_stat').style.display='none';//as soon as the assignment status is updated, the textarea disappears
                    
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.open("POST","update.php");
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