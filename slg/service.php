<?php

include 'config1.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home2.html');
   }else{
      $message[] = 'incorrect email or password!';
   }
}

if(isset($_POST['register'])){

   $name1 = mysqli_real_escape_string($conn, $_POST['name']);
   $email1 = mysqli_real_escape_string($conn, $_POST['email1']);
   $pass1 = mysqli_real_escape_string($conn, md5($_POST['password1']));
   $cpass1 = mysqli_real_escape_string($conn, md5($_POST['cpassword1']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email1' AND password = '$pass1'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message1[] = 'user already exist'; 
   }else{
      if($pass1 != $cpass1){
         $message1[] = 'confirm password not matched!';
      }
      else {
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password) VALUES('$name1', '$email1', '$pass1')") or die('query failed');

         if($insert){
            $message[] = 'registered successfully!';
            header('location:service.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
   <title>Login/Register as Service Provider</title>
</head>
<body style="background-color : #ffd700">
	<div class="container">
		<div class="blueBg">
         <div class="box signin">
            <h1 style="color : white;">Service Provider</h1>
            <br>
            <h2>Already have an Account ?</h2>
            <br>
            <button class="signinBtn">Login Now</button>
            <br>
            <h2><a href="index.html"> Go back </a></h2>

         </div>
         <div class="box signup">
            <h1 style="color : white;">Service Provider </h1>
            <br>
            <h2>Don't have an Account ?</h2>
            <br>
            <button class="signupBtn">Register Now</button>
            <br>
            <h2><a href="index.html"> Go back </a></h2>
         </div>
      </div>
      <div class="formBx">
         <div class="form signinForm">
            <form action="" method="post" enctype="multipart/form-data">
               <h3>Login</h3>
               <?php
                if(isset($message)){
                  foreach($message as $message){
                  echo '<div class="message">'.$message.'</div>';
                    }
                  }
                if(isset($message1)){
                     foreach($message1 as $message1){
                        echo '<div class="message">'.$message1.'</div>';
                     }
                  } 
               ?>
     
               <input type="email" name="email" placeholder="Enter Email" class="box" required>
               <input type="password" name="password" placeholder="Password" class="box" required>
               <a href="#" class="forgot">Forgot password ?</a>
               <br><br>
               <input style="background-color : #ffd700" type="submit" name="submit" value="LOGIN">
               
            </form>
         </div>
         <div class="form signupForm">
            <form action="" method="post" enctype="multipart/form-data">
               <h3>Register</h3>
            
               <input type="text" name="name" placeholder="Username" class="box" required>
               <input type="email" name="email1" placeholder="Email" class="box" required>
               <input type="password" name="password1" placeholder="Password" class="box" required>
               <input type="password" name="cpassword1" placeholder="Confirm Password" class="box" required>
               <input style="background-color : #ffd700" type="submit" name="register" value="REGISTER">
               
            </form>
         </div>
      </div>
	</div>
   
   <script>
      const signinBtn = document.querySelector('.signinBtn');
      const signupBtn = document.querySelector('.signupBtn');
      const formBx = document.querySelector('.formBx');
      const body = document.querySelector('body');
      
      signupBtn.onclick = function(){
         formBx.classList.add('active')
         body.classList.add('active')

      }

      signinBtn.onclick = function(){
         formBx.classList.remove('active')
         body.classList.remove('active')

      }

   </script>
</body>
</html>
