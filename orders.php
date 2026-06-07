<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Strict session validation gateway [source: user file context]
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit();
}

$user_id = $_SESSION['user_id'];

// Extract dynamic purchase array records from database [source: user file context]
$orders = mysqli_query($conn, "SELECT orders.id, products.name, products.price, orders.order_date, orders.status 
                                FROM orders 
                                JOIN products ON orders.product_id = products.id 
                                WHERE orders.user_id=$user_id 
                                ORDER BY orders.order_date DESC");
$order_count = mysqli_num_rows($orders);
?>

<style>
/* ==========================================================================
   NEO-BRUTALIST ORDER STATUS TRANSACTION TRACKER THEME HOOKS
   ========================================================================== */
.orders-root-wrapper {
    margin-top: 30px;
    margin-bottom: 160px; /* Strong vertical space drives the dark Gumroad footer downward */
}

.orders-hero-heading {
    font-size: 2.5rem;
    font-weight: 900;
    letter-spacing: -1.2px;
    color: #000000;
    margin-bottom: 8px;
}
.orders-hero-heading span {
    background: var(--primary-color);
    border: 2px solid #000000;
    padding: 0px 10px;
    border-radius: 8px;
    box-shadow: 2.5px 2.5px 0px #000000;
    font-size: 1.2rem;
    font-weight: 800;
    vertical-align: middle;
}

.orders-hero-sub {
    font-size: 1rem;
    color: #555555;
    font-weight: 600;
    margin-bottom: 40px;
}

/* Minimalist Horizontal Invoice Card Node Layout */
.brutal-order-card {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 16px;
    padding: 22px 26px;
    margin-bottom: 20px;
    box-shadow: 5px 5px 0px #000000;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transition-premium);
}
.brutal-order-card:hover {
    transform: translateY(-2px);
    box-shadow: 7px 7px 0px #000000;
}

/* Left Indicator Segment Block */
.order-id-identity-frame {
    display: flex;
    align-items: center;
    gap: 16px;
}
.order-receipt-icon-box {
    width: 46px;
    height: 46px;
    background-color: var(--surface-color);
    border: 2px solid #000000;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: bold;
    flex-shrink: 0;
}

.order-meta-info {
    display: flex;
    flex-direction: column;
}
.order-module-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #000000;
    margin-bottom: 3px;
    line-height: 1.2;
}
.order-timestamp-date {
    font-size: 0.82rem;
    color: #666666;
    font-weight: 600;
}

/* Right Metrics Tray Alignment Panel */
.order-metrics-tray {
    display: flex;
    align-items: center;
    gap: 30px;
}
.order-cost-tag {
    font-size: 1.15rem;
    font-weight: 900;
    color: #000000;
}

/* High-Contrast Dynamic Platform Status Badges */
.badge-brutal-status {
    border: 2px solid #000000;
    font-weight: 800;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 6px 12px;
    border-radius: 6px;
    display: inline-block;
    box-shadow: 2px 2px 0px #000000;
}

/* Default dynamic status layout definitions */
.status-node-completed, .status-node-success { background-color: #E6FFFA; color: #00A389; }
.status-node-pending { background-color: #FEFCBF; color: #B7791F; }
.status-node-processing { background-color: #EBF8FF; color: #2B6CB0; }

.empty-orders-illustration {
    border: 3px dashed #000000;
    padding: 60px 40px;
    text-align: center;
    background-color: var(--surface-color);
    border-radius: 20px;
    max-width: 650px;
    margin: 0 auto;
}

/* Responsive collapse limits for mobile view layouts */
@media (max-width: 767px) {
    .brutal-order-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 18px;
        padding: 20px;
    }
    .order-metrics-tray {
        width: 100%;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 1.5px solid var(--soft-border);
    }
}
</style>

<div class="orders-root-wrapper">
    <!-- Main Header Workspace Segment -->
    <h2 class="orders-hero-heading">My Orders <span>HISTORY NODE</span></h2>
    <p class="orders-hero-sub">Inspect past secure downloads, verification logs, and license purchase receipt logs.</p>

    <?php if($order_count > 0): ?>
        <div class="animate-slide-up">
            <?php 
            while($order = mysqli_fetch_assoc($orders)): 
                
                $safe_name   = htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8');
                $raw_status  = strtolower(trim($order['status']));
                
                // Formulate professional readable time dates
                $clean_date  = date("F d, Y", strtotime($order['order_date']));
                $clean_time  = date("h:i A", strtotime($order['order_date']));
            ?>
                <!-- Individual Neo-Brutalist Transaction Node Card -->
                <div class="brutal-order-card">
                    
                    <!-- Left Section: Identification Elements Wrapper -->
                    <div class="order-id-identity-frame">
                        <div class="order-receipt-icon-box" title="Receipt Node Matrix">
                            #<?= $order['id'] ?>
                        </div>
                        <div class="order-meta-info">
                            <h5 class="order-module-title"><?= $safe_name ?></h5>
                            <span class="order-timestamp-date">
                                <i class="fa-regular fa-calendar-check me-1"></i> <?= $clean_date ?> at <?= $clean_time ?>
                            </span>
                        </div>
                    </div>

                    <!-- Right Section: Price Metric Parameters & Status Badges Array -->
                    <div class="order-metrics-tray">
                        <div class="order-cost-tag">
                            Rs. <?= number_format($order['price']) ?>
                        </div>
                        <div>
                            <!-- Dynamic class injected seamlessly to assign status coloration tokens -->
                            <span class="badge-brutal-status status-node-<?= $raw_status ?>">
                                <i class="fa-solid fa-circle-nodes me-1" style="font-size:0.65rem;"></i> <?= htmlspecialchars($order['status'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <!-- Alternative View Profile for Clear Empty Log States -->
        <div class="empty-orders-illustration animate-slide-up">
            <div style="font-size: 3.5rem; margin-bottom: 15px;">📦</div>
            <h4 class="fw-bold mb-2">No Order Records Found</h4>
            <p class="text-muted small mb-4" style="max-width: 440px; margin: 0 auto;">
                You haven't completed any transaction flows or acquired product deployment licenses on this account node yet.
            </p>
            <a href="index.php" class="btn-brutal-primary" style="text-decoration:none;">
                <i class="fa-solid fa-bag-shopping me-1"></i> Explore Product Marketplace
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>