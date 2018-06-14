<?php
require_once('class/all.php');
 $all = new all();
 ?>
<?php include 'includes/header.php';?>

<?php
    foreach ($all->getproducts() as  $product) {
?>
<section>
  <div class="container py-3">
    <div class="card">
      <div class="row ">
        <div class="col-md-4">
            <img src="img/<?=$product['name'];?>.jpg" class="w-100">
          </div>

          <div class="col-md-8 px-3">
            <div class="card-block px-3">
              <h4 class="card-title"><?=$product['name']; ?></h4>
                  <p class="card-text"><b>Price:</b> (€)<?=$product['price']; ?></p>
                  <p class="card-text"><b>Description:</b> <?=$product['description']; ?></p>
                    <form action="mybasket.php">
                      <input type="hidden" name="id" value="<?=$product['id'];?>">
                      <input type="text" name="qty"  value="" placeholder="Enter Quantity">
                      <input class="btn btn-sm btn-primary" value="Add to Basket" onclick="this.form.submit()">
                    </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
    }
  ?>
<?php include 'includes/footer.php';?>
