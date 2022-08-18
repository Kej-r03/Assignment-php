<!--Student Registration Page....Didnt keep website flow maintained-->

<?php

require_once('connect.php');
$res=$conn->query('SELECT * FROM Assignment');
$i=0;
?>





<html>
    <head>
        <title>Student Sign Up</title>
    </head>
    <body>
        <form action="Studentphp.php" method="post">
            <label for="user">Enter Username</label><br>
            <input type="text" id="user" name="NSuser" required><br><br>
            <label for="pwd">Enter password</label><br>
            <input type="password" id="pwd" name="NSpass" required><br><br>
            <label for="branch">Enter branch</label><br>
            <input type="text" id="branch" name="NSbranch" required><br><br>
            <label for="yr">Enter year</label><br>
            <input type="number" id="yr" name="NSyr" required><br><br><br>
            <p>Enter Assignment Status</p><br>

            <?php 
            while($array=$res->fetch_array(MYSQLI_NUM)){ ?>
            <label for="a_stat"><?php echo $array[0] ?></label><br>
            <input type="text" id="a_stat" name="<?php echo $i++ ?>" required><br><br>
            <?php } ?>
            <input type="submit" value="Register">
        </form>
    </body>
</html>