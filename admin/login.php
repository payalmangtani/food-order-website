<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title> 
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <!--login form starts here-->
            <form action="" method="POST" class="text-center">
                UserName:
                <input type="text" name="username" placeholder="Enter Username"><br><br>
                Password:
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
            </form>
            <!--login form ends here-->
            <p class="text-center">Created By - <a> Payal Mangtani </a></p>
        </div>
    </body>
</html>
<?php
    //chech whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for login
        //1.get the data from login form

        //echo $username = $_POST['username'];
        //echo $password = md5($_POST['password']);

        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2.create sql query to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3.Execute the query
        $res = mysqli_query($conn, $sql);

        //4.count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        
        if($count==1)
        {
            //User available and login success
            $_SESSION['login']="<div class='success'>Login Successful</div>";
            $_SESSION['user']=$username; //to check whether the user is logged in or not and if not username will be unset
            //Redirect to home page
            header('location:'.SETURL.'admin/');
        }
        else
        {
            //user not available and login failed
            $_SESSION['login']="<div class='error text-center'>Username or password does not match</div>";
        }   header('location:'.SETURL.'admin/');
    }
?>