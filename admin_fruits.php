<?php


$conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');


session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_fruits'])){

   $fname = mysqli_real_escape_string($conn, $_POST['name']);
   $fprice = mysqli_real_escape_string($conn, $_POST['price']);
   $fdetails = mysqli_real_escape_string($conn, $_POST['details']);
   $fimage = $_FILES['image']['name'];
   $fimage_size = $_FILES['image']['size'];
   $fimage_tmp_name = $_FILES['image']['tmp_name'];
   $fimage_folter = 'flowers/'.$fimage;

  // $select_fruits_name = mysqli_query($conn, "SELECT name FROM `fruits` WHERE name = '$fname") or die('query failed');

   // if(mysqli_num_rows($select_fruits_name) > 0){
   //    $fmessage[] = 'product name already exist!';
   // }else{
      $finsert_product = mysqli_query($conn, "INSERT INTO `fruits`(fruit_name, fruit_details, fruit_price, fruit_image) VALUES('$fname', '$fdetails', '$fprice', '$fimage')") or die('query failed');

      if($finsert_product){
         if($fimage_size > 2000000){
            $fmessage[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $fmessage[] = 'product added successfully!';
         }
      }
   // }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $select_delete_fimage = mysqli_query($conn, "SELECT image FROM `fruits` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `fruits` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new product</h3>
      <input type="text" class="box" required placeholder="enter product name" name="name">
      <input type="number" min="0" class="box" required placeholder="enter product price" name="price">
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add fruits" name="add_fruits" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_fproducts = mysqli_query($conn, "SELECT * FROM `fruits`") or die('query failed');
         if(mysqli_num_rows($select_fproducts) > 0){
            while($fetch_fproducts = mysqli_fetch_assoc($select_fproducts)){
      ?>
      
      <div class="box">
         <div class="price">₹<?php echo $fetch_fproducts['fruit_price']; ?>/-</div>
         <img class="image" src="flowers/<?php echo $fetch_fproducts['fruit_image']; ?>" alt="">
         <div class="name"><?php echo $fetch_fproducts['fruit_name']; ?></div>
         <div class="details"><?php echo $fetch_fproducts['fruit_details']; ?></div>
         <a href="admin_update_product.php?update=<?php echo $fetch_fproducts['fruit_id']; ?>" class="option-btn">update</a>
         <a href="admin_fruits.php?delete=<?php echo $fetch_fproducts['fruit_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>












<script src="js/admin_script.js"></script>

</body>
</html>