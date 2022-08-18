<!--Reviewer Registration Page....Didnt keep website flow maintained-->
    <html>
    <head>
        <title>Reviewer Sign Up</title>
    </head>
    <body>
        <form action="Reviewerphp.php" method="post">
            <label for="user">Enter Username</label><br>
            <input type="text" id="user" name="NRuser" required><br><br>
            <label for="pwd">Enter password</label><br>
            <input type="password" id="pwd" name="NRpass" required><br><br>
            <label for="branch">Enter branch</label><br>
            <input type="text" id="branch" name="NRbranch" required><br><br>
            <label for="yr">Enter year</label><br>
            <input type="number" id="yr" name="NRyr" required><br><br>
            <input type="submit" value="Register">
        </form>
    </body>
</html>