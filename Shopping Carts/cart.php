<?php include('connect.php');
// update mysqli_query
if (isset($_POST['update_product_quantity'])) {
    $update_value = $_POST['update_quantity'];
    //echo $update_value;
    $update_id = $_POST['update_quantity_id'];
    //echo $update_id;
    // query
    $update_quantity_query = mysqli_query($conn, "update cart set quantity=$update_value where id=$update_id");
    // echo "updated successfully";
    if ($update_quantity_query) {
        header('lacation:cart.php');
    }

}
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    echo $remove_id;
    mysqli_query($conn, "delete from cart where id=$remove_id");
    header('location:cart.php');
}
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "delete from cart");
    header('lacation:cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page-Project</title>
    <!-- css file-->
    <link rel="stylesheet" href="css/style.css">
    <!-- font awsome link--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <!-- include header -->
    <?php include('header.php'); ?>
    <div class="container">
        <section class="shopping_cart">
            <h1 class="heading">MY CART</h1>
            <table>
                <?php
                $select_cart_products = mysqli_query($conn, "select * from cart");
                $num = 1;
                $grand_total = 0;
                if (mysqli_num_rows($select_cart_products) > 0) {
                    echo "<thead>
                    <th>Sl NO</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>";
                    while ($fectc_cart_products = mysqli_fetch_assoc($select_cart_products)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $num ?>
                            </td>
                            <td>
                                <?php echo $fectc_cart_products['name'] ?>
                            </td>
                            <td>
                                <img src="images/mouse.jpg" alt="Laptop">
                            </td>
                            <td>$
                                <?php echo $fectc_cart_products['price'] ?>/-
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" value="<?php echo $fectc_cart_products['id'] ?>"
                                        name="update_quantity_id">
                                    <div class="quantity_box">
                                        <input type="number" min="1" value="<?php echo $fectc_cart_products['quantity'] ?>"
                                            name="update_quantity">
                                        <input type="submit" class="update_quantity" value="update"
                                            name="update_product_quantity">
                                    </div>
                                </form>
                            </td>
                            <td>$
                                <?php echo $subtotal = number_format($fectc_cart_products['price'] * $fectc_cart_products['quantity']) ?>/-
                            </td>
                            <td>
                                <a href="cart.php?remove=<?php echo $fectc_cart_products['id'] ?>"
                                    onclick="return confirm('Are you sure to delete this item')">
                                    <i class="fas fa-trash"></i><br>Remove
                                </a>
                            </td>
                        </tr>
                        <?php
                        //$grand_total=$grand_total+($fectc_cart_products['price']* $fectc_cart_products['quantity']);
                        $grand_total += ($fectc_cart_products['price'] * $fectc_cart_products['quantity']);
                        $num++;
                    }
                } else {
                    echo "<div class='empty_text'>Cart is empty</div>";
                }

                ?>

                <tbody>

                </tbody>
            </table>
            <!-- php code -->
            <!-- bottom area -->
            <?php
            if ($grand_total > 0) {
                echo " <div class='table_bottom'>
                     <a href='shop_products.php' class='bottom_btn'>Continue shopping</a>
                    <h3 class='bottom_btn'>Grand total: $<span>$grand_total/-</span></h3>
                    <a href='checkout.php' class='bottom_btn'>Proceed to checkout</a>
                    </div>";
                ?>

                <a href="cart.php?delete_all" class="delete_all_btn"
                 onclick="return confirm('Are you sure to delete all item')">
                    <i class="fas fa-trash"></i>Delete All
                </a>
                <?php
            } else {
                echo "";
            }
            ?>
        </section>
    </div>
</body>

</html>