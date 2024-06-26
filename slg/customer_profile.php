<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:customer.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.html');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile update</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="update.css">

</head>
<body>
   
<div class="container">

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
      ?>
      <h3><?php echo $fetch['name']; ?></h3>
      <a href="update_customer.php" class="btn">update profile</a>
      <a href="index.html?logout=<?php echo $user_id; ?>" name="logout" class="delete-btn">logout</a>
      <p>new <a href="customer.php">login / register</a> </p>
   </div>

</div>

</body>
</html>
