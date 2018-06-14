<?php
  require_once('class/all.php');
  $all = new all();

$ite= $all->getuserdetails();
?>
<?php include 'includes/header.php';?>

<div class="container">
 <table class="table table-striped" id="table">
    <thead>
      <tr>
        <th>First Name </th>
          <th>Last Name </th>
        <th>Address</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($ite as $item) {
      ?>
      <tr>
        <td><?=$item['firstname'];?></td>
        <td><?=$item['lastname'];?></td>
        <td><?=$item['address'];?></td>
        <td><?=$item['email'];?></td>

        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php include 'includes/footer.php';?>
