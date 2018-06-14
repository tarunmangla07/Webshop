<?php

require_once('class/all.php');
 $all = new all();

 if(isset($_POST["submit"]) && ($_POST['csrf'] == $_SESSION['csrf'])){

 $all->Userregister();
 }
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Register Form</title>
   <link rel="stylesheet" type="text/css" href="css/style.css">
<script>
    var validate = function() {
        if (document.getElementById('password').value ==
            document.getElementById('password_2').value) {
            document.getElementById('show').style.color = 'green';
            document.getElementById('show').innerHTML = 'Matching';
        } else {
            document.getElementById('show').style.color = 'red';
            document.getElementById('show').innerHTML = 'Password does not match';
        }
    }
</script>

</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>

  <form method="post" action="" >
  	<div class="input-group">
      <label>First Name</label>
      <input type="text" name="firstname" value="" required>
    
    </div>
    <div class="input-group">
      <label>Last Name</label>
      <input type="text" name="lastname" value="" required>
    </div>
    <div class="input-group">
      <label>Address</label>
      <input type="text" name="address" value="" required>
    </div>
    <div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="" required>
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password" value ="" id="password" onkeyup="validate()" required>
       <input type="hidden" name="csrf" value="<?=$_SESSION['csrf'];?>">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" id="password_2" onkeyup="validate()" required>
        <span id='show'></span>
  	</div>

  	<div class="input-group">
  	  <input type="submit" class="btn" name="submit" value ="Register">
  	</div>
  	<p>
  		Registered Already? <a href="login.php">Login</a>
  	</p>
  </form>


</body>
</html>
