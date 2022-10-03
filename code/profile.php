<?php
//start sesstion
$title = "Profile";
include('includes/header.php');
function redirect($url)
{
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}
$sessionUse     = "";
if (isset($_SESSION['type'])) {
    $sessionUser = $_SESSION['type'];
}
if (isset($_SESSION['type']) && $_SESSION['type'] == 0) {
    // Query
    $sql = "SELECT * FROM users WHERE user_id='{$_SESSION["user_id"]}'";
    $result = mysqli_query($conn, $sql);
    $user  = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="page-header header-filter" data-parallax="true" style="background-image:url('images/product-04.jpg');">
</div>
<div class="main main-raised">
    <div class="profile-content" style="margin-bottom: 135px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="profile" style="text-align: center;">
                        <div class="avatar">
                            <img loading="lazy" src="./<?php echo $user[0]['user_image'] ?>" alt="photo"
                                style="margin-top:-90px; border-radius: 50%; width : 180px; height: 180px;">
                        </div>
                        <div class="name">
                            <h3 class="title"><?php echo $user[0]['user_name'] ?></h3>
                            <h6 class="created"><?php echo "Date created: " . $user[0]['user_creation_date'] ?></h6>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <h5 class="personal">Personal Details</h5>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f2">
                        <label for="fullName" class="fullname">Full Name</label>
                        <div class="borderDiv">
                            <p><?php echo $user[0]['user_name'] ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f f2">
                        <label for="eMail">Email</label>
                        <div class="borderDiv"><?php echo $user[0]['user_email'] ?></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f2">
                        <label for="phone">Phone</label>
                        <div class="borderDiv"><?php echo $user[0]['user_mobile'] ?></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f f2">
                        <label for="website">Password</label>
                        <div class="borderDiv">*********</div>
                    </div>
                </div>
            </div>
            <div class="row gutters">
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h6 class="mb-3 text-primary">Address</h6>
					</div> -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f2">
                        <label for="Street">Gender</label>
                        <div class="borderDiv"><?php echo $user[0]['user_gender'] == 0 ? "Male" : "Female"; ?></div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group f f2">
                        <label for="ciTy">Location</label>
                        <div class="borderDiv"><?php echo $user[0]['user_location'] ?> </div>
                    </div>
                </div>

                <div style="text-align: right;">
                    <a class="bt" href="edituserprofile.php" style="text-decoration: none;">
                        <button type="button" id="submit" name="submit" class="btn btn-primary">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>

</div>




<!-- ORDERS HISTORY -->

<?php
    require('admin/includes/connect.php');


    $id =  $user[0]['user_id'];
    // echo "the id is : " . $id;
    //know hot to access id 
    $sql = "SELECT * FROM orders WHERE order_user_id =$id";
    $result = mysqli_query($conn, $sql);
    $order  = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if ($order > 0) {
    ?>
<h2 class="text-center"> Your Orders History</h2><br>
<div class="order_cards d-flex w-75 flex-wrap  " style="margin:10px auto">
    <table class="table-shopping-cart" id="table1" style="width: 1000px;margin:10px auto">

        <thead>
            <tr class="table_head">
                <th>Order Detailes</th>
                <th>Order Location</th>
                <th>Order Mobile</th>
                <th>Order date</th>
                <th>Order total Amount</th>
                <th>status</th>
            </tr>
        </thead>
        <?php
                for ($i = 0; $i < count($order); $i++) {
                    $orders = explode('|', $order[$i]['order_details']);

                    // this step for using the image  
                    // $sql1 = "SELECT * FROM products WHERE product_id =$prod_id";
                    // $result1 = mysqli_query($conn, $sql1);
                    // $products  = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                    // u should use index 0 to access the record .

                ?>




        <tbody>
            <tr class="table_row">
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 flex justify-center items-center">
                        <?php
                                    for ($j = 0; $j < count($orders) - 1; $j++) {
                                        $order_details = explode(',', $orders[$j]);
                                        // echo "<pre>";
                                        // print_r($order_details);
                                        // echo "</pre>";

                                        $prod_name  = $order_details[0];
                                        $prod_price = $order_details[1];
                                        $prod_id = $order_details[2];
                                        $prod_size = $order_details[3];
                                        $prod_quantity = $order_details[4];
                                        echo "<p style='font-weight:bold;'>" .  $prod_name . "</p>";
                                        echo "<p style='color:#71e271;'>" .  $prod_price . "$</p>";
                                        echo "<p>Size = " .  $prod_size . "</p>";
                                        echo "<p>Quantity = " .  $prod_quantity . "</p>";
                                        echo "<hr style='width:50%;'>";
                                    }  ?>
                    </div>
                </td>
                <td>
                    <?php echo isset($order[$i]['order_location']) ? $order[$i]['order_location'] : ''; ?></td>
                <td><?php echo isset($order[$i]['order_mobile']) ? $order[$i]['order_mobile'] : ''; ?></td>
                <td><?php echo isset($order[$i]['order_date']) ? $order[$i]['order_date'] : ''; ?></td>
                <td><?php echo isset($order[$i]['order_total']) ? $order[$i]['order_total'] : ''; ?></td>
                <td><?php echo isset($order[$i]['order_status']) ? $order[$i]['order_status'] : ''; ?></td>
            </tr>
            <?php

                } ?>

        </tbody>
    </table>

    <?php
    }
    // echo $products[0]['product_name'];
    // echo "<pre>";
    // foreach ($users1 as $v) {
    //     print_r($v['product_id']);
    // }
    // echo "</pre>";
    // }
    // echo $users1[0]['product_main_image'];
    // echo "<pre>";
    // foreach ($users1 as $v) {
    //     print_r($v);
    // }
    // echo "</pre>";

    // orders view

        ?>


</div>









<!-- END ORDERS HISTORY -->
<?php
} else {
    header('location:sign_in.php');
    exit();
}
include('includes/footer.php');
    ?>
<?php
    if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0) {
        header('location:index.php');
    }
    ?>