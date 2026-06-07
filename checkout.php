<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Strict session validation gateway 
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit();
}

$user_id = $_SESSION['user_id'];
$cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id");

// Execute backend purchase pipeline loop transferring cart items to order nodes
while($item = mysqli_fetch_assoc($cart)) {
    mysqli_query($conn, "INSERT INTO orders (user_id, product_id, status) VALUES ($user_id, {$item['product_id']}, 'Completed')");
}

// Clear local cart repository entries for the current authenticated user
mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
?>

<style>
/* ==========================================================================
   NEO-BRUTALIST CHECKOUT SUCCESS EMISSION SCREEN THEME
   ========================================================================== */
.checkout-root-container {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 20px 180px 20px; /* Strong vertical bounds keep the dark footer driven down */
}

.brutal-success-card {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 24px;
    box-shadow: 6px 6px 0px #000000;
    width: 100%;
    max-width: 500px;
    padding: 50px 40px;
    text-align: center;
    transition: var(--transition-premium);
    position: relative;
}
.brutal-success-card:hover {
    transform: translateY(-2px);
    box-shadow: 8px 8px 0px #000000;
}

/* Central Neon Success Token Element Frame */
.brutal-celebration-badge {
    width: 80px;
    height: 80px;
    background-color: var(--primary-color); /* #FF90E8 Theme Accent Pink */
    border: 3px solid #000000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 25px auto;
    box-shadow: 3px 3px 0px #000000;
}

.checkout-success-title {
    font-size: 1.8rem;
    font-weight: 900;
    letter-spacing: -0.8px;
    color: #000000;
    margin-bottom: 8px;
}

.checkout-success-sub {
    font-size: 0.95rem;
    color: #555555;
    font-weight: 600;
    line-height: 1.5;
    max-width: 360px;
    margin: 0 auto 35px auto;
}

/* Control Row Action Tray Anchors Alignment */
.checkout-btn-tray {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 320px;
    margin: 0 auto;
}

.checkout-btn-tray .btn-brutal-primary,
.checkout-btn-tray .btn-brutal-secondary {
    padding: 12px 24px;
    font-size: 0.9rem;
    justify-content: center;
    width: 100%;
}
</style>

<!-- Main Processing Complete Workspace View -->
<div class="checkout-root-container">
    <div class="brutal-success-card animate-slide-up">
        
        <!-- Central Animated Vector Badge Element Box -->
        <div class="brutal-celebration-badge">
            🎉
        </div>
        
        <h3 class="checkout-success-title">Order Placed Successfully!</h3>
        <p class="checkout-success-sub">
            Transaction processing completed. Your digital distribution package node is ready for immediate deployment.
        </p>
        
        <!-- Platform Navigation Directory Links Tray -->
        <div class="checkout-btn-tray">
            <!-- Maintained original location routes verbatim -->
            <a href="orders.php" class="btn-brutal-primary">
                <i class="fa-solid fa-receipt"></i> View My Orders
            </a>
            <a href="index.php" class="btn-brutal-secondary">
                <i class="fa-solid fa-basket-shopping"></i> Continue Shopping
            </a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>