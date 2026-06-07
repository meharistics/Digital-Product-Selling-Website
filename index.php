<?php
session_start();
// Bulletproof absolute directory routing path frameworks
include 'includes/db.php';
include 'includes/header.php';

// Fetch all marketplace product items from the MySQL database
$result = mysqli_query($conn, "SELECT * FROM products");

// Build primary array mapping for products
$products_array = [];
if (mysqli_num_rows($result) > 0) {
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $products_array[] = $row;
    }
}

// Create an isolated secondary array specifically for the lower catalog grid and shuffle it randomly
$market_products = $products_array;
shuffle($market_products);

// Master layout validation category definitions
$mock_categories = ['drawing', '3d', 'design', 'music', 'software', 'education', 'business'];
?>

<style>
/* ==========================================================================
   PREMIUM ADMINISTRATIVE QUICK-LINK SHORTCUT BAR
   ========================================================================= */
.admin-shortcut-banner {
    background-color: #000000;
    color: #FFFFFF;
    padding: 12px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 3px solid #000000;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 4px 4px 0px var(--primary-color);
}
.admin-mode-indicator {
    font-size: 0.88rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.admin-mode-indicator span {
    background-color: var(--primary-color);
    color: #000000;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
}
.btn-brutal-dashboard-jump {
    background-color: var(--secondary-color) !important;
    color: #aeb2ca !important; /* FIXED: Swapped to crisp black text for maximum high-contrast layout readability */
    border: 2px solid #FFFFFF !important;
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    text-decoration: none !important;
    transition: var(--transition-premium);
}
.btn-brutal-dashboard-jump:hover {
    background-color: #FFFFFF !important; /* FIXED: Extended typo from #FFFF to complete solid white hex channel code */
    color: #000000 !important;
    transform: scale(1.03);
}

/* ==========================================================================
   NEO-BRUTALIST FULL-WIDTH DISCOVERY CANVAS
   ========================================================================= */
.index-main-workspace {
    margin-top: 30px;
    padding-bottom: 140px; 
}

/* ==========================================================================
   GUMROAD HORIZONTAL FEATURED TRACK ENGINE 
   ========================================================================= */
.featured-header-tray { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.featured-heading-text { font-size: 1.15rem; font-weight: 700; color: #000000; letter-spacing: -0.3px; }

.featured-pagination-mock { font-size: 0.85rem; font-weight: 700; color: #000000; letter-spacing: 1px; display: flex; align-items: center; gap: 12px; }
.featured-nav-arrow { cursor: pointer; transition: transform 0.1s ease, opacity 0.2s ease; padding: 4px; }
.featured-nav-arrow:hover { transform: scale(1.15); }
.featured-nav-arrow.disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }

.featured-scroll-track { display: flex; gap: 20px; overflow-x: auto; white-space: nowrap; padding: 4px 4px 15px 4px; scroll-behavior: smooth; scrollbar-width: none; }
.featured-scroll-track::-webkit-scrollbar { display: none; }

.gr-featured-horizontal-card { flex: 0 0 calc(33.333% - 14px); min-width: 380px; background-color: #FFFFFF; border: 3px solid #000000; border-radius: 12px; box-shadow: 4px 4px 0px #000000; display: flex; flex-direction: row; overflow: hidden; text-decoration: none; color: inherit; transition: var(--transition-premium); }
.gr-featured-horizontal-card:hover { transform: translateY(-2px); box-shadow: 6px 6px 0px #000000; }

.horizontal-card-left-img-box { width: 45%; aspect-ratio: 1 / 1; border-right: 3px solid #000000; background-color: var(--surface-color); flex-shrink: 0; position: relative; }
.horizontal-card-img { width: 100%; height: 100%; object-fit: cover; }
.horizontal-card-fallback { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: bold; background: linear-gradient(135deg, #764ba2 0%, #2575fc 100%); color: #ffffff; }

.horizontal-card-right-content-box { width: 55%; padding: 16px; display: flex; flex-direction: column; justify-content: space-between; white-space: normal; }
.horizontal-card-title { font-size: 0.95rem; font-weight: 800; line-height: 1.3; color: #000000; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.horizontal-card-author { font-size: 0.78rem; color: #666666; font-weight: 600; margin-bottom: 6px; display: block; }
.horizontal-card-desc-snippet { font-size: 0.8rem; color: #555555; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px; }
.horizontal-card-bottom-row { margin-top: auto; display: flex; align-items: center; justify-content: space-between; }
.brutal-price-flag-pill { background-color: var(--primary-color); color: #000000; border: 1.5px solid #000000; padding: 3px 10px; border-radius: 4px; font-size: 0.76rem; font-weight: 800; }

/* ==========================================================================
   ON THE MARKET ADVANCED LAYOUT SYSTEM
   ========================================================================= */
.catalog-section-divider { border: none; border-top: 3px solid #000000; margin: 45px 0 35px 0; opacity: 1; }
.market-sorting-tabs { display: flex; align-items: center; gap: 8px; }

.btn-market-tab { background: transparent; border: 2px solid transparent; color: #555555; font-weight: 700; font-size: 0.82rem; padding: 6px 14px; border-radius: 30px; cursor: pointer; transition: var(--transition-premium); text-decoration: none; }
.btn-market-tab:hover { color: #000000; background-color: var(--surface-color); }
.btn-market-tab.active { color: #FFFFFF !important; background-color: #000000 !important; border: 2px solid #000000 !important; }

.brutal-filter-sidebar { background-color: #FFFFFF; border: 3px solid #000000; border-radius: 12px; overflow: hidden; box-shadow: 4px 4px 0px #000000; }
.sidebar-filter-item { padding: 14px 18px; font-weight: 700; font-size: 0.88rem; color: #000000; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #000000; text-decoration: none; transition: var(--transition-premium); }
.sidebar-filter-item:last-child { border-bottom: none; }
.sidebar-filter-item:not(.sidebar-header-node):hover { background-color: var(--surface-color); }
.sidebar-filter-item.active { background-color: var(--primary-color) !important; font-weight: 800; }
.sidebar-header-node { background-color: var(--surface-color); font-size: 0.92rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; cursor: default; }
.sidebar-chevron-icon { font-size: 0.75rem; color: #000000; }

/* ==========================================================================
   STRICT MARKET PREVIEW GRID & COMPACT CARDS
   ========================================================================= */
.market-product-card { background: #FFFFFF; border: 3px solid #000000; border-radius: 14px; box-shadow: 4px 4px 0px #000000; display: flex; flex-direction: column; height: 100%; overflow: hidden; text-decoration: none; color: inherit; transition: var(--transition-premium); }
.market-product-card:hover { transform: translateY(-2px); box-shadow: 6px 6px 0px #000000; }

.market-square-thumbnail-box { position: relative; width: 100%; aspect-ratio: 1 / 1; border-bottom: 3px solid #000000; background-color: var(--surface-color); overflow: hidden; }
.market-square-img { width: 100%; height: 100%; object-fit: cover; }

.market-card-meta-wrap { padding: 16px; display: flex; flex-direction: column; flex-grow: 1; }
.market-card-title { font-size: 0.92rem; font-weight: 800; line-height: 1.3; color: #000000; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.6em; }
.market-card-creator-row { display: flex; align-items: center; gap: 6px; margin-bottom: 12px; }
.market-mini-avatar { width: 16px; height: 16px; border-radius: 50%; background-color: var(--primary-color); border: 1px solid #000000; display: inline-flex; align-items: center; justify-content: center; font-size: 0.55rem; font-weight: bold; }
.market-creator-name { font-size: 0.78rem; color: #555555; font-weight: 600; }

.market-price-ribbon-tag { background-color: var(--primary-color); color: #000000; font-weight: 900; font-size: 0.78rem; padding: 5px 14px 5px 10px; border: 2px solid #000000; display: inline-block; align-self: flex-start; margin-top: auto; clip-path: polygon(0% 0%, 88% 0%, 100% 50%, 88% 100%, 0% 100%); }
.empty-catalog-illustration { border: 3px dashed #000000; padding: 40px; text-align: center; background: var(--surface-color); border-radius: 20px; display: none; }

@media(max-width: 991px) { .gr-featured-horizontal-card { flex: 0 0 calc(50% - 10px); } }
@media(max-width: 767px) { .gr-featured-horizontal-card { flex: 0 0 85%; min-width: 310px; } .market-sorting-tabs { display: none; } }
</style>

<div class="container-fluid px-4 px-md-5 index-main-workspace">

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="admin-shortcut-banner">
            <div class="admin-shadow-overlay"></div>
            <div class="admin-mode-indicator">
                <i class="fa-solid fa-user-shield me-1"></i> Admin Session Active <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
            </div>
            <a href="admin/dashboard.php" class="btn-brutal-dashboard-jump">
                <i class="fa-solid fa-gauge-high me-1"></i> Open Admin Dashboard →
            </a>
        </div>
    <?php endif; ?>

    <div class="featured-header-tray">
        <h4 class="featured-heading-text">Featured products</h4>
        <div class="featured-pagination-mock">
            <i class="fa-solid fa-arrow-left-long featured-nav-arrow disabled" id="featured-prev-arrow"></i> 
            <span id="featured-page-count">1 / 1</span> 
            <i class="fa-solid fa-arrow-right-long featured-nav-arrow" id="featured-next-arrow"></i>
        </div>
    </div>
    
    <div class="featured-scroll-track" id="featured-carousel-container">
        <?php 
        if (count($products_array) > 0):
            foreach ($products_array as $fp):
                $fp_name = htmlspecialchars($fp['name'], ENT_QUOTES, 'UTF-8');
                $fp_desc = htmlspecialchars($fp['description'], ENT_QUOTES, 'UTF-8');
                $fp_img  = htmlspecialchars($fp['image'], ENT_QUOTES, 'UTF-8');
                $fp_cat  = htmlspecialchars($fp['category'] ?? 'software', ENT_QUOTES, 'UTF-8');
                $fp_price = number_format($fp['price']);
        ?>
            <a href="cart.php?add=<?= $fp['id'] ?>" class="gr-featured-horizontal-card featured-item-slide" data-category="<?= $fp_cat ?>">
                <div class="horizontal-card-left-img-box">
                    <?php if(!empty($fp['image'])): ?>
                        <img src="<?= $fp_img ?>" class="horizontal-card-img" alt="">
                    <?php else: ?>
                        <div class="horizontal-card-fallback">ASSET</div>
                    <?php endif; ?>
                </div>

                <div class="horizontal-card-right-content-box">
                    <div>
                        <h5 class="horizontal-card-title" title="<?= $fp_name ?>"><?= $fp_name ?></h5>
                        <span class="horizontal-card-author">by digitalstore verified</span>
                        <p class="horizontal-card-desc-snippet"><?= !empty($fp['description']) ? $fp_desc : 'No description written for this node.' ?></p>
                    </div>
                    <div class="horizontal-card-bottom-row"><div class="brutal-price-flag-pill">Rs. <?= $fp_price ?></div></div>
                </div>
            </a>
        <?php 
            endforeach;
        else:
        ?>
            <p class="text-muted small">No production assets listed within the featured loop index track currently.</p>
        <?php endif; ?>
    </div>

    <hr class="catalog-section-divider">
    
    <div class="featured-header-tray" style="margin-bottom: 25px;">
        <h4 class="featured-heading-text">On the market</h4>
        
        <div class="market-sorting-tabs">
            <button class="btn-market-tab active" onclick="alterMarketFilter('trending', this)">Trending</button>
            <button class="btn-market-tab" onclick="alterMarketFilter('bestsellers', this)">Best Sellers</button>
            <button class="btn-market-tab" onclick="alterMarketFilter('hotnew', this)">Hot & New</button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <aside class="brutal-filter-sidebar">
                <div class="sidebar-filter-item sidebar-header-node">Categories</div>
                <a href="#" class="sidebar-filter-item active" onclick="filterCategory('all', this); event.preventDefault();">
                    <span>All Products</span> <i class="fa-solid fa-chevron-right sidebar-chevron-icon"></i>
                </a>
                <?php foreach($mock_categories as $cat): ?>
                    <a href="#" class="sidebar-filter-item" onclick="filterCategory('<?= $cat ?>', this); event.preventDefault();">
                        <span><?= ucfirst($cat == 'drawing' ? 'Drawing & Art' : ($cat == '3d' ? '3D Assets' : ($cat == 'design' ? 'Design Files' : ($cat == 'music' ? 'Music & Audio' : ($cat == 'education' ? 'Education' : $cat))))) ?></span> <i class="fa-solid fa-chevron-right sidebar-chevron-icon"></i>
                    </a>
                <?php endforeach; ?>
            </aside>
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4" id="catalog-products-grid">
                <?php 
                if (count($market_products) > 0): 
                    foreach ($market_products as $product):
                        $safe_name = htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8');
                        $safe_img  = htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8');
                        $p_cat     = htmlspecialchars($product['category'] ?? 'software', ENT_QUOTES, 'UTF-8');
                ?>
                    <div class="col product-item-node" data-category="<?= $p_cat ?>">
                        <a href="cart.php?add=<?= $product['id'] ?>" class="market-product-card">
                            <div class="market-square-thumbnail-box">
                                <?php if(!empty($product['image'])): ?>
                                    <img src="<?= $safe_img ?>" class="market-square-img" alt="" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none');">
                                <?php endif; ?>
                                <div class="yt-fallback-placeholder <?= !empty($product['image']) ? 'd-none' : '' ?>" style="border-radius:0; position: absolute; top:0; left:0; width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-weight:bold; background: linear-gradient(135deg, #764ba2 0%, #2575fc 100%); color:#fff;">DATA</div>
                            </div>

                            <div class="market-card-meta-wrap">
                                <h6 class="market-card-title" title="<?= $safe_name ?>"><?= $safe_name ?></h6>
                                <div class="market-card-creator-row">
                                    <div class="market-mini-avatar">s</div>
                                    <span class="market-creator-name">store_verified</span>
                                </div>
                                <div class="market-price-ribbon-tag">Rs. <?= number_format($product['price']) ?></div>
                            </div>
                        </a>
                    </div>
                <?php 
                    endforeach; 
                endif; 
                ?>

                <div class="col-12 w-100" id="filter-empty-state-card" style="display:none;">
                    <div class="empty-catalog-illustration" style="display:block;">
                        <h5 class="fw-bold text-dark mb-1">No Active Listings matching this category</h5>
                        <p class="text-muted small mb-0">Select alternative navigation category tokens from the filter options panel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterCategory(categoryKey, elementRef) {
    document.querySelectorAll('.filter-pill, .category-pill, .sidebar-filter-item').forEach(pill => {
        pill.classList.remove('active');
    });
    
    if(elementRef) elementRef.classList.add('active');

    let visibleGridCount = 0;

    document.querySelectorAll('.product-item-node').forEach(card => {
        const itemCat = card.getAttribute('data-category');
        if (categoryKey === 'all' || itemCat === categoryKey) {
            card.style.display = 'block';
            visibleGridCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const emptyBox = document.getElementById('filter-empty-state-card');
    if(emptyBox) { emptyBox.style.display = (visibleGridCount === 0) ? 'block' : 'none'; }

    document.querySelectorAll('.featured-item-slide').forEach(slide => {
        const slideCat = slide.getAttribute('data-category');
        if (categoryKey === 'all' || slideCat === categoryKey) {
            slide.style.display = 'flex';
        } else {
            slide.style.display = 'none';
        }
    });

    if (typeof window.calculatePaginationMetrics === 'function') { window.calculatePaginationMetrics(); }
}

function alterMarketFilter(filterKey, elementRef) {
    if(elementRef) {
        const parentTray = elementRef.parentElement;
        parentTray.querySelectorAll('.btn-market-tab').forEach(btn => btn.classList.remove('active'));
        elementRef.classList.add('active');
    }

    const grid = document.getElementById('catalog-products-grid');
    const items = Array.from(grid.querySelectorAll('.product-item-node'));

    if (filterKey === 'bestsellers') {
        items.sort((a, b) => {
            const priceA = parseFloat(a.querySelector('.market-price-ribbon-tag').innerText.replace(/[^0-9.]/g, ''));
            const priceB = parseFloat(b.querySelector('.market-price-ribbon-tag').innerText.replace(/[^0-9.]/g, ''));
            return priceB - priceA;
        });
    } else if (filterKey === 'hotnew') {
        items.sort((a, b) => {
            const linkA = a.querySelector('a').getAttribute('href');
            const linkB = b.querySelector('a').getAttribute('href');
            return linkB.localeCompare(linkA);
        });
    } else {
        items.sort(() => Math.random() - 0.5);
    }

    items.forEach(item => grid.appendChild(item));
    const emptyBox = document.getElementById('filter-empty-state-card');
    if(emptyBox) grid.appendChild(emptyBox);
}

document.addEventListener("DOMContentLoaded", () => {
    const track = document.getElementById('featured-carousel-container');
    const prevArrow = document.getElementById('featured-prev-arrow');
    const nextArrow = document.getElementById('featured-next-arrow');
    const countDisplay = document.getElementById('featured-page-count');

    if (!track || !prevArrow || !nextArrow || !countDisplay) return;

    window.calculatePaginationMetrics = function() {
        const activeCards = Array.from(track.querySelectorAll('.gr-featured-horizontal-card')).filter(c => c.style.display !== 'none');
        const totalCards = activeCards.length;
        
        if (totalCards === 0) {
            countDisplay.innerText = "0 / 0";
            nextArrow.classList.add('disabled');
            prevArrow.classList.add('disabled');
            return;
        }

        const cardWidth = activeCards[0].offsetWidth + 20; 
        const currentScroll = track.scrollLeft;
        const activePage = Math.min(Math.round(currentScroll / cardWidth) + 1, totalCards);
        
        countDisplay.innerText = `${activePage} / ${totalCards}`;

        if (track.scrollLeft <= 5) { prevArrow.classList.add('disabled'); } else { prevArrow.classList.add('disabled'); }
        if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 5) { nextArrow.classList.add('disabled'); } else { nextArrow.classList.remove('disabled'); }
    };

    nextArrow.addEventListener('click', () => {
        const activeCards = Array.from(track.querySelectorAll('.gr-featured-horizontal-card')).filter(c => c.style.display !== 'none');
        if(activeCards.length > 0) track.scrollBy({ left: activeCards[0].offsetWidth + 20, behavior: 'smooth' });
    });

    prevArrow.addEventListener('click', () => {
        const activeCards = Array.from(track.querySelectorAll('.gr-featured-horizontal-card')).filter(c => c.style.display !== 'none');
        if(activeCards.length > 0) track.scrollBy({ left: -(activeCards[0].offsetWidth + 20), behavior: 'smooth' });
    });

    track.addEventListener('scroll', window.calculatePaginationMetrics);
    window.addEventListener('resize', window.calculatePaginationMetrics);
    window.calculatePaginationMetrics();
});
</script>

<?php include 'includes/footer.php'; ?>