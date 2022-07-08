<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php
            //chcek whether the id is set or not
            if(isset($_GET['id']))
            {
                //Get the id and other details
                //echo "Getting the data";
                $id = $_GET['id'];
                //create sql query to get other details
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count the rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to manage category page
                    $_SESSSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header('location:'.SETURL.'admin/manage-category.php');
                }

            }
            else
            {
                //redirect to manage category page
                header('location:'.SETURL.'admin/manage-category.php');
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image !="")
                            {
                                //Display image
                                ?>
                                    <img src="<?php echo SETURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Display msg
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1.Get all the values from our form
                $id = $_POST['id'];
                $title = mysqli_real_escape_string($conn,$_POST['title']);
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Update new image if selected
                //check whether image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the image details
                    $image_name = $_FILES['image']['name'];

                    //check whether image is available or not
                    if($image_name !="")
                    {
                        //Image available
                        //A. Upload the new image
                        //Auto rename image
                        //get the extension(jpg png,gif,etc) eg."foo1.jpg"<--input image name
                        $ext = end(explode('.',$image_name));

                        //Rename the img
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext;//concatenation eg."Food_Category_834.jpg <--Final converted image


                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;//concatenation

                        $upload = move_uploaded_file($source_path, $destination_path);

                        //chcek whether the image is uploaded or not
                        //if not we will stop process and redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div>";
                            //Redirect to add category page
                            header('location:'.SETURL.'admin/manage-category.php');
                            //stop process
                            die();
                        }
                        //B. Remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);
                            //check whether image is removed or not
                            //if failed to remove then display msg and stop process
                            if($remove==false)
                            {
                                //failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'>failed to remove current image.</div>";
                                header('location:'.SETURL.'admin/manage-category.php');
                                die();//stop the process
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3. update the Database
                $sql2 = "UPDATE tbl_category SET 
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //4.Redirect to manage category page
                //check whether executed or not
                if($res2==true)
                {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>category Updated Successfully.</div>";
                    header('location:'.SETURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>category Update Failed</div>";
                    header('location:'.SETURL.'admin/manage-category.php');
                }
            }
        ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>