<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>
        <form action="" method="POST"> 
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Clicked";

        //1. get the data from form
        $id=$_POST['id'];
        $current_raw_password= md5($_POST['current_password']);
        $current_password= mysqli_real_escape_string($conn,$current_raw_password);
        $new__raw_password= md5($_POST['new_password']);
        $new_raw_password= mysqli_real_escape_string($conn,$new_raw_password);
        $confirm__raw_password= md5($_POST['confirm_password']);
        $confirm_password= mysqli_real_escape_string($conn, $confirm_raw_password);
        //2. check whether the user with current id and current password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //3. check whether the new password and confirm password match or not
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //check whether data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //user exists and password can be changed
                echo "user found";
                //check whether the new password and confirm password match or not
                if($new_password==$confirm_password)
                {
                    //update password
                    echo "Password Matched!";
                    $sql2 = "UPDATE tbl_admin SET 
                    password='$new_password'
                    WHERE id=$id
                    ";

                    //Execute query
                    $res2 = mysqli_query($conn, $sql2);

                    //check whether the query is executed or not
                    if($res2==true)
                    {
                        //Display Success msg
                        //Rediret to manage admin page
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully. </div>";
                        //Redirect to the user
                        header('location:'.SETURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //Display Error msg
                        $_SESSION['change-pwd'] = "<div class='success'>Failed to Change Password. </div>";
                        //Rediret to manage admin page
                        header('location:'.SETURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //Display Error msg
                    $_SESSION['pwd-not-match'] = "<div class='success'>Password did not match. </div>";
                    //Rediret to manage admin page
                    header('location:'.SETURL.'admin/manage-admin.php');
                }
            
            }
            else
            {
                //user does not exist set msg and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User is not found</div>";
                header('location:'.SETURL.'admin/manage-admin.php');
            }
        }

        //4. change password if all above is true
    }
?>
<?php include('partials/footer.php');?>