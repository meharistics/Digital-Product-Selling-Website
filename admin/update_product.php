<?php
session_start();
// Bulletproof absolute directory routing path frameworks
include dirname(__DIR__) . '/includes/db.php';
include dirname(__DIR__) . '/includes/header.php';

// 🔥 LOCKDOWN TRIGGER: Assert role validation AND verify the single-use access pass is active
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' || !isset($_SESSION['admin_access_pass'])) {
    session_unset();
    session_destroy();
    header("Location: /digital-store/login.php"); 
    exit();
}

$message = "";
$current_admin_id = intval($_SESSION['user_id']);

if (!isset($_GET['id'])) { header("Location: dashboard.php"); exit(); }
$product_id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id AND user_id = $current_admin_id");
$product = mysqli_fetch_assoc($result);

if (!$product) { header("Location: dashboard.php"); exit(); }

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = $product['image']; 

    if(!empty($_POST['image_url'])) { $image = mysqli_real_escape_string($conn, $_POST['image_url']); }

    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $filename = time() . "_" . basename($_FILES['image_file']['name']);
        $uploadPath = dirname(__DIR__) . "/assets/uploads/" . $filename;
        if (!is_dir(dirname(__DIR__) . "/assets/uploads/")) { mkdir(dirname(__DIR__) . "/assets/uploads/", 0777, true); }
        if(move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadPath)) { $image = "/digital-store/assets/uploads/" . $filename; }
    }

    $update_query = "UPDATE products SET name='$name', description='$desc', price='$price', image='$image', category='$category' WHERE id = $product_id AND user_id = $current_admin_id";
              
    if(mysqli_query($conn, $update_query)) {
        $product['name'] = $name; $product['description'] = $desc; $product['price'] = $price; $product['image'] = $image; $product['category'] = $category;
        $message = "
        <div class='brutal-status-box brutal-status-success'>
            <div class='status-icon-shield'>✓</div>
            <div><strong>Update Manifest Compiled</strong><p>Course asset configurations were saved successfully.</p></div>
        </div>";
    }
}
?>

<style>
.product-root-container { min-height: 90vh; display: flex; align-items: center; justify-content: center; padding: 120px 20px 180px 20px; }
.brutal-form-card { background-color: #FFFFFF; border: 3px solid #000000; border-radius: 20px; box-shadow: 6px 6px 0px #000000; width: 100%; max-width: 580px; padding: 40px 35px; }
.brutal-card-tag { background-color: var(--secondary-color); color: var(--primary-color); font-weight: 800; font-size: 0.72rem; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; display: inline-block; margin-bottom: 14px; }
.brutal-form-title { font-size: 2rem; font-weight: 900; letter-spacing: -1px; color: #000000; margin-bottom: 6px; }
.brutal-form-sub { font-size: 0.88rem; color: #555555; font-weight: 600; margin-bottom: 30px; }
.brutal-field-group { margin-bottom: 22px; }
.brutal-field-label { display: block; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; color: #000000; margin-bottom: 8px; }
.brutal-input-control { width: 100%; padding: 12px 16px; font-size: 0.95rem; font-weight: 600; color: #000000; background-color: var(--surface-color); border: 2.5px solid #000000; border-radius: 12px; outline: none; }
.brutal-input-control:focus { background-color: #FFFFFF; box-shadow: 3px 3px 0px #000000; transform: translate(-1px, -1px); }
.brutal-divider-line { border: none; border-top: 3px solid #000000; margin: 35px 0 25px 0; opacity: 1; }
.brutal-section-heading { font-size: 0.95rem; font-weight: 800; text-transform: uppercase; color: #000000; margin-bottom: 18px; }
.yt-preview-box-frame { width: 100%; aspect-ratio: 16 / 9; border: 3px solid #000000; border-radius: 14px; overflow: hidden; box-shadow: 4px 4px 0px #000000; background-color: var(--surface-color); margin-bottom: 25px; }
.yt-preview-img-element { width: 100%; height: 100%; object-fit: cover; }
.brutal-status-box { border: 2.5px solid #000000; border-radius: 12px; padding: 14px; margin-bottom: 24px; display: flex; gap: 12px; box-shadow: 3px 3px 0px #000000; }
.brutal-status-success { background-color: #F0FFF4; }
.status-icon-shield { background-color: #00C853; border: 2px solid #000000; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #FFFFFF; }
.brutal-status-box strong { display: block; font-size: 0.85rem; font-weight: 800; color: #000000; }
.brutal-status-box p { font-size: 0.78rem; color: #333333; margin: 0; }
.brutal-action-tray { display: flex; gap: 10px; margin-top: 15px; }

.btn-brutal-submit { flex-grow: 1; background-color: var(--primary-color) !important; color: #000000 !important; border: 3px solid #000000 !important; border-radius: 12px; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; padding: 14px; box-shadow: 4px 4px 0px #000000 !important; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-brutal-submit:hover { background-color: var(--primary-hover) !important; transform: translate(-2px, -2px) !important; box-shadow: 6px 6px 0px #000000 !important; }
.btn-brutal-back-cancel { background-color: #FFFFFF !important; color: #000000 !important; border: 3px solid #000000 !important; border-radius: 12px; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; padding: 14px 24px; box-shadow: 4px 4px 0px #000000 !important; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
.btn-brutal-back-cancel:hover { background-color: var(--surface-color) !important; transform: translate(-2px, -2px) !important; box-shadow: 6px 6px 0px #000000 !important; }
</style>

<div class="product-root-container">
    <div class="brutal-form-card">
        <div class="text-center">
            <span class="brutal-card-tag">CONFIGURATION TERMINAL</span>
            <h2 class="brutal-form-title">Edit Product Details</h2>
            <p class="brutal-form-sub">Adjust metadata entries for your active deployment module listings.</p>
        </div>

        <?= $message ?>

        <form method="POST" enctype="multipart/form-data" id="brutalUpdateProductForm">
            <div class="brutal-field-group">
                <label class="brutal-field-label">Product Name</label>
                <input type="text" name="name" class="brutal-input-control" value="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="brutal-field-group">
                <label class="brutal-field-label">Description</label>
                <textarea name="description" class="brutal-input-control" rows="3" style="resize:none;" required><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="brutal-field-group">
                <label class="brutal-field-label">Price (Rs.)</label>
                <input type="number" name="price" class="brutal-input-control" step="0.01" value="<?= floatval($product['price']) ?>" required>
            </div>
            <div class="brutal-field-group">
                <label class="brutal-field-label">Marketplace Category Mapping</label>
                <select name="category" class="brutal-input-control" style="cursor: pointer; font-weight:700;" required>
                    <?php 
                    $categories = ['software' => 'Software', 'drawing' => 'Drawing & Art', '3d' => '3D Assets', 'design' => 'Design Files', 'music' => 'Music & Audio', 'education' => 'Education & Courses', 'business' => 'Business & Data'];
                    foreach($categories as $value => $label):
                        $selected = ($product['category'] === $value) ? 'selected' : '';
                    ?>
                        <option value="<?= $value ?>" <?= $selected ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr class="brutal-divider-line">
            <h4 class="brutal-section-heading">🖼️ Modify Product Asset Image</h4>
            <div id="preview-box-container" style="text-align:left;">
                <label class="brutal-field-label">Current / Preview Thumbnail</label>
                <div class="yt-preview-box-frame"><img id="preview-img-target" class="yt-preview-img-element" src="<?= !empty($product['image']) ? htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') : '' ?>" alt="Source Preview"></div>
            </div>
            <div class="brutal-field-group">
                <label class="brutal-field-label">Option 1 — Supply Replacement Image URL</label>
                <input type="text" name="image_url" id="brutalUrlInput" class="brutal-input-control" placeholder="Leave blank to preserve current thumbnail">
            </div>
            <div class="brutal-field-group">
                <label class="brutal-field-label">Option 2 — Stream Upload New File Replacement</label>
                <input type="file" name="image_file" id="brutalFileInput" class="brutal-input-control" accept="image/*" style="padding-top:10px; cursor: pointer;">
            </div>

            <div class="brutal-action-tray">
                <a href="dashboard.php" class="btn-brutal-back-cancel"><i class="fa-solid fa-arrow-left-long me-1"></i> Dashboard</a>
                <button type="submit" class="btn-brutal-submit">Apply Modifications <i class="fa-solid fa-square-check"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const urlInput = document.getElementById('brutalUrlInput');
    const fileInput = document.getElementById('brutalFileInput');
    const previewImg = document.getElementById('preview-img-target');
    const updateProductForm = document.getElementById('brutalUpdateProductForm');
    const originalImageSrc = previewImg.src;

    if(urlInput) {
        urlInput.addEventListener('input', function() {
            const urlVal = this.value.trim();
            if(urlVal !== '') { previewImg.src = urlVal; if(fileInput) fileInput.value = ''; } 
            else { previewImg.src = originalImageSrc; }
        });
    }
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            const uploadedFile = this.files[0];
            if(uploadedFile) {
                const streamReader = new FileReader();
                streamReader.onload = function(event) { previewImg.src = event.target.result; if(urlInput) urlInput.value = ''; }
                streamReader.readAsDataURL(uploadedFile);
            } else { previewImg.src = originalImageSrc; }
        });
    }
    if(updateProductForm) {
        updateProductForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('[type="submit"]');
            if(submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = "Processing..."; }
        });
    }
});
</script>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>