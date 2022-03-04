<?php

class crudApp
{
    /// STEP: 01 - ডাটাবেজ কানেকশন ///
    private $conn; //এই ভ্যারিয়েবল টিতে কানকেশন হোল্ড করবে

    public function __construct()
    {
        // ডাটাবেজ কানেকশনের জন্য এই ৪ টা জিনিস লাগবে, database host, database user , database pass, database name
        $dbhost = 'localhost'; //By Default
        $dbuser = 'root'; // Xampp user by default root
        $dbpass = ""; // Password empty string
        $dbname = 'crudapp'; //Database name

        $this->conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        // ডাটাবেজ এর সাথে কানেক্ট না হলে এই মেসেজ শো করবে।
        if (!$this->conn) {
            die("Database Connection Error!!");
        }
    }
    /// STEP: 01 - ডাটাবেজ কানেকশন ///

    // STEP: 04 - ফর্ম টু ডাটাবেজ সেইভ ফাংশন
    public function add_data($data)
    {
        //যেহেতু আমাদের $data তে ফর্ম এর ভ্যালু গুলি আছে, আমরা কিছু ভ্যারিয়েবলে ডাটা গুলি রেখে দিতে পারি
        $std_name = $data['std_name'];
        $std_roll = $data['std_roll'];
        //ইমেইজ পোস্ট এর মাধ্যমে পাস হয় না, ফাইলের মাধ্যমে হয়
        $std_img = $_FILES['std_img']['name'];
        //ইমেইজ ফাইলের নাম এক্সেস করা
        $tmp_name = $_FILES['std_img']['tmp_name'];

        //উপরের ইনফরমেশন গুলি ডাটাবেজ এ সেন্ড করতে হবে
        $query = "INSERT INTO students(std_name,std_roll,std_img) VALUE('$std_name',$std_roll,'$std_img')";

        //সেন্ড টু ডাটাবেজ
        if (mysqli_query($this->conn, $query)) {
            move_uploaded_file($tmp_name, 'upload/' . $std_img);
            return "Information Added Successfully";

        }
        // মেসেজ টি ইউআই তে শো করাতে চাইলে ফর্ম এর নিচে এড করতে হবে

    }
    // STEP: 04 - ফর্ম টু ডাটাবেজ সেইভ ফাংশন

    /// STEP: 05 - ডিসপ্লে ডাটা ফ্রম ডাটাবেজ টু UI ///
    public function display_data()
    {
        //ডাটাবেজ এর টেবিল থেকে সবকিছু নিয়ে আসার কুয়েরি
        $query = "SELECT * FROM students";
        //সেন্ড টু ডাটাবেজ
        if (mysqli_query($this->conn, $query)) {
            //ডাটাবেজ থেকে ডাটা নিয়ে এসে এই ভ্যারিয়েবলে রাখবে
            $returnData = mysqli_query($this->conn, $query);
            //এই রিটার্ন এর মাধ্যমে ভ্যারিয়েবল থেকে অন্য যে কোনো জায়গায় ডাটা শো করানো যাবে
            return $returnData;
        }
    }
    /// STEP: 05 - ডিসপ্লে ডাটা ফ্রম ডাটাবেজ টু UI///এর পর ui ফাইলে এই ফাংশন টি এক্সেস করতে হবে।

    //STEP: 10 - আইডি অনুযায়ী ডাটা নিয়ে আসার ফাংশন//
    public function display_data_by_id($id)
    {
        //ডাটাবেজ এর টেবিল থেকে যেগুলির আইডি ম্যাচ হবে সেগুলি নিয়ে আসবে
        $query = "SELECT * FROM students WHERE id=$id";

        //সেন্ড টু ডাটাবেজ
        if (mysqli_query($this->conn, $query)) {
            //ডাটাবেজ থেকে ডাটা নিয়ে এসে এই ভ্যারিয়েবলে রাখবে
            $returnData = mysqli_query($this->conn, $query);
            $studentData = mysqli_fetch_assoc($returnData);
            return $studentData;

        }
    }

    public function update_data($data)
    {
        $std_name = $data['u_std_name'];
        $std_roll = $data['u_std_roll'];
        $idNo = $data['std_id'];
        $std_img = $_FILES['u_std_img']['name'];
        $tmp_name = $_FILES['u_std_img']['tmp_name'];

        $query = "UPDATE students SET std_name = '$std_name',std_roll=$std_roll, std_img='$std_img' WHERE id = $idNo";

        if (mysqli_query($this->conn, $query)) {
            move_uploaded_file($tmp_name, 'upload/' . $std_img);
            return "Information update succesfully!";

        }
    }

    public function delete_data($id)
    {
        $catch_img = "SELECT * FROM students WHERE id=$id";
        $delete_std_info = mysqli_query($this->conn, $catch_img);
        $std_infoDle = mysqli_fetch_assoc($delete_std_info);
        $deleteImg_data = $std_infoDle['std_img'];
        $query = "DELETE FROM students WHERE id=$id";
        if (mysqli_query($this->conn, $query)) {
            unlink('upload/' . $deleteImg_data);
            return "Deleted Successfully!";
        }
    }

}
