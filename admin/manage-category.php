<?php include('partials\menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br /><br /><br />
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; //Adding session message
                unset($_SESSION['add']); //Removing session message
            }
            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove']; //Adding session message
                unset($_SESSION['remove']); //Removing session message
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete']; //Adding session message
                unset($_SESSION['delete']); //Removing session message
            }
            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found']; //Adding session message
                unset($_SESSION['no-category-found']); //Removing session message
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update']; //Adding session message
                unset($_SESSION['update']); //Removing session message
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload']; //Adding session message
                unset($_SESSION['upload']); //Removing session message
            }
            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove']; //Adding session message
                unset($_SESSION['failed-remove']); //Removing session message
            }

        ?>
        <br><br>
        <!--Button to add admin-->
        <a href="<?php echo SETURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Actionss</th>
            </tr>
            <?php
                //Query to fetch data from table
                $sql="SELECT * FROM tbl_category";

                //Exexcute the query
                $res=mysqli_query($conn, $sql);

                //To get count of rows of data
                $count = mysqli_num_rows($res);

                $sn=1;//serial variable number start with 1

                //check whether we have data in database or not
                if($count>0)
                {
                    //If data is available display the data

                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        $featured=$row['featured'];
                        $active=$row['active'];
                            
                        ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <?php
                                        //check whether image name is available or not
                                        if($image_name!="")
                                        {
                                            //Display the image
                                            ?>
                                                <img src="<?php echo SETURL; ?>images/category/<?php echo $image_name; ?>"  width="100px" alt="">
                                            <?php
                                        }
                                        else
                                        {
                                            //Display the message
                                            echo "<div class='error'>Image not available</div>";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SETURL; ?>admin/update-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary"> Update Category</a>
                                    <a href="<?php echo SETURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Category</a>
                                </td>
                            </tr>

                        <?php
                    }
                }
                else
                {
                    //we do not have data
                    //we'll display the message inside table
                    ?>
                        <tr>
                            <td><div class="error">No Category added</div></td>
                        </tr>

                    <?php
                }
            ?>
        </table>
    </div>
</div>
<?php include('partials\footer.php')?>