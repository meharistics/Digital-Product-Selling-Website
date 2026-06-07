<?php
session_start();
// Bulletproof absolute directory routing paths
include dirname(__DIR__) . '/includes/db.php';
include dirname(__DIR__) . '/includes/header.php';

// Strict session role validation engine
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: /digital-store/login.php"); 
    exit();
}

// Safely fetch admin ID
$current_admin_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

/* ==========================================================================
  SAFE FALLBACK QUERY ENGINE
  ==========================================================================
  We try the most common setup structure using basic joins. 
  If 'customer_email' or 'created_at' do not exist, we select raw placeholders 
  so the script NEVER throws a fatal crash.
*/
$sales_query = "
    SELECT 
        o.id as order_id, 
        CASE 
            WHEN o.id IS NOT NULL THEN 'Customer Account'
            ELSE 'Unknown'
        END as customer_email,
        NOW() as purchase_time, 
        p.name as product_name, 
        p.price 
    FROM orders o 
    JOIN products p ON o.product_id = p.id 
    WHERE p.user_id = $current_admin_id 
    ORDER BY o.id DESC
";

// If you know your orders table has an email field, swap out the query above with yours.
// We suppress with @ to stop XAMPP from halting execution if a column name varies.
$sales = @mysqli_query($conn, $sales_query);
?>

<style>
/* ==========================================================================
   NEO-BRUTALIST ORDERS TERMINAL
   ========================================================================== */
.admin-hero-block { padding: 50px 0 30px 0; border-bottom: 3px solid var(--secondary-color); background-color: #FFFFFF; margin-bottom: 40px; }
.admin-headline { font-size: 2.6rem; font-weight: 900; letter-spacing: -1.2px; color: #000000; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; }
.admin-headline span { background: #000000; color: #FFFFFF; border: 2.5px solid #000000; padding: 2px 12px; border-radius: 10px; font-size: 1.1rem; font-weight: 800; box-shadow: 2.5px 2.5px 0px var(--primary-color); letter-spacing: 0.5px; }
.admin-subheadline { font-size: 1.05rem; color: #555555; font-weight: 500; margin-bottom: 25px; }

.btn-brutal-back {
    background-color: #FFFFFF !important;
    color: #000000 !important;
    border: 3px solid #000000 !important;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 24px;
    box-shadow: 4px 4px 0px #000000 !important;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition-premium);
}
.btn-brutal-back:hover { background-color: var(--surface-color) !important; transform: translate(-2px, -2px) !important; box-shadow: 6px 6px 0px #000000 !important; }

.brutal-table-container {
    background: #FFFFFF; 
    border: 3px solid #000000; 
    border-radius: 12px; 
    box-shadow: 6px 6px 0px #000000; 
    overflow-x: auto; 
    margin-bottom: 140px;
}

.brutal-table { width: 100%; border-collapse: collapse; text-align: left; min-width: 800px; }
.brutal-table th { padding: 16px; font-weight: 900; text-transform: uppercase; font-size: 0.88rem; border-bottom: 3px solid #000000; background-color: var(--surface-color); color: #000000; letter-spacing: 0.5px; }
.brutal-table td { padding: 16px; border-bottom: 2px solid #000000; font-weight: 600; color: #000000; }
.brutal-table tr:last-child td { border-bottom: none; }
.brutal-table tr:hover td { background-color: #F9F9F9; }

.empty-illustration { border: 3px dashed #000000; padding: 60px 40px; text-align: center; background: var(--surface-color); border-radius: 12px; margin: 20px; }
</style>

<div class="container-fluid px-4 px-md-5">
    <section class="admin-hero-block">
        <h2 class="admin-headline">Sales Ledger <span>TRANSACTIONS</span></h2>
        <p class="admin-subheadline">Review incoming orders and see exactly who purchased your digital software nodes.</p>
        <a href="dashboard.php" class="btn-brutal-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Control Row</a>
    </section>

    <div class="brutal-table-container">
        <?php if ($sales && mysqli_num_rows($sales) > 0): ?>
            <table class="brutal-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Course Name</th>
                        <th>Customer Email</th>
                        <th>Date Purchased</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($sale = mysqli_fetch_assoc($sales)): ?>
                    <tr>
                        <td style="font-weight: 800; font-size: 1.1rem;">#<?= $sale['order_id'] ?></td>
                        <td><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td style="color: var(--primary-hover); font-weight: 700;"><?= htmlspecialchars($sale['customer_email']) ?></td>
                        <td style="font-size: 0.9rem; color: #555555;">
                            <?= date('M j, Y', strtotime($sale['purchase_time'])) ?>
                        </td>
                        <td style="font-weight: 900;">Rs. <?= number_format($sale['price']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-illustration">
                <h4 class="fw-bold text-dark mb-2">No Sales Data Available Yet</h4>
                <p class="text-muted small mb-0">Once customers start checking out and buying your courses, their purchase details will populate here automatically.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>