<!-- //STEP: 9 - ইডিট পেইজ বানিয়ে সেটা লিংক করা ফাংশন পেইজের সাথে। এখানে index পেইজকে কপি করে নিয়ে আসা হয়েছে। -->

<?php

// পেইজ লিংক
include "function.php"; //যে পেইজের সাথে লিংক করবো, সেই পেইজের নাম

$objCrudAdmin = new crudApp(); //কানেকশন পেয়েছে কিনা চেক করা
// পেইজ লিংক

/// ডাটা রিড করার ফাংশনটি এখান থেকে এক্সেস করতে হবে এবং একটি ভ্যারিয়েবলের মধ্যে রেখে দিতে হবে যেন ভ্যারিয়েবল ধরে ব্যবহার করা যেতে পারে///

$students = $objCrudAdmin->display_data();

/// ডাটা রিড করার ফাংশন এক্সেস/// এই ভ্যারিয়েবল থেকে ডাটা ফেটস করে UI এর টেবিলে শো করতে হবে।

//STEP: 11 - এই পেইজ থেকে id ফাংশন পেইজে সেন্ড করতে হবে//

if (isset($_GET['status'])) {
    if ($_GET['status'] = 'edit') {
        $id = $_GET['id'];
        $returnData = $objCrudAdmin->display_data_by_id($id);
    }
}

if (isset($_POST['update_btn'])) {
    $updatedMsg = $objCrudAdmin->update_data($_POST);
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

        <form class="form" action="" method="POST" enctype="multipart/form-data">
    <!-- ডাটা সেইভ এর মেসেজ শো করা -->
    <?php
if (isset($updatedMsg)) {
// echo $updatedMsg;
    header("refresh:0;./");
}?>
<!-- এখানের নেম ফিল্ড গুলির ভালু চেঞ্জ হয়েছে নয়তো আগের ডাটার সাথে কনফ্লিক্ট হতে পারে -->
        <input class="form-control mb-2" type="text" name="u_std_name" value="<?php echo $returnData['std_name']; ?>">
        <input class="form-control mb-2" type="number" name="u_std_roll" value="<?php echo $returnData['std_roll']; ?>">
        <!-- <small><label for="image">Upload your Image</label></small> -->
        <input class="form-control mb-2" type="file" name="u_std_img">
        <input type="hidden" name='std_id' value="<?php echo $returnData['id']; ?>">
        <input type="submit" value="Update" name="update_btn" class="form-control bg-warning">

        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
