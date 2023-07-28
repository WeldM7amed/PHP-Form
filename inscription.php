<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$msg = "";
if(isset($_POST["signup"])){
    // Connect to the Database
    mysql_connect("localhost", "root", "");
    mysql_select_db("APP_DB");
    // Import data from form
    $email = $_POST["email"];
    // Email exist ? print message : redirect to verification page;
    $req = "SELECT * FROM USERS WHERE EMAIL = '$email';";
    $res = mysql_query($req);
    if(!$res){
        $msg = "<h2>Request failed.<br>ERROR: ".mysql_error()."</h2>";
    }else{
        if(mysql_num_rows($res)!=0){
            $msg = "<p>There is an account with that email!</p>";
        }else{
            // Save user data until verification
            session_start();
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["name"]  = $_POST["name"];
            $_SESSION["pass"]  = $_POST["pass"];
            $_SESSION["code"]  = rand(100000,999999);
            // TODO: Send verification code via email

            // Redirect to verification page
            header("Location: verification.php");
            exit();
        }
    }   
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="pico.classless.min.css">
    <script>
        function valid(){
            var pass = document.getElementById('pass').value;
            var passCon = document.getElementById('passCon').value;
            return pass==passCon;
        }
    </script>
</head>
<body>
    <main>
        <h2>Inscription</h2>
        <form action="inscription.php" method="post" onsubmit="return valid();" >
            <input type="text" name="name" id="name" placeholder="Name" pattern="^[A-Za-z\s]+$" title="Alphabatical caracters and spaces only" required maxlength="50">
            <input type="email" name="email" id="email" placeholder="email" required maxlength="50">
            <input type="password" name="pass" id="pass" placeholder="password" pattern=".{8,}" title="Eight or more characters" required maxlength="100">
            <input type="password" name="passCon" id="passCon" placeholder="confirm password" required maxlength="100">
            <input type="submit" value="Sign Up" name="signup"> 
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <?php echo $msg; ?>
    </main>
</body>
</html>