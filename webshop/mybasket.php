<?php
  require_once('class/all.php');
  $all = new all();
  if (isset($_GET['itemdelete']))
   {
   $all->deleteitem($_GET['itemdelete']);
   }
?>
<?php include 'includes/header.php';?>
<?php
  if (isset($_GET['id'])){
  $all->addtoCart($_GET['id'],$_GET['qty']);
  }
  $ite= $all->getBasketitems();
?>
<div class="container">
 <table class="table table-striped" id="myTable">
    <thead>
      <tr>
        <th></th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price (€)</th>
        <th> Product Price (€) </th>
          <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($ite as $item) {
      ?>
      <tr>
        <td>  <img src="img/<?=$item['name'];?>.jpg" style="height:70px"></td>
        <td><?=$item['name'];?></td>
        <td> <?=$item['qty'];?></td>
      <td><?=$item['total'];?></td>
        <td><?=$item['total']*$item['qty'];?></td>
        <td><a class="btn btn-sm btn-primary" name="itemdelete" href="mybasket.php?itemdelete=<?=$item['id_products'];?>" style="float:right">Delete</a><td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <?php
    $amt=0;
    foreach ($ite as $item) {
      $amt = $amt + $item['total']*$item['qty'];
    } ?><h4 style="padding-top:70px">Total Price: (€) <?=$amt;?> </h4>
    <a class="btn btn-sm btn-primary" href="product.php" style="float:left">Continue Shopping</a>
    <?php if($amt>0) { ?>
     <a class="btn btn-sm btn-primary" id= "buy" href="myorders.php?amt=<?=$amt;?>"  style="float:right">Buy Now</a> 
    <!-- <a class="btn btn-sm btn-primary" id= "buy" href="confirm-userdetail.php?id=<?=$_SESSION['userid'];?>"  style="float:right">Buy Now</a> -->
  <?php }?>
</div>
<?php include 'includes/footer.php';?>
