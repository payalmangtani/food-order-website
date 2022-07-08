<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <?php
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Adding session message
                unset($_SESSION['add']); //Removing session message
            }
        ?>
        <br><br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter your Password"></td>
                </tr>
                <tr>
                    <td colspan="#">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php');?>
<?php
    //Process the value from form and save it in database
    //Check whether the button is clicked it or not
    if(isset($_POST['submit']))
    {
        // echo "Button Clicked";

        //1.Get the data from form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']); //Password Encryption with MD5
        $password = mysqli_real_escape_string($conn, $raw_password);
        //2. SQL Query to save the data into databse
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";

        //3. Executing Query and saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check Whether the(Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //echo "Data Inserted";
            //create a session varibale to display message
            $_SESSION['add']="Admin Added Successfully";
            //Redirect page
            header("location:".SETURL.'admin/manage-admin.php');
        }
        else
        {
            //echo "Failed to insert the data";
            //echo "Data Inserted";
            //create a session varibale to display message
            $_SESSION['add']="Admin Add Failed";
            //Redirect page
            header("location:".SETURL.'admin/add-admin.php');
        }
    }
    
?>