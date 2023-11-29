<div class="dash-grid">
    <div class="total-sales">
        <a href="/store/sales">SALES</a>
        <p><?= $currentStore['width_sales'];  ?></p>
    </div>
    <div class="total-sales">
        <a href="/store/sales">Store Views</a>
        <p><?= $currentStore['width_sales'];  ?></p>
    </div>
    <div class="total-sales">
        <a href="/store/sales">Favorited</a>
        <p><?= $currentStore['width_sales'];  ?></p>
    </div>
    <div class="total-sales">
        <a href="/store/sales">Blocked</a>
        <p><?= $currentStore['width_sales'];  ?></p>
    </div>
    <div class="total-orders">
        <a href="/store/orders">ORDERS</a>
        <p>23 / TODAY</p>
    </div>
    <div class="total-orders">
        <a href="/store/orders">Disputes</a>
        <p>23 / TODAY</p>
    </div>
    <div class="total-returns">
        <a href="/store/returns">Reports</a>
        <p><?= $currentStore['width_sales'];  ?></p>
    </div>
    <div class="all-reviews">
        <a href="/store/reviews">Positive Reviews</a>
        <p><?= $reviewsCounts  ?></p>
    </div>
    <div class="all-reviews">
        <a href="/store/reviews">Neutral Reviews</a>
        <p><?= $reviewsCounts  ?></p>
    </div>
    <div class="all-reviews">
        <a href="/store/reviews">Negative Reviews</a>
        <p><?= $reviewsCounts  ?></p>
    </div>
    <div class="top-listings">
        <a href="/store/products">PRODUCTS</a>
        <p> <?= $product_count ?> </p>
    </div>
    <div class="top-listings">
        <a href="/store/products">PRODUCTS Views</a>
        <p> <?= $product_count ?> </p>
    </div>
    <div class="top-earning">
        <a href="/store/earnings">EARNINGS</a>
        <p>0 / 0.000 XMR</p>
    </div>
</div>