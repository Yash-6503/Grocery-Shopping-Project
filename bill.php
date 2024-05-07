<?php
@include 'config.php';

// Retrieve the order ID from the URL parameter
$order_id = $_GET['id'] ?? null;

// Ensure that the order ID is provided
if(!$order_id) {
    echo "Order ID not provided!";
    exit();
}

// Fetch the order details from the database
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id'") or die('query failed');
$order = mysqli_fetch_assoc($order_query);

// Ensure that the order exists
if(!$order) {
    echo "Order not found!";
    exit();
}

// Fetch the user details if needed
// $user_id = $order['user_id'];
// $user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'");
// $user = mysqli_fetch_assoc($user_query);

// Now, you can generate the bill HTML using the $order and $user variables
// Example:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Bill</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>Order Bill</h1>
    <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
    <p><strong>Name:</strong> <?php echo $order['name']; ?></p>
    <!-- Display other order details here -->

    <!-- You can customize the bill layout as needed -->
</body>
</html>
