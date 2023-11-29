<?php
require_once __DIR__ . '/../../controllers/MarketController.php';
require_once __DIR__ . '/../../controllers/StoreController.php';


use app\Models\categories\Category;
use app\Models\Product\Product;

$product = Product::get_product_by_id($conn, decodeId($pid));
?>
<div class="container">
    <div class="first-container">
        <legend style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 2rem; text-align: center;">Update your Listing --<?php echo $product['product_name']; ?></legend>
        <p style="text-align:center; padding: 2px; background-color: red; color: white; font-family:Verdana, Geneva, Tahoma, sans-serif;">NOTE: If you update a product it will needed to be compare(review) before marged.</p>
    </div>
    <form method="post" class="form-container" enctype="multipart/form-data">
        <label for="product_description" class="form-label">Product Description:</label>
        <textarea id="product_description" class="form-textarea" name="product_description" placeholder="Describe your product well here... " required><?php echo $product['product_description']; ?></textarea>

        <label for="price" class="form-label">Price USD $:</label>
        <input type="number" id="price" class="form-input" name="price" value="<?php echo $product['price']; ?>" required>

        <input type="hidden" name="product_id" value="<?= encodeId($product['product_id']); ?>">


        <label for="quantity" class="form-label">Quantity:</label>
        <input type="number" id="quantity" class="form-input" name="quantity" min="1" value="<?php echo $product['in_stocks']; ?>" required>

        <input type="submit" name="update_listing" class="submit-nxt" value="Update">
    </form>

</div>