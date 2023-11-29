<?php

require_once __DIR__ . '/../../controllers/MarketController.php';
require_once __DIR__ . '/../../controllers/StoreController.php';

use app\Models\Store\WhalesStore;
use app\Models\storeInfo\FormHandler;
use app\Models\User\User;

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sbmit-form'])) {
    $msg = FormHandler::handleFormSubmission();

    if ($msg == true) {
        User::updateUserStoreStatus($conn, 'reviewing', $_SESSION['user_id']);
        header("Location: /pending/Store");
        //require_once 'submited.php';
    }
} else {

?>

    <link rel="stylesheet" href="/public/Css/smod.css">
    <title>Creating Store</title>
    <legend>Your Store Info</legend>
    <form action="" method="post" enctype="multipart/form-data">
        <span style="text-align:center; color: red;">Remove all meta data from your images. We have a system to do that, but it's 50%. Please do it yourself!</span><br><br>
        <label for="name">Store Name<span style="color: red;">*</span></label>
        <input type="text" name="storeName" placeholder="Your store name..." required>
        <label for="to">Store Profile Image!<span style="color: red;">*</span></label>
        <input type="file" name="storeProfile" accept="image/png, image/jpeg, image/jpg" required>
        <label for="to">What are you selling?</label>
        <input type="text" name="selling" placeholder="What are you going to sell on Whales Market? Use commas (,) to separate the words.">
        <label for="to">Ship To?</label>
        <input type="text" name="shipto" placeholder="Where will you ship to? Default: (Worldwide). Use commas (,) to separate the countries.">
        <label for="from">Ship From?</label>
        <input type="text" name="shipfrom" placeholder="Where do you ship your products from? Default: (Unknown). Only 1 country needed!">
        <label for="Store Description">Store Description<span style="color: red;">*</span></label>
        <textarea name="storeDesc" cols="30" rows="10" placeholder="Your Store description..." required></textarea>
        <label for="sellon">Where do you sell on? (Required for old vendors)</label>
        <textarea name="sellOn" cols="30" rows="10" placeholder="Which markets do you have products on..."></textarea>
        <div class="images-product-proof">
            <label for="">Proof of product ownership: Your store name + Whales Market + timestamp! Be a great vendor, do it in bulk. ^_~<span style="color: red;">*</span></label>
            <input type="file" name="proof1" accept="image/png, image/jpeg, image/jpg" required>
            <input type="file" name="proof2" accept="image/png, image/jpeg, image/jpg" required>
            <input type="file" name="proof3" accept="image/png, image/jpeg, image/jpg" required>
        </div>
        <input type="submit" name="sbmit-form">
    </form>
<?php } ?>