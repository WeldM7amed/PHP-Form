<?php
error_reporting(E_ALL ^ E_DEPRECATED);
session_start();
$msg = "";
if(isset($_POST["sub"])){
    // Verification code right ? redirect to main page : print message;
    if($_SESSION["code"]!=$_POST["verif"]){
        $msg = "<p>wrong verification code</p>";
    }else{
        // Connect to the Database
        mysql_connect("localhost", "root", "");
        mysql_select_db("APP_DB");
        // Import data form session
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $pass = $_SESSION["pass"];
        // Insert into the Database
        $req = "INSERT INTO USERS VALUES('$name', '$email', '$pass');";
        $res = mysql_query($req);
        if(!$res){
            $msg = "<h2>Request failed.<br>ERROR: ".mysql_error()."</h2>";
        }else{
            $msg = "<p>Sucessful! redirecting to the main page...</p>";
            header("Location: main.html");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
</head>
<body>
    <main>
        <h2>Verification</h2>
        <?php echo $_SESSION["code"]; // For debugging purposes ?> 
        <form action="verification.php" method="post">
            <input type="text" name="verif" id="verif" placeholder="Verification code" pattern="[0-9]{6}" title="Six digit code" required>
            <input type="submit" name="sub" value="Login"> 
        </form>
        <?php echo $msg; ?>
    </main>
</body>
</html>