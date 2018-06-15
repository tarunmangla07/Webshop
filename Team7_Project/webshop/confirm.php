<?php
  require_once('class/all.php');
  $all = new all();
?>
<?php include 'includes/header.php';?>
<?php
if (!isset($_SESSION['user'])) {
  header('Location:login.php');
  }
?>
<div class="container">
 <table class="table table-striped" id="confirmtable">
    <thead>
      <tr>
        <th>Name</th>
        <th>email</th>
          <th>Address </th>
        <th>Amount (€)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $_SESSION['details']['firstname']?></td>
        <td><?= $_SESSION['details']['email']?></td>
        <td><?= $_SESSION['details']['address']?></td>
        <td><?=$_POST['amt'];?></td>
          </tr>
        </tbody>
      </table>
      <form action ='myorders.php' method='POST'>
            <input type="hidden" name='amt' value=<?=$_POST['amt'];?>>
            <input type='submit' class="btn btn-sm btn-primary" value='Confirm Order'>
      </form>

<?php include 'includes/footer.php';?>
