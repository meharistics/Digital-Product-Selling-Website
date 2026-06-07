<?php
session_start();
// Bulletproof absolute directory routing path frameworks
include dirname(__DIR__) . '/includes/db.php';
include dirname(__DIR__) . '/includes/header.php';

// 🔥 LOCKDOWN TRIGGER: Assert role validation AND verify the single-use access pass is active
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' || !isset($_SESSION['admin_access_pass'])) {
    session_unset();
    session_destroy();
    header("Location: /digital-store/login.php"); exit();
}

$message = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = "";

    // Option 1 - Image URL Input Stream
    if(!empty($_POST['image_url'])) {
        $image = mysqli_real_escape_string($conn, $_POST['image_url']);
    }

    // Option 2 - Binary Machine Upload Vector
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $filename = time() . "_" . basename($_FILES['image_file']['name']);
        $uploadPath = dirname(__DIR__) . "/assets/uploads/" . $filename;
        
        // Guarantee directory node architecture structure exists safely
        if (!is_dir(dirname(__DIR__) . "/assets/uploads/")) {
            mkdir(dirname(__DIR__) . "/assets/uploads/", 0777, true);
        }
        
        if(move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadPath)) {
            $image = "/digital-store/assets/uploads/" . $filename;
        }
    }

    // Capture active admin ID from session to preserve data isolation
    $current_admin_id = intval($_SESSION['user_id']);

    // Deploy product node complete schema directly into the database catalog index
    $query = "INSERT INTO products (name, description, price, image, user_id, category) 
              VALUES ('$name', '$desc', '$price', '$image', $current_admin_id, '$category')";
              
    if(mysqli_query($conn, $query)) {
        // High-contrast Brutalist success notification card
        $message = "
        <div class='brutal-status-box brutal-status-success animate-slide-up'>
            <div class='status-icon-shield'>✓</div>
            <div>
                <strong>Success Pipeline</strong>
                <p>Product listing node was mapped and deployed into your personal workspace database cleanly.</p>
            </div>
        </div>";
    } else {
        $message = "
        <div class='brutal-status-box brutal-status-danger animate-slide-up'>
            <div class='status-icon-shield' style='background-color: #E63939;'>⚡</div>
            <div>
                <strong>Deployment Interrupted</strong>
                <p>System error: " . htmlspecialchars(mysqli_error($conn)) . "</p>
            </div>
        </div>";
    }
}
?>

<style>
/* ==========================================================================
   MINIMALISTIC NEO-BRUTALIST MANAGEMENT ENGINE HOOKS
   ========================================================================== */
.product-root-container {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 20px 180px 20px; /* Massive padding bounds drop the dark footer baseline downwards */
}

.brutal-form-card {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 20px;
    box-shadow: 6px 6px 0px #000000;
    width: 100%;
    max-width: 580px;
    padding: 40px 35px;
    transition: var(--transition-premium);
}

.brutal-card-tag {
    background-color: var(--secondary-color);
    color: var(--primary-color);
    font-weight: 800;
    font-size: 0.72rem;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 6px;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 14px;
}

.brutal-form-title {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -1px;
    color: #000000;
    margin-bottom: 6px;
}

.brutal-form-sub {
    font-size: 0.88rem;
    color: #555555;
    font-weight: 600;
    margin-bottom: 30px;
}

/* Brutalist Form Input Styling Groups */
.brutal-field-group {
    margin-bottom: 22px;
}

.brutal-field-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #000000;
    margin-bottom: 8px;
}

.brutal-input-control {
    width: 100%;
    padding: 12px 16px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #000000;
    background-color: var(--surface-color);
    border: 2.5px solid #000000;
    border-radius: 12px;
    outline: none;
    transition: var(--transition-premium);
}
.brutal-input-control:focus {
    background-color: #FFFFFF;
    box-shadow: 3px 3px 0px #000000;
    transform: translate(-1px, -1px);
}

.brutal-divider-line {
    border: none;
    border-top: 3px solid #000000;
    margin: 35px 0 25px 0;
    opacity: 1;
}

.brutal-section-heading {
    font-size: 0.95rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #000000;
    margin-bottom: 18px;
}

/* Strict YouTube Style Thumbnail Preview Frame Box */
.yt-preview-box-frame {
    width: 100%;
    aspect-ratio: 16 / 9; /* Hard-locks item layout boundaries to copy index preview cards */
    border: 3px solid #000000;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 4px 4px 0px #000000;
    background-color: var(--surface-color);
    margin-bottom: 25px;
    position: relative;
}

.yt-preview-img-element {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Brutalist Action Status Flash Cards */
.brutal-status-box {
    border: 2.5px solid #000000;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 24px;
    display: flex;
    gap: 12px;
    box-shadow: 3px 3px 0px #000000;
    text-align: left;
}
.brutal-status-success { background-color: #F0FFF4; }
.brutal-status-danger { background-color: #FFF5F5; }

.status-icon-shield {
    background-color: #00C853;
    border: 2px solid #000000;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 0.9rem;
    flex-shrink: 0;
    color: #FFFFFF;
}

.brutal-status-box strong {
    display: block;
    font-size: 0.85rem;
    font-weight: 800;
    color: #000000;
    margin-bottom: 2px;
}

.brutal-status-box p {
    font-size: 0.78rem;
    color: #333333;
    font-weight: 600;
    margin: 0;
    line-height: 1.3;
}

/* Control Tray Interaction Alignments */
.brutal-action-tray {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-brutal-submit {
    flex-grow: 1;
    background-color: var(--primary-color) !important;
    color: #000000 !important;
    border: 3px solid #000000 !important;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px;
    box-shadow: 4px 4px 0px #000000 !important;
    cursor: pointer;
    transition: var(--transition-premium);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}
.btn-brutal-submit:hover {
    background-color: var(--primary-hover) !important;
    transform: translate(-2px, -2px) !important;
    box-shadow: 6px 6px 0px #000000 !important;
}

.btn-brutal-back-cancel {
    background-color: #FFFFFF !important;
    color: #000000 !important;
    border: 3px solid #000000 !important;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 24px;
    box-shadow: 4px 4px 0px #000000 !important;
    text-decoration: none;
    transition: var(--transition-premium);
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-brutal-back-cancel:hover {
    background-color: var(--surface-color) !important;
    transform: translate(-2px, -2px) !important;
    box-shadow: 6px 6px 0px #000000 !important;
}
</style>

<div class="product-root-container">
    <div class="brutal-form-card">
        
        <div class="text-center">
            <span class="brutal-card-tag">CATALOG INVENTORY ARCHITECTURE</span>
            <h2 class="brutal-form-title">Add New Product</h2>
            <p class="brutal-form-sub">Deploy a fresh software node module package directly into your active workspace index.</p>
        </div>

        <?= $message ?>

        <form method="POST" enctype="multipart/form-data" id="brutalAddProductForm">
            
            <div class="brutal-field-group">
                <label class="brutal-field-label">Product Name</label>
                <input type="text" name="name" class="brutal-input-control" placeholder="e.g. Interactive Python Boilerplate Pro" required>
            </div>

            <div class="brutal-field-group">
                <label class="brutal-field-label">Description</label>
                <textarea name="description" class="brutal-input-control" rows="3" style="resize:none;" placeholder="Detail your software component features, plugins, and installation methods..." required></textarea>
            </div>

            <div class="brutal-field-group">
                <label class="brutal-field-label">Price (Rs.)</label>
                <input type="number" name="price" class="brutal-input-control" step="0.01" placeholder="e.g. 1500" required>
            </div>

            <!-- DYNAMIC ALLOCATION ENGINE: Neo-Brutalist Category Selector drop-down frame -->
            <div class="brutal-field-group">
                <label class="brutal-field-label">Marketplace Category Mapping</label>
                <select name="category" class="brutal-input-control" style="cursor: pointer; font-weight:700;" required>
                    <option value="software" selected>Software</option>
                    <option value="drawing">Drawing & Art</option>
                    <option value="3d">3D Assets</option>
                    <option value="design">Design Files</option>
                    <option value="music">Music & Audio</option>
                    <option value="education">Education & Courses</option>
                    <option value="business">Business & Data</option>
                </select>
            </div>

            <hr class="brutal-divider-line">
            <h4 class="brutal-section-heading">🖼️ Product Asset Image (Choose One)</h4>

            <div class="brutal-field-group">
                <label class="brutal-field-label">Option 1 — Paste Remote Image URL</label>
                <input type="text" name="image_url" id="brutalUrlInput" class="brutal-input-control" placeholder="https://images.unsplash.com/photo-code-snippet.jpg">
            </div>

            <div class="brutal-field-group">
                <label class="brutal-field-label">Option 2 — Stream Upload from Computer</label>
                <input type="file" name="image_file" id="brutalFileInput" class="brutal-input-control" accept="image/*" style="padding-top:10px; cursor: pointer;">
            </div>

            <div id="preview-box-container" style="display:none; text-align:left;">
                <label class="brutal-field-label">Live Grid Card Thumbnail Preview</label>
                <div class="yt-preview-box-frame">
                    <img id="preview-img-target" class="yt-preview-img-element" src="" alt="Live Catalog Node Source Preview">
                </div>
            </div>

            <div class="brutal-action-tray">
                <a href="dashboard.php" class="btn-brutal-back-cancel"><i class="fa-solid fa-arrow-left-long me-1"></i> Back</a>
                <button type="submit" class="btn-brutal-submit">Deploy Product Node <i class="fa-solid fa-circle-plus"></i></button>
            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const urlInput = document.getElementById('brutalUrlInput');
    const fileInput = document.getElementById('brutalFileInput');
    const previewContainer = document.getElementById('preview-box-container');
    const previewImg = document.getElementById('preview-img-target');
    const addProductForm = document.getElementById('brutalAddProductForm');

    // Parse remote imagery text feeds safely
    if(urlInput) {
        urlInput.addEventListener('input', function() {
            const urlVal = this.value.trim();
            if(urlVal !== '') {
                previewImg.src = urlVal;
                previewContainer.style.display = 'block';
                if(fileInput) fileInput.value = ''; // Clean counter option form feeds
            } else {
                previewContainer.style.display = 'none';
            }
        });
    }

    // Capture native machine binary streaming feeds via FileReader vectors
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            const uploadedFile = this.files[0];
            if(uploadedFile) {
                const streamReader = new FileReader();
                streamReader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewContainer.style.display = 'block';
                    if(urlInput) urlInput.value = ''; // Clean remote text address lines
                }
                streamReader.readAsDataURL(uploadedFile);
            }
        });
    }

    // Freeze interface operations upon active submission routines to protect active MySQL payloads
    if(addProductForm) {
        addProductForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('[type="submit"]');
            if(submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.style.opacity = '0.8';
                submitBtn.innerHTML = "Processing Deployment Vector...";
            }
        });
    }
});
</script>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>