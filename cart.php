<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Strict session verification engine 
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit();
}

$user_id = $_SESSION['user_id'];

// Add to Cart handler node logic 
if(isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id) VALUES ($user_id, $product_id)");
    }
}

// Remove from Cart handler node logic 
if(isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE id=$id AND user_id=$user_id");
}

// Extract current user cart nodes from database 
$cart = mysqli_query($conn, "SELECT cart.id, products.name, products.price, products.description, products.image 
                              FROM cart 
                              JOIN products ON cart.product_id = products.id 
                              WHERE cart.user_id=$user_id");
$total = 0;
$item_count = mysqli_num_rows($cart);
?>

<style>
/* ==========================================================================
   NEO-BRUTALIST SHOPPING ENGINE GRID THEME HOOKS
   ========================================================================== */
.cart-root-wrapper {
    margin-top: 30px;
    margin-bottom: 140px; /* Expands buffer space to push the dark Gumroad footer down cleanly */
}

.cart-hero-heading {
    font-size: 2.5rem;
    font-weight: 900;
    letter-spacing: -1.2px;
    color: #000000;
    margin-bottom: 8px;
}
.cart-hero-heading span {
    background: var(--primary-color);
    border: 2px solid #000000;
    padding: 0px 10px;
    border-radius: 8px;
    box-shadow: 2.5px 2.5px 0px #000000;
    font-size: 1.2rem;
    font-weight: 800;
    vertical-align: middle;
}

.cart-hero-sub {
    font-size: 1rem;
    color: #555555;
    font-weight: 600;
    margin-bottom: 40px;
}

/* Modular Shopping List Cards Layout */
.brutal-cart-item {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 5px 5px 0px #000000;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: var(--transition-premium);
}
.brutal-cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 7px 7px 0px #000000;
}

/* Fixed 16:9 Thumbnail preview box for uniform shape dimensions */
.cart-item-thumb-box {
    width: 130px;
    aspect-ratio: 16 / 9;
    border: 2px solid #000000;
    border-radius: 10px;
    overflow: hidden;
    background-color: var(--surface-color);
    flex-shrink: 0;
    position: relative;
}
.cart-item-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-item-fallback {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #FF90E8 0%, #764ba2 100%);
    color: #ffffff;
    font-size: 1.3rem;
    font-weight: bold;
}

.cart-item-details {
    flex-grow: 1;
}

.cart-item-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #000000;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cart-item-desc {
    font-size: 0.82rem;
    color: #555555;
    font-weight: 600;
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-width: 400px;
}

.cart-item-price-tag {
    font-size: 1.1rem;
    font-weight: 900;
    color: #000000;
    flex-shrink: 0;
    padding-right: 15px;
}

/* Brutalist Trash/Remove Anchor Button */
.btn-brutal-remove {
    background-color: #FFFFFF;
    color: var(--danger-color);
    border: 2px solid #000000;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 2px 2px 0px #000000;
    transition: var(--transition-premium);
    text-decoration: none;
    flex-shrink: 0;
}
.btn-brutal-remove:hover {
    background-color: var(--danger-color);
    color: #FFFFFF;
    transform: translate(-1px, -1px);
    box-shadow: 3px 3px 0px #000000;
}

/* Right Column Summary Box Card Panel */
.brutal-summary-panel {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 6px 6px 0px #000000;
    position: sticky;
    top: 110px;
}

.summary-heading {
    font-weight: 900;
    font-size: 1.3rem;
    text-transform: uppercase;
    letter-spacing: -0.5px;
    color: #000000;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2.5px solid #000000;
}

.summary-data-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #4A5568;
}

.summary-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 2.5px solid #000000;
    color: #000000;
}
.summary-total-title {
    font-weight: 800;
    font-size: 1.05rem;
    text-transform: uppercase;
}
.summary-total-value {
    font-weight: 900;
    font-size: 1.5rem;
}

.btn-brutal-checkout {
    width: 100%;
    background-color: var(--primary-color); /* #FF90E8 Theme Pink */
    color: #000000;
    border: 3px solid #000000;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px;
    box-shadow: 4px 4px 0px #000000;
    cursor: pointer;
    transition: var(--transition-premium);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 25px;
    text-decoration: none;
}
.btn-brutal-checkout:hover {
    background-color: var(--primary-hover);
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0px #000000;
    color: #000000;
}

.empty-cart-illustration {
    border: 3px dashed #000000;
    padding: 60px 40px;
    text-align: center;
    background-color: var(--surface-color);
    border-radius: 20px;
    max-width: 650px;
    margin: 0 auto;
}
</style>

<div class="cart-root-wrapper">
    <h2 class="cart-hero-heading">Your Cart <span><?= $item_count ?> BUNDLES</span></h2>
    <p class="cart-hero-sub">Review your deployment components and initialize checkout routines.</p>

    <?php if($item_count > 0): ?>
        <div class="row g-4">
            
            <div class="col-lg-8">
                <?php 
                while($item = mysqli_fetch_assoc($cart)):
                    $total += $item['price']; 
                    
                    $safe_name = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
                    $safe_desc = htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');
                    $safe_img  = htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8');
                ?>
                    <div class="brutal-cart-item">
                        
                        <div class="cart-item-thumb-box">
                            <?php if(!empty($item['image'])): ?>
                                <img src="<?= $safe_img ?>" class="cart-item-thumb-img" alt="" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none');">
                            <?php endif; ?>
                            <div class="cart-item-fallback <?= !empty($item['image']) ? 'd-none' : '' ?>">CODE</div>
                        </div>

                        <div class="cart-item-details">
                            <h5 class="cart-item-title" title="<?= $safe_name ?>"><?= $safe_name ?></h5>
                            <p class="cart-item-desc">
                                <?= !empty($item['description']) ? $safe_desc : 'Production verified source component asset node bundle.' ?>
                            </p>
                        </div>

                        <div class="cart-item-price-tag">
                            Rs. <?= number_format($item['price']) ?>
                        </div>

                        <a href="cart.php?remove=<?= $item['id'] ?>" class="btn-brutal-remove" title="Remove element node">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                    </div>
                <?php endwhile; ?>
            </div>

            <div class="col-lg-4">
                <div class="brutal-summary-panel">
                    <h4 class="summary-heading">Order Summary</h4>
                    
                    <div class="summary-data-row">
                        <span>Total Items</span>
                        <span><?= $item_count ?> package nodes</span>
                    </div>
                    <div class="summary-data-row">
                        <span>Digital Delivery</span>
                        <span class="text-success fw-bold">FREE INSTANT</span>
                    </div>
                    <div class="summary-data-row">
                        <span>Database Tax</span>
                        <span>Rs. 0</span>
                    </div>

                    <div class="summary-total-row">
                        <span class="summary-total-title">Grand Total</span>
                        <span class="summary-total-value">Rs. <?= number_format($total) ?></span>
                    </div>

                    <a href="checkout.php" class="btn-brutal-checkout">
                        Proceed to Checkout <i class="fa-solid fa-lock ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div class="empty-cart-illustration animate-slide-up">
            <div style="font-size: 3.5rem; margin-bottom: 15px;">🛒</div>
            <h4 class="fw-bold mb-2">Your Repository Cart is Empty</h4>
            <p class="text-muted small mb-4" style="max-width: 420px; margin: 0 auto 20px auto;">
                You haven't mapped any software modules or plugins to your local queue structure yet.
            </p>
            <a href="index.php" class="btn-brutal-primary" style="text-decoration:none;">
                <i class="fa-solid fa-folder-open me-1"></i> Browse Component Database
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>