<?php
session_start();
include('server/connection.php');
if(isset($_POST['register']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];
    if($password!=$confirmPassword)
    {
        header('location: register.php?error=password don\'t match');

    }
    else if(strlen($password)<6)
    {
        header('location: register.php?error=password must be at least 6 characters');
    }
    else
    {
        $stmt1=$conn->prepare("SELECT COUNT(*) From users WHERE user_email=?");
        $stmt1->bind_param('s',$email);
        $stmt1->execute();
        $stmt1->bind_result($num_rows);
        $stmt1->store_result();
        $stmt1->fetch();
        if($num_rows!=0)
        {
            header('location: register.php?error=User with this email is already exist');
    
        }
        else
        {
            $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password) VALUES (?,?,?)");
            $stmt->bind_param("sss",$name,$email,md5($password));
            if($stmt->execute())
            {
                $user_id=$stmt->insert_id;
                $_SESSION['user_id']=$user_id;
                $_SESSION['user_email']=$email;
                $_SESSION['user_name']=$name;
                $_SESSION['logged_in']=true;
                header('location: account.php?register_success=You Registered Successfully');
            }
            else
            {
                header('location: register.php?error=Registration Failed');
            }
            
        }
    }
}
else if($_SESSION['logged_in'])
{
    header('location:account.php');
    exit;
}


?>


<?php include('layout/header.php')?>

      <!--Register-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
            </div>
            <div class="mx-auto container">
                <form id="register-form" method="POST">
                    <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name"requiured/>
                
                </div>
                
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="register-email" name="email" placeholder="Email"requiured/>
                    
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password"required/>
                    
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="register-confirm password" name="confirmPassword" placeholder="Confirm Password"required/>
                    
                    </div>
                    <div class="form-group">
                       
                        <input type="submit" class="btn" name="register" id="register-btn" value="Register" />
                    
                    </div>
                    <div class="form-group">
                        <a id="login-url" class="btn" href="login.php">Do you have a account? Login</a>
                    
                    </div>

                </form>
            </div>
      </section>













      <!--footer-->
      <?php include('layout/footer.php')?>
