<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="title of food"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="description of food."></textarea>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                                //create php code to display categories from database
                                //1. create sql to get all active categoreis from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //executing query
                                $res = mysqli_query($conn, $sql);
                                //count queries to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //if count is graeter than zero , we have categories else we does not have categories
                                if($count>0)
                                {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of category
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not have categories
                                    ?>
                                    <option value="0">No category found.</option>
                                    <?php
                                }
                                //2.Display data from database
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            //check whether button is clicked or not
            if(isset($_POST['submit']))
            {
                //Add the food in Database
                //echo "Clicked";

                //1. Get the data from form
                $title = mysqli_real_escape_string($conn,$_POST['title']);
                $description = mysqli_real_escape_string($conn,$_POST['description']);
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";//setting the default value
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";//setting the default value
                }

                //2. Insert into database
                //check whether the select image is clicked or not and upload the image if image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of selected image
                    $image_name = $_FILES['image']['name'];
                    //check whether the image is selected or not and upload only if selected
                    if($image_name!="")
                    {
                        //image is selected
                        //A. rename the image
                        //get the extension of selected image(jpg, png, gif, etc) "payal-mangtani.jpg"  payal-mangtani.jpg
                        $ext = end(explode('.', $image_name));

                        //create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;//New image may be "Food-Name-657.jpg"

                    
                        //B. upload the image
                        //Get the src path and destination path


                        //source path is current location of image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //Finally Uploaded the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded or not
                        if($upload==false)
                        {
                            //Failed to upload image
                            //Redirect to Add Food Page with error msg
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload the Image.</div>";
                            header('location:'.SETURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }

                    }
                }
                else
                {
                    //set default value for image
                    $image_name = "";
                }


                //3. insert into database

                //create the sql query to save or Add food
                //for numerical value we need not pass values inside quotes '' But for string value we need to pass values in single quotes ''
                $sql2 = "INSERT INTO tbl_food SET 
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                ";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                if($res2==true)
                {
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
                    header('location:'.SETURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to add Food.</div>";
                    header('location:'.SETURL.'admin/manage-food.php');
                }

                //4. Redirect with msg to manage food page
            }
        ?>
    </div>
</div>


<?php include('partials/footer.php'); ?>