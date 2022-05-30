<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $pwd = $_POST["new_password"];
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Password must have atleast 8 characters.";
    } 
    elseif (!preg_match("#[0-9]+#", $pwd)) {
        $new_password_err = "Password must include at least one number!";
    }

    elseif (!preg_match("#[a-z]+#", $pwd)) {
        $new_password_err = "Password must include at least one lower case letter!";
    }  
    elseif (!preg_match("#[A-Z]+#", $pwd)) {
        $new_password_err = "Password must include at least one upper case letter!";
    }     
    elseif(!checkOldPasswords()){
        $new_password_err = "You can not use the passwords that you have used before";
    }
    elseif(!checkPasswordUpdateTime()){
        $new_password_err = "You must wait at least two hours to change the password again";
    }
     else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE users SET password = ? , updated_at = '$date' WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page

                $conn = mysqli_connect('localhost', 'root', '', 'account');
                $id = $_SESSION['id'];
                $sql2 = "INSERT INTO user_password (user_id, password) VALUES ('$id', '$param_password')";
                $result2 = mysqli_query($conn, $sql2);

                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
function checkPasswordUpdateTime()
{
    $conn = mysqli_connect('localhost', 'root', '', 'account');
    $id = $_SESSION['id'];
    $sql = "SELECT updated_at FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);  
    
    $date = strtotime(date('Y-m-d H:i:s'));
    $updatedDate = strtotime($row['updated_at']);

    $diff = $date - $updatedDate;

    $hours = floor($diff / (60 * 60));

    if($hours >= 2)
    {
        return true;
    }
    return false;      
}

function checkOldPasswords()
{
    $conn = mysqli_connect('localhost', 'root', '', 'account');
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM user_password WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);
    $r = 0;
    while ($row = mysqli_fetch_assoc($result)) 
    {
        if(password_verify($_POST["new_password"], $row['password']))
        {
            $r++;
        }
    }

   if($r == 0)
   {
        return true;
   }
    return false;      

}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="CheckPasswordStrength.css" rel="stylesheet" /> 
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="CheckPasswordStrength.js"></script> 
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>New Password</label>
                <div class="input-group mb-3">
                    <input type="password" name="new_password" id="txtPassword" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div id="strengthMessage"></div> 
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>