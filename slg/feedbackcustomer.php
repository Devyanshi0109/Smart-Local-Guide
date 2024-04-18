<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:customer.php');
};

if(isset($_POST['feedback'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $feedback = mysqli_real_escape_string($conn,$_POST['feedback']);

    $insert = mysqli_query($conn, "INSERT INTO `feedback`(name, email, feedback) VALUES('$name', '$email', '$feedback')") or die('query failed');
 
        if($insert){
             $message[] = 'Feedback submitted successfully!';
             header('location:home.html');
        }else{
             $message1[] = 'Feedback submission failed!';
          }
       }
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>

    <link rel="stylesheet" href="style1.css">
    <link rel="shortcut icon" href="CabRide_logo.png" type="img/x-icon">
    
</head>
<body>
    <?php
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
       $fetch = mysqli_fetch_assoc($select);
    }
    ?>
    <div class="main-container">
        <div class="background-text">
            
        </div>
        <header class="header">
            <div class="text_color"><div class="text"><h1><a href="home.html"> Smart Local Guide </a></h1></div></div>
            <nav class="navbar">
                <a href="home.html">Home</a>
                <a href="complain_customer.html">Complain</a>
                <a href="about_customer.html">About</a>
                <a href="customer_profile.php">Profile</a>
            </nav>
            <a href="#" id="menu-bars" class="fas fa-bars"></a>
        </header>
        <br>
        <br>
<div class="inner-content">

    <div class="contact-form">
        <div class="feedback-form">
            <div>
            <h1><strong>Customer Feedback Form </strong></h1>
            <br>
            <br>
            <form action="#" method="post">
               
                <input type="text" id="name" name="name" placeholder="name" value="<?php echo $fetch['name']; ?>">
                <br>
                <br>

                <input type="email" id="email" name="email" placeholder="email" value="<?php echo $fetch['email']; ?>">
                <br>
                <br>
        
                <textarea id="feedback" name="feedback" rows="4" required placeholder="feedback"></textarea>
                <br>
                <br>

                <button type="submit" name="feedback" class="feedback"> Submit Feedback </button>
            </form>
        </div>
        </div>

    </div>
        </body>
        </html>


            
    