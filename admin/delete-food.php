<?php 
    //echo "Delete Food";

    //include constnats.php
    include('../config/constants.php');


    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to delete
        echo "Process to Delete";

        //1. Get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2.Remove the image if available
        //check whether image is available or not and delete only if available
        if($image_name !="")
        {
            //it has image and need to remove from database
            //Get the image path
            $path = "../images/food/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            //check whether image is removed or not
            if($remove==false)
            {
                //failed to remove
                $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
                //Redirect to manage food page
                header('location:'.SETURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }

        //3. Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Execute the query
        $res = mysqli_query($conn, $sql);
        
        //check whether the query executed or not set the session message respectively
        if($res==true)
        {
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('location:'.SETURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to delete Food.</div>";
            header('location:'.SETURL.'admin/manage-food.php');
        }

        //4. Redirect to manage food page with session message
    }
    else
    {
        //Redirect to manage food page
        //echo "Redirect";
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SETURL.'admin/manage-food.php');
    }

?>