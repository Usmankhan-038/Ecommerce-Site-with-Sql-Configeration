<?php
session_start();

include('../server/connection.php');
if(isset($_SESSION['admin_logged_in']))
{
    header('Location:dashboard.php');
    exit;
}
if(isset($_POST['login_btn']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id,admin_name,admin_email,admin_password FROM admin WHERE admin_email=? AND admin_password=? LIMIT 1");
    $stmt->bind_param('ss',$email,$password);

    if($stmt->execute())
    {
       
        $stmt->bind_result($admin_id,$admin_name,$admin_email,$admin_password);
        $stmt->store_result();
        if($stmt->num_rows==1)
        {
            $stmt->fetch();
            $_SESSION['admin_id']=$admin_id;
            $_SESSION['admin_name']=$admin_name;
            $_SESSION['admin_email']=$admin_email;
            $_SESSION['admin_logged_in']=true;
            header('location:dashboard.php?login_success=Login Successfully');
        }
        else
        {
            header('location:login.php?error=could not verify your account');
        }
    }
    else
    {
        header('location:login.php?error=Something went wrong');
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .login-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        max-width: 350px;
        width: 100%;
    }
    
    .login-container h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    
    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    
    .login-container input[type="submit"] {
        background-color:coral;
        color: white;
        padding: 10px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        opacity: 0.7;
    }
    
    .login-container input[type="submit"]:hover {
        background-color: coral;
        opacity: 1;
        transition: 0.5s;
    }
</style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <form id="login-form" method="POST" action="login.php">
                    <p class="text-center"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="login-email" name="email" placeholder="Email"requiured/>
                    
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password"required/>
                    
                    </div>
                    <div class="form-group">
                       
                        <input type="submit" class="btn" id="login-btn" value="login" name="login_btn" />
                    
                    </div>
                    
                    </div>

                </form>
</div>
</body>
</html>
