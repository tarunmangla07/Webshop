
<?php
  require_once('class/all.php');
  $all = new all();
if (!isset($_SESSION['user'])) {
  header('Location:login.php');
  }
?>
<?php include 'includes/header.php';?>
<?php
if (isset($_POST['amt']))
{
    $all->addthisOrder($_POST['amt']);
}
  $ite= $all->getmyOrders();
?>
<div class="container">
  <h2> Congratulations! Your order has been Placed...</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Amount (€)</th>
        <th>Date of Order</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($ite as $item) {
      ?>
      <tr>
        <td><?=$item['id'];?></td>
        <td>€ <?=$item['amountprice'];?></td>
        <td><?=$item['orderdate'];?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <a class="btn btn-sm btn-primary" href="product.php" style="float:right">Continue Shopping</a>
</div>
<?php include 'includes/footer.php';?>
