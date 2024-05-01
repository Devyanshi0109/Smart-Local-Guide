<?php

include 'config1.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:service.php');
};

if(isset($_POST['vehicle'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $vehicleType = mysqli_real_escape_string($conn, $_POST['vehicle']);

    $insert = mysqli_query($conn, "INSERT INTO `vehicle`(name, email, phone , address , city , state , vehicle) VALUES('$name', '$email', '$phoneNumber' , '$address' , '$city' , '$state' , '$vehicleType')") or die('query failed');
 
        if($insert){
             $message[] = 'vehicle registered submitted successfully!';
             header('location:home.html');
        }else{
             $message1[] = 'vehicle registered submission failed!';
          }
       }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Local Guide</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="fontawesome-free-5.15.3-web/css/all.min.css">
    <link rel="shortcut icon" href="CabRide_logo.png" type="img/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 15px;
        }
        button {
            background-color: #ff6600;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e65c00;
        }
    </style>
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
            <div class="text_color"><div class="text"><h1><a> Smart Local Guide </a></h1></div></div>
            <nav class="navbar">
                <a href="home2.html">Home</a>
                <a href="feedbackservice.php">Feedback</a>
                <a href="complain_service.html">Complain</a>
                <a href="about_service.html">About</a>
                <a href="service_profile.php">Profile</a>
            </nav>
            <a href="#" id="menu-bars" class="fas fa-bars"></a>
        </header>
        <div class="form-container">
        <h2>Register Your Vehicle</h2>
        <br>

        <form action="#" method="post">
            <label for="contactName">Full Name*</label>
            <input type="text" id="contactName" name="contactName" value="<?php echo $fetch['name']; ?>" required>

            <label for="email">Email Address*</label>
            <input type="email" id="email" name="email" value="<?php echo $fetch['email']; ?>" required>

            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phone">

            <label for="address">Address*</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City</label>
            <input type="text" id="city" name="city" required>

            <label for="state">State*</label>
            <input type="text" id="state" name="state" required>

            <label for="vehicleType">Vehicle Type*</label>
            <select id="vehicleType" name="vehicle" required>
                <option value="taxi">Taxi</option>
                <option value="Rickshaw">Rickshaw</option>
            </select>

            <button type="submit" name="vehicle">Attach Your Vehicle</button>
        </form>
    </div>