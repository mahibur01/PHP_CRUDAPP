<?php

// STEP: 02 - পেইজ লিংক
include "function.php"; //যে পেইজের সাথে লিংক করবো, সেই পেইজের নাম

$objCrudAdmin = new crudApp(); //কানেকশন পেয়েছে কিনা চেক করা
// STEP: 02 - পেইজ লিংক

// STEP: 03 - ফর্ম এর ডাটা রিসিভ করা
if (isset($_POST['submit'])) {
    //সেন্ড ডাটা টু $data
    $return_msg = $objCrudAdmin->add_data($_POST);

}

/// STEP: 06 - ডাটা রিড করার ফাংশনটি এখান থেকে এক্সেস করতে হবে এবং একটি ভ্যারিয়েবলের মধ্যে রেখে দিতে হবে যেন ভ্যারিয়েবল ধরে ব্যবহার করা যেতে পারে///

$students = $objCrudAdmin->display_data();

/// STEP: 06 - ডাটা রিড করার ফাংশন এক্সেস/// এই ভ্যারিয়েবল থেকে ডাটা ফেটস করে UI এর টেবিলে শো করতে হবে।

if (isset($_GET['status'])) {
    if ($_GET['status'] = 'delete') {
        $delete_id = $_GET['id'];
        $delMsg = $objCrudAdmin->delete_data($delete_id);
    }
}

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CRUD APP</title>
  </head>
  <body>
    <div class="container my-4 p-4 shadow">

        <h2 class="text-center"> <a style="text-decoration: none;" href="./"> Student Database</a></h2>

        <?php if (isset($delMsg)) {
    // echo $delMsg;
    header("refresh:0;./");
}
?>

        <form class="form" action="" method="POST" enctype="multipart/form-data">

        <input class="form-control mb-2" type="text" name="std_name" placeholder="Name: ">
        <input class="form-control mb-2" type="number" name="std_roll" placeholder="Roll: ">
        <!-- <small><label for="image">Upload your Image</label></small> -->
        <input class="form-control mb-2" type="file" name="std_img">
        <input type="submit" value="Add Info" name="submit" class="form-control bg-warning">
         <!-- ডাটা সেইভ এর মেসেজ শো করা -->

    <!-- // (isset($return_msg)) {echo $return_msg; header("refresh:0.5;./");} -->

        </form>
    </div>

    <div class="container my-4 p-4 shadow">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Roll</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
           <!-- STEP: 07 - ডাটা UI তে শো করানো Fetch করা  -->
                <?php while ($student = mysqli_fetch_assoc($students)) {?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['std_name']; ?></td>
                    <td><?php echo $student['std_roll']; ?></td>
                    <td><img style="height: 40px;width: 40px;" src="upload/<?php echo $student['std_img']; ?>"></td>
                    <td>
                        <!-- STEP: 08 - ইডিট বাটন থেকে আইডি পাওয়া  -->
                        <a class="btn btn-success" href="edit.php?status=edit&&id=<?php echo $student['id']; ?>">Edit</a>
                        <a class="btn btn-warning" href="?status=delete&&id=<?php echo $student['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
