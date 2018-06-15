<?php
require_once('class/all.php');
 $all = new all();
 if(isset($_POST['submit'])  && ($_POST['csrf'] == $_SESSION['csrf']))
   {
        if ($all->login())
        {
             $_SESSION['user'] = true;
        }
 }
 ?>
<html>
<head>
    <title>User Login</title>
	  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="header">
    <h2>Login</h2>
</div>

<form action="" method="post">

    <div class="input-group">
        <label>User Email</label>
        <input type="email" name="email" value="">
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" value="">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf'];?>">
    </div>
    <div class="input-group">
        <input type="submit" class="btn" name="submit" value ="Login">
    </div>
    <p>
       <a href="register.php">Register</a>
    </p>
</form>
</body>
</html>
