<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$msg = "";
if(isset($_POST["sub"])){
    // Connect to the Database
    mysql_connect("localhost", "root", "");
    mysql_select_db("APP_DB");
    // Import data from form
    $email = $_POST["email"];
    $pass  = $_POST["pass"];
    // Account exist ? redirect to main page : print message;
    $req = "SELECT * FROM USERS WHERE EMAIL = '$email' AND PASS = '$pass';";
    $res = mysql_query($req);
    if(!$res){
        $msg = "<h2>Request failed.<br>ERROR: ".mysql_error()."</h2>";
    }else{
        if(mysql_num_rows($res)!=1){
            $msg = "<p>There is no account with that email or wrong password</p>";
        }else{
            // Redirect to main page
            header("Location: main.html");
            exit();
        }
    }   
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <main>
        <h2>Login</h2>
        <form action="login.php" method="post">
            <input type="email" name="email" id="email" placeholder="email" required maxlength="50">
            <input type="password" name="pass" id="pass" placeholder="password" pattern=".{8,}" title="Eight or more characters" required maxlength="100">
            <input type="submit" name="sub" value="Login"> 
        </form>
        <p>Don't have an account? <a href="inscription.php">Sign up here</a></p>
        <?php echo $msg; ?>
    </main>
</body>
</html>