<?php
use app\Models\Escrow\Escrow;
use app\Models\Extra\ExtraOption;
use app\Models\Message\Chat;
use app\Models\Message\ChatMembers;
use app\Models\Message\Message;
use app\Models\Notification\Notification;
use app\Models\orders\Orders;
use app\Models\Product\Product;
use app\Models\Reviews\Reviews;
use app\Models\Store\WhalesStore;

Notification::setConnection($conn);
$userID = Orders::getOrderById(decodeId($orderID))['user_id'];

?>

    <div class="notific-container">
        <h1 class="notifications-h1">Viewing > <?= "order"; ?></h1>
        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; margin-bottom: 2em;">
    For any further information or request, feel free to message the user directly. <a style="font-size: 1em;" href="/direct/inbox/<?= encodeId($userID); ?>" target="_blank" > Click here to message the user</a>
</p>
<?php

    $notify = Notification::singleOrderNotification($_SESSION['store_id'], decodeId($orderID));
    $createOn = Orders::getOrderById(isset($notify['order_id']) ? $notify['order_id'] : decodeId($orderID))['updated_on'];
    $timeDifference = getTimeDifference($createOn);
       
        if ($timeDifference['years'] > 0) {
            $lastUpdated =  $timeDifference['years'] == 1 ? $timeDifference['years'] . " year" : $timeDifference['years'] . " years";
        } elseif ($timeDifference['months'] > 0) {
            $lastUpdated =  $timeDifference['months'] == 1 ? $timeDifference['months'] . " month" : $timeDifference['months'] . " months";
        } elseif ($timeDifference['days'] > 0) {
            $lastUpdated =  $timeDifference['days'] == 1 ? $timeDifference['days'] . " day" : $timeDifference['days'] . " days";
        } elseif ($timeDifference['hours'] > 0) {
            $lastUpdated =  $timeDifference['hours'] == 1 ? $timeDifference['hours'] . " hour" : $timeDifference['hours'] . " hours";
        }elseif ($timeDifference['minutes'] > 0) {
            $lastUpdated =  $timeDifference['minutes'] == 1 ? $timeDifference['minutes'] . " minute" : $timeDifference['minutes'] . " minutes";
        }elseif ($timeDifference['seconds'] > 0) {
            $lastUpdated =  $timeDifference['seconds'] == 1 ? $timeDifference['seconds'] . " second" : $timeDifference['seconds'] . " seconds";
        } else {
            $lastUpdated =  "just now";
        }

?>
<!-- <p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
  <span style="color: green;">Completed:</span> Click the button to confirm order completion. Indicates successful transaction and satisfaction.
</p>

<p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
  <span style="color: darkred;">Sent:</span> Available if >3 days since order or status is not "pending." Click the button to raise concerns or issues.
</p>

<p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
  <span style="color: darkgreen;">Delivered:</span> Click the button to confirm order completion. Indicates successful transaction and satisfaction.
</p>

<p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
  <span style="color: darkgreen;">Processing:</span> Click the button to confirm order completion. Indicates successful transaction and satisfaction.
</p>

<p style="font-size: 1em; font-family: Verdana, Geneva, Tahoma, sans-serif; font-style:oblique;">
  <span style="color: darkred;">Cancel:</span> Available if >3 days since order or status is not "pending." Click the button to raise concerns or issues.
</p> -->

    <table class="notification-table">
    <tbody>
        <tr>
            <td><strong>Item</strong></td>
            <td>
                <?php
                $order = Orders::getOrderById(decodeId($orderID));
                $extra = ExtraOption::read($order['extra_id'], $order['product_id']);
                $extra_Default = ExtraOption::read(1, 0);

                echo '<a style="color: black !important;" href="/Item/'.encodeId($order['product_id']).'/'.encodeId(Product::get_product_by_id($conn, $order['product_id'])['store_id']).'">';
                echo Product::get_product_by_id($conn, $order['product_id'])['product_name'];
                echo '</a>';
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Cost Per Item</strong></td>
            <td>
                <?php echo '$'.Product::get_product_by_id($conn, $order['product_id'])['price']; ?>
            </td>
        </tr>
        <tr>
            <td><strong>Extra Cost</strong></td>
            <td>
                <?php echo '$' . (isset($extra) && isset($extra['cost']) ? $extra['cost'] : $extra_Default['cost']); ?>
            </td>
        </tr>
        <tr>
            <td><strong>Total Cost</strong></td>
            <td>
                <?php echo '$'.Product::get_product_by_id($conn, $order['product_id'])['price'] * $order['quantity']; ?>
            </td>
        </tr>
        <tr>
            <td><strong>Quantity</strong></td>
            <td><?php echo $order['quantity']; ?></td>
        </tr>
        <tr>
            <td><strong>Last Updated</strong></td>
            <td><?php echo $lastUpdated.' ago'; ?></td>
        </tr>
        <tr>
            <td><strong>Payment</strong></td>
            <td><?php echo Escrow::isProductInEscrow($order['product_id']) ? "Escrow" : 'Fernalize Early'; ?></td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>
  <?php
    $orderStatus = $order['order_status'];

    if ($orderStatus == 'pending') {
      echo '<span style="color: skyblue;">Pending</span>';
    } elseif ($orderStatus == 'processing') {
      echo '<span style="color: green;">Processing</span>';
    } elseif ($orderStatus == 'shipped') {
      echo '<span style="color: orange;">Shipped</span>';
    } elseif ($orderStatus == 'delivered') {
      echo '<span style="color: darkorange;">Delivered</span>';
    } elseif ($orderStatus == 'dispute') {
      echo '<span style="color: darkred;">Dispute</span>';
    } elseif ($orderStatus == 'sent') {
      echo '<span style="color: blue;">Sent</span>';
    }elseif ($orderStatus == 'completed') {
        echo '<span style="color: darkgreen;">Completed';
      } else {
      echo 'Unknown Status';
    }
  ?>
        </tr>
        <tr>
            <td><strong>Action</strong></td>
            <td>
            <form action="" method="post">
                <input type="hidden" name="orderID" value="<?=$orderID;?>"> 
                <?php
                    if (($timeDifference['days'] > 2 && $orderStatus == 'pending')) {
                        echo '<a href="" class="cancel">Cancel</a>';
                    }
                    if ($orderStatus == 'pending') {
                        echo '<input type="submit" id="processing" name="processing"  value="Process">';
                    }elseif ($order['order_status'] == 'processing') {
                        echo '<input type="submit" title="This button is for digital products if you\'ve sent the product." style="background-color: darkgreen; font-family: Verdana, Geneva, Tahoma, sans-serif;" id="processing" name="sent"  value="Sent">';
                        echo '<input type="submit" class="shipped" name="shipped" style="font-family: Verdana, Geneva, Tahoma, sans-serif;"  value="Shipped">';
                        echo '<input type="submit" style="background-color: darkgreen; font-family: Verdana, Geneva, Tahoma, sans-serif;" id="processing" name="delivered"  value="Delivered">';
                        echo '<input type="submit"  id="cancel" title="This button is to dispute this order."  class="dispute" name="cancel" style="font-family: Verdana, Geneva, Tahoma, sans-serif;" value="Cancel">';
                       
                    }elseif ($orderStatus == 'shipped') {
                        echo '<input type="submit" style="background-color: darkgreen; font-family: Verdana, Geneva, Tahoma, sans-serif;" id="processing" name="delivered"  value="Delivered">';
                        echo '<input type="submit"  id="cancel" title="This button is to dispute this order."  class="dispute" name="cancel" style="font-family: Verdana, Geneva, Tahoma, sans-serif;" value="Cancel">';

                    }elseif ($orderStatus == 'sent') {
                        echo '<input type="submit"  id="cancel" title="This button is to dispute this order."  class="dispute" name="cancel" style="font-family: Verdana, Geneva, Tahoma, sans-serif;" value="Cancel">';

                    }elseif ($orderStatus == 'delivered') {
                        echo '<input type="submit"  id="cancel" title="This button is to dispute this order."  class="dispute" name="cancel" style="font-family: Verdana, Geneva, Tahoma, sans-serif;" value="Cancel">';

                    }elseif ($orderStatus == 'dispute') {
                        echo 'This order is under dispute now.';
                        echo '<input type="submit"  id="cancel" title="This button is to view or add dispute message."  class="dispute" name="dispute-message" style="font-family: Verdana, Geneva, Tahoma, sans-serif;" value="Dispute Message">';

                    }elseif ($orderStatus == 'completed') {
                        echo 'Thank you, this order has been completed.';
                    }
                ?>
            </form>
            </td>
        </tr>
    </tbody>
</table>

<div style="display: flex; flex-direction:column; justify-content:center; align-items:center;">

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['orderID'])) {
        $id = validateUserInput($_POST['orderID'], $conn);
       
        if (isset($_POST['dispute']) && $_POST['dispute'] === 'Dispute') {
            
            echo '<p>You are trying to start a dispute for this current order, Please state your reason below.</p>';
            echo '<form action="" method="post" style="text-align:center;"><textarea name="dispute-reason" class="support-msg" id="dispute" cols="90" rows="10" placeholder="Dispute reason here..." required></textarea> <br><br> <input type="submit" name="release" style="color: darkgreen; border-radius: 3px; border: none; font-size: 1.3em; cursor: pointer;" value="Submit"></form>';

        }elseif (isset($_POST['processing']) && $_POST['processing'] === 'Process') {
            Orders::updateOrderStatus(decodeId($orderID), 'processing');
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }elseif (isset($_POST['sent']) && $_POST['sent'] === 'Sent') {
            Orders::updateOrderStatus(decodeId($orderID), 'sent');
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }elseif (isset($_POST['delivered']) && $_POST['delivered'] === 'Delivered') {
            Orders::updateOrderStatus(decodeId($orderID), 'delivered');
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }elseif (isset($_POST['cancel']) && $_POST['cancel'] === 'Cancel') {
            Orders::updateOrderStatus(decodeId($orderID), 'dispute');
            $messageUserID = WhalesStore::getStore($_SESSION['store_id'])['owner_id'];
            messageSystem($conn, $messageUserID, $order['user_id'], $messageUserID, "I have been wating a while now.");
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }elseif (isset($_POST['shipped']) && $_POST['shipped'] === 'Shipped') {
            Orders::updateOrderStatus(decodeId($orderID), 'shipped');
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }elseif (isset($_POST['dispute-message']) && $_POST['dispute-message'] === 'Dispute Message') {
            
            echo '<meta http-equiv="refresh" content="0;URL=\'\store\\order\\'.$orderID.'\'"/>';

        }
}
        ?>
        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif;"><strong>**Shipping Address or Extra Info**</strong></p>
        <textarea name="" id="" cols="30" rows="10" style="font-family: Verdana, Geneva, Tahoma, sans-serif; width: 80%;"><?php echo  $order['shipping_address'];?></textarea>
</div>
    </div>
</div>
