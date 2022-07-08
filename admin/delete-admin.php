<?php

// include constants.php file here
    include('../config/constants.php');
// 1.gET THE ID OF ADMIN TO BE DELETED
    $id = $_GET['id'];

// 2. CRAEATE SQL QUERY TO DELETE THE ADMIN
    $sql = "DELETE FROM tbl_admin  WHERE id=$id";

// 3. REDIRECT TO MANAGE ADMIN PAGE WITH MSG(SUCCESS/ERROR)
    $res = mysqli_query($conn, $sql);

// check whether the query executed successfully or not
    if($res==true)
    {
        //Query executed successfully and admin deleted
        //echo "admin added successfully";
        $_SESSION['delete'] = "<div class='success'>admin deleted successfully</div>";
        //redirect to manage admin page
        header('location:'.SETURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin
        $_SESSION['delete'] = "<div class='error'>admin deleted successfully</div>";
        header('location:'.SETURL.'admin/manage-admin.php');
    }
?>  
