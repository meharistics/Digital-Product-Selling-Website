<?php
session_start();
// Bulletproof absolute directory routing paths
include dirname(__DIR__) . '/includes/db.php';
include dirname(__DIR__) . '/includes/header.php';

// 🔥 LOCKDOWN TRIGGER: Assert role validation AND verify the single-use access pass is active
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' || !isset($_SESSION['admin_access_pass'])) {
    session_unset();
    session_destroy();
    header("Location: /digital-store/login.php"); 
    exit();
}

// Isolate products dynamically by the active logged-in admin's ID
$current_admin_id = intval($_SESSION['user_id']);
$products = mysqli_query($conn, "SELECT * FROM products WHERE user_id = $current_admin_id");
?>

<style>
/* ==========================================================================
   PREMIUM NEO-BRUTALIST ADMIN CONTROL TERMINAL STYLES
   ========================================================================== */
.admin-hero-block { padding: 50px 0 30px 0; border-bottom: 3px solid var(--secondary-color); background-color: #FFFFFF; margin-bottom: 40px; }
.admin-headline { font-size: 2.6rem; font-weight: 900; letter-spacing: -1.2px; color: #000000; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; }
.admin-headline span { background: var(--primary-color); border: 2.5px solid #000000; padding: 2px 12px; border-radius: 10px; font-size: 1.1rem; font-weight: 800; box-shadow: 2.5px 2.5px 0px #000000; letter-spacing: 0.5px; }
.admin-subheadline { font-size: 1.05rem; color: #555555; font-weight: 500; margin-bottom: 25px; }

.btn-brutal-add-node {
    background-color: var(--primary-color) !important;
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
.btn-brutal-add-node:hover { background-color: var(--primary-hover) !important; transform: translate(-2px, -2px) !important; box-shadow: 6px 6px 0px #000000 !important; }

.admin-grid-workspace { padding-bottom: 140px; }
.yt-admin-card { display: flex; flex-direction: column; height: 100%; background: transparent; }

.yt-thumbnail-frame { position: relative; width: 100%; aspect-ratio: 16 / 9; border: 3px solid #000000; border-radius: 14px; overflow: hidden; box-shadow: 4px 4px 0px #000000; background-color: var(--surface-color); transition: var(--transition-premium); }
.yt-admin-card:hover .yt-thumbnail-frame { transform: translateY(-3px); box-shadow: 6px 6px 0px #000000; }
.yt-thumbnail-img { width: 100%; height: 100%; object-fit: cover; }
.yt-fallback-placeholder { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; background: linear-gradient(135deg, #764ba2 0%, #2575fc 100%); color: #ffffff; font-weight: bold; }
.yt-id-badge { position: absolute; bottom: 8px; right: 8px; background-color: rgba(0, 0, 0, 0.85); color: #FFFFFF; font-weight: 700; font-size: 0.68rem; padding: 3px 6px; border-radius: 4px; }

.yt-meta-row { margin-top: 12px; display: flex; flex-grow: 1; flex-direction: column; }
.yt-title-line { font-size: 0.95rem; font-weight: 800; line-height: 1.3; margin-bottom: 4px; color: #000000; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.6em; }
.yt-description-block { font-size: 0.82rem; color: #4A5568; line-height: 1.4; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 4.2em; }
.yt-pricing-line { font-size: 0.95rem; font-weight: 800; color: #000000; margin-bottom: 15px; }

.yt-admin-action-tray { margin-top: auto; display: flex; gap: 8px; }

.btn-yt-edit {
    flex-grow: 1;
    background-color: #FFFFFF !important;
    color: #000000 !important;
    border: 3px solid #000000 !important;
    font-weight: 800;
    font-size: 0.8rem;
    padding: 10px 14px;
    border-radius: 8px;
    text-transform: uppercase;
    text-align: center;
    text-decoration: none !important;
    box-shadow: 2.5px 2.5px 0px #000000 !important;
    transition: var(--transition-premium);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-yt-edit:hover { background-color: var(--secondary-color) !important; transform: translate(-1px, -1px) !important; box-shadow: 4px 4px 0px #000000 !important; }

.btn-yt-delete {
    flex-grow: 1;
    background-color: var(--danger-color) !important;
    color: #000000 !important;
    border: 3px solid #000000 !important;
    font-weight: 800;
    font-size: 0.8rem;
    padding: 10px 14px;
    border-radius: 8px;
    text-transform: uppercase;
    text-align: center;
    text-decoration: none !important;
    box-shadow: 2.5px 2.5px 0px #000000 !important;
    transition: var(--transition-premium);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-yt-delete:hover { background-color: #E63939 !important; color: #FFFFFF !important; transform: translate(-1px, -1px) !important; box-shadow: 4px 4px 0px #000000 !important; }

.empty-illustration { border: 3px dashed #000000; padding: 50px; text-align: center; background: var(--surface-color); border-radius: 16px; }
</style>

<div class="container-fluid px-4 px-md-5">
    <section class="admin-hero-block">
        <h2 class="admin-headline">Admin Dashboard <span>CONTROL ROW</span></h2>
        <p class="admin-subheadline">Oversee records, clean system listings, and map product nodes inside your isolated live workspace index.</p>
        
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="add_product.php" class="btn-brutal-add-node">
                <i class="fa-solid fa-square-plus"></i> + Add New Product
            </a>
            <a href="orders.php" class="btn-brutal-add-node">
                <i class="fa-solid fa-users"></i> View Sales & Buyers
            </a>
        </div>
    </section>

    <section class="admin-grid-workspace">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php 
            if (mysqli_num_rows($products) > 0): 
                while($p = mysqli_fetch_assoc($products)): 
                    $safe_name = htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');
                    $safe_desc = htmlspecialchars($p['description'], ENT_QUOTES, 'UTF-8');
                    $safe_img  = htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8');
            ?>
                <div class="col">
                    <div class="yt-admin-card">
                        <div class="yt-thumbnail-frame">
                            <?php if(!empty($p['image'])): ?>
                                <img src="<?= $safe_img ?>" class="yt-thumbnail-img" alt="" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none');">
                            <?php endif; ?>
                            <div class="yt-fallback-placeholder <?= !empty($p['image']) ? 'd-none' : '' ?>">DATA</div>
                            <span class="yt-id-badge">ID: <?= $p['id'] ?></span>
                        </div>

                        <div class="yt-meta-row">
                            <h5 class="yt-title-line" title="<?= $safe_name ?>"><?= $safe_name ?></h5>
                            <p class="yt-description-block"><?= !empty($p['description']) ? $safe_desc : 'No summary description has been written for this production module listing.' ?></p>
                            <div class="yt-pricing-line"><strong>Rs. <?= number_format($p['price']) ?></strong></div>
                            
                            <div class="yt-admin-action-tray">
                                <a href="update_product.php?id=<?= $p['id'] ?>" class="btn-yt-edit"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a href="delete_product.php?id=<?= $p['id'] ?>" class="btn-yt-delete" onclick="return confirm('Security Warning: Are you completely certain you want to purge this asset listing node from the database structure?');"><i class="fa-solid fa-trash-can"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile; 
            else:
            ?>
                <div class="col-12">
                    <div class="empty-illustration">
                        <h4 class="fw-bold text-dark mb-1">No Software Listed in Marketplace</h4>
                        <p class="text-muted small">Initialize operations by clicking the Add Product module above.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<hr class="brutal-divider-line" style="margin: 60px 0;">

<section class="admin-hero-block" style="padding: 10px 0 20px 0; border: none; margin-bottom: 20px;">
    <h2 class="admin-headline">Sales Ledger <span>TRANSACTIONS</span></h2>
    <p class="admin-subheadline">Track who purchased your specific digital course nodes.</p>
</section>

<div class="brutal-table-container" style="background: #FFFFFF; border: 3px solid #000000; border-radius: 12px; box-shadow: 4px 4px 0px #000000; overflow-x: auto; padding: 20px; margin-bottom: 80px;">
    <?php
    /* ISOLATED REVENUE LEDGER ENGINE 
       This handles setups that use basic links or direct customer text logs without breaking.
       The WHERE clause isolates orders strictly matching the active logged-in admin's IDs.
    */
    $sales_query = "
        SELECT 
            o.id as order_id, 
            p.name as product_name, 
            p.price 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE p.user_id = $current_admin_id 
        ORDER BY o.id DESC
    ";
    
    $sales = @mysqli_query($conn, $sales_query);
    
    if ($sales && mysqli_num_rows($sales) > 0):
    ?>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 3px solid #000000;">
                <th style="padding: 12px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem;">Order ID</th>
                <th style="padding: 12px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem;">Course Name</th>
                <th style="padding: 12px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem;">Customer Info</th>
                <th style="padding: 12px; font-weight: 800; text-transform: uppercase; font-size: 0.85rem;">Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php while($sale = mysqli_fetch_assoc($sales)): ?>
            <tr style="border-bottom: 2px solid #EEEEEE;">
                <td style="padding: 12px; font-weight: 700;">#<?= $sale['order_id'] ?></td>
                <td style="padding: 12px; font-weight: 600;"><?= htmlspecialchars($sale['product_name']) ?></td>
                <td style="padding: 12px; font-weight: 600; color: #FF66DC;">Protected Purchase Profile</td>
                <td style="padding: 12px; font-weight: 800;">Rs. <?= number_format($sale['price']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px;">
            <h5 style="font-weight: 800;">No sales data available yet.</h5>
            <p style="color: #666666; font-size: 0.9rem;">Once customers start buying your courses, their details will populate here.</p>
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>