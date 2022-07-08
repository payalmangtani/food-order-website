<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; //Adding session message
                unset($_SESSION['add']); //Removing session message
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload']; //Adding session message
                unset($_SESSION['upload']); //Removing session message
            }
        ?>
        <br><br>
        <!--Add category form starts here-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
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
                        <td>Select Image:</td>
                        <td>
                            <input name="image" type="file">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </tr>
            </table>
        </form>
        <!--Add category form ends here-->
        <?php
            //check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                $title=mysqli_real_escape_string($conn,$_POST['title']);

                //for radio input type we need to check whether button is selected or not
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured=$_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured="No";
                }
                if(isset($_POST['active']))
                {
                    //get the value from form
                    $active=$_POST['active'];
                }
                else
                {
                    //set the default value
                    $active="No";
                }


                //check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES[]);

                //die();//break the code here

                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //to upload image we need image name and source path and destination path
                    $image_name = $_FILES['image']['name'];
                    //upload image only if image is selected
                    if($image_name !="")
                    {
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
                            header('location:'.SETURL.'admin/add-category.php');
                            //stop process
                            die();
                        }
                    }
                }
                else
                {
                    //set the value as blank
                    $image_name="";
                }
                //2.create sql query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";

                //3.Execute the query
                $res = mysqli_query($conn, $sql);
                
                //4.check whether the query is executed or not and data is added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    //Redirect to Manage Category Page
                    header('location:'.SETURL.'admin/manage-category.php');
                }
                else
                {
                    //query not exceuted and category not added
                    $_SESSION['add'] = "<div class='error'>Category Add Failed.</div>";
                    //Redirect to Add Category Page
                    header('location:'.SETURL.'admin/add-category.php');

                }
            }
        ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>