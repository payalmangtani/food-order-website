<?php
    //include constants file
    include('../config/constants.php');
    
    //check whether id and image name is valid or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //1.Remove the physical image file if available 
        if($image_name != "")
        {
            //Image is available remove it
            $path = "../images/category/".$image_name;
            //Remove the image
            $remove = unlink($path);

            //If failed to remove image add the error msg and stop the process
            if($remove == false)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to remove the category image</div>";
                //set the session msg

                //Redirect to Manage Category Page
                header('location:'.SETURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }
        //2.then only we will delete data from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        //Execute the query
        $res= mysqli_query($conn, $sql);
        //whether data is deleted from database or not
        if($res==true)
        {
            //set success msg and recirect
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";
            //Redirect to Manage Category Page
            header('location:'.SETURL.'admin/manage-category.php');
        }
        else
        {
            //set error msg and redirect
            $_SESSION['delete'] = "<div class='error'>Category failed to Delete.</div>";
            //Redirect to Manage Category Page
            header('location:'.SETURL.'admin/manage-category.php');
        }
        //3.Redirect to Manage Category Page with msg

    }
    else
    {
        //Redirect to Manage Category Page
        header('location:'.SETURL.'admin/manage-category.php');
    }
?>