<?php
Class all {
  private $_conn;

  public function __construct(){
    $this->_conn = new PDO('mysql:host=localhost;dbname=webshop', 'root', '');
    session_start();
    $csrf = md5(openssl_random_pseudo_bytes(32));
    if (!isset($_SESSION['csrf'])){
        $_SESSION['csrf'] = $csrf;
    }
    $this->setCookie();
    // Session Timeout
    if(isset($_SESSION['LAST_ACTIVE']) && $_SESSION['LAST_ACTIVE']+120 <= time() ){
      session_destroy();
    }
    $_SESSION['LAST_ACTIVE'] = time();
  }
  // Method used to set cookie
  public function setCookie(){
      $time = time() + (86400 * 200 );
      if (!isset($_COOKIE['cookie_user'])){
          $cookie_user = md5(openssl_random_pseudo_bytes(32));
          setcookie("cookie_user", $cookie_user, $time);
      }
      if(isset($_SESSION['userid'])){
        $user_id=$_SESSION['userid'];
        $logged_in=1;
      }
      if(!isset($_SESSION['userid'])){
        $user_id=0;
        $logged_in=0;
      }
      $date=date('Y-m-d H:i:s', $time);
        $this->addCookies($_COOKIE['cookie_user'],$date,$user_id,$logged_in);
    }
// method used to add cookie to database
    public function addCookies($cookie_user,$time,$user_id,$logged_in){
      $sql = "INSERT INTO cookies (cookie_user,id_user,logged_in,login_expire) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE id_user = ? , logged_in = ?";
      try{
        $statement = $this->_conn->prepare($sql);
        $statement->execute(array($cookie_user, $user_id, $logged_in, $time,$user_id,$logged_in));
                //  echo ($_SESSION['userid']);
      //  $statement->debugDumpParams();
      }
      catch(PDOException $e){
        echo $e->getMessage();
      }
    }

 // list down all items
public function getproducts()
{
  return $this->_conn->query('SELECT * from products');
}

// login method
public function login(){
  $user = $_POST['email'];
  $pass = $_POST['password'];
  $message = "";

  if(empty($user) || empty($pass)) {
      $message = "Email or Password can not be empty";
  }
  else {
      $sql = "SELECT id, email, address, password FROM users WHERE email=? ";
      $query = $this->_conn->prepare($sql);
      $query->execute(array($user));
      //  $query->debugDumpParams();
      $fetch =$query->fetchAll();
      $fetchedPass = $fetch[0]['password'];
      if(password_verify($pass,$fetchedPass) && $query->rowCount() >= 1)
      {
        $_SESSION['user'] = $user;
          $_SESSION['userid'] = $fetch[0]['id'];

        header('Location: product.php');
      } else
          $message = "Email or Password is wrong";
      }
  }


// User Register method
public function Userregister()
{
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
  $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
  $email =  filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'];
  $pass_hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (firstname, lastname, address ,email, password)
  VALUES ('".$firstname."','".$lastname."','".$address."','".$email."','".$pass_hash."')";
  {
  if ($this->_conn->query($sql)) {
    header('Location: login.php');}
  else{
  echo "<script type= 'text/javascript'>alert('Data not Inserted.');</script>";
  }
}
}

// add item to basket
  public function addtoCart($id,$amount){
    $cookie_user = $_COOKIE['cookie_user'];
    $id=(int)$id;
    if((int)$amount>0){
      $sql = "SELECT * from products WHERE id = ?";
      try {
        $result = $this->_conn->prepare($sql);
        $result->execute(array($id));
        if ($result->rowCount() == 1){
          $sql = "INSERT INTO basket (cookie_user, id_products, amount) VALUES (?,?,?)";
            $result = $this->_conn->prepare($sql);
            $result->execute(array($cookie_user,$id,$amount));
            }
        else {
          echo "Product not found";
          }
      }
      catch(PDOException $e){
        echo $e->getMessage();
      }
    }
  }

// list all the items from basket table
  public function getBasketitems(){
    $sql = "SELECT a.id_products, sum(a.amount) as qty,b.name,sum(b.price) as total from basket as a inner join products as b on a.id_products = b.id
WHERE cookie_user = ? group by a.id_products, b.name ";
    try {
      $result = $this->_conn->prepare($sql);
      $result->execute(array($_COOKIE['cookie_user']));
      $fetchData = $result->fetchAll();
      return $fetchData;
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }
  }

// remove item from basket
  public function deleteitem($id_products)
  {
    $sql = "DELETE FROM basket WHERE id_products = ?";
    try{
      $statement = $this->_conn->prepare($sql);
      $statement->execute(array($id_products));
    }
    catch (PDOException $e)
    {
    echo $e->getMessage();
    }
  }

  // show user profile details
   public function getuserdetails(){
    $sql = "select * from users where id=?";
   try{
       $statement = $this->_conn->prepare($sql);
       $statement->execute(array($_SESSION['userid']));
       $fetchData = $statement->fetchAll();
       return $fetchData;
     }
     catch (PDOException $e){
     echo $e->getMessage();
     }
   }
//order methods
  public function addthisOrder($amount)
  {
    $query = "INSERT INTO orders (id_user, amountprice) VALUES (?,?)";
    try{
      $statement = $this->_conn->prepare($query);
      $statement->execute(array($_SESSION['userid'],$amount));
      if ($statement->rowCount() == 1){
        $query = "DELETE FROM basket WHERE cookie_user = ?";
        $statement = $this->_conn->prepare($query);
        $statement->execute(array($_COOKIE['cookie_user']));
      }
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

// get my orders
  public function getmyOrders()
  {
    $query = "SELECT id,amountprice,orderdate FROM orders WHERE id_user = ? ";
    try{
      $statement = $this->_conn->prepare($query);
      $statement->execute(array($_SESSION['userid']));
      $fetchData = $statement->fetchAll();
      return $fetchData;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

}
 ?>
