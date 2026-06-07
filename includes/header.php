<?php
// Determine the current page file name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Store</title>
  
  <!-- Core Structural Frameworks -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/digital-store/assets/css/style.css">
  
  <!-- Premium Startup Typography & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
  :root {
      --primary-color: #FF90E8;
      --primary-hover: #FF75DE;
      --secondary-color: #000000;
      --bg-color: #FFFFFF;
      --surface-color: #F8F8F8;
      --border-color: #000000;
      --soft-border: #EAEAEA;
      
      --font-main: 'Plus Jakarta Sans', sans-serif;
      --transition-premium: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  body {
      background-color: var(--bg-color);
      font-family: var(--font-main);
      color: var(--secondary-color);
      overflow-x: hidden;
  }

  /* Premium Sticky Header Layout Frame */
  .premium-nav {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: #FFFFFF;
      border-bottom: none; 
      padding: 18px 0;
  }
  
  /* Bold Refined Typographic Wordmark Logo */
  .nav-logo {
      font-weight: 900; 
      font-size: 2.2rem; 
      letter-spacing: -0.5px;
      text-transform: lowercase;
      text-decoration: none;
      color: var(--secondary-color);
      transition: var(--transition-premium);
      display: inline-flex;
      align-items: center;
      line-height: 1;
      text-shadow: 0.4px 0 0px var(--secondary-color), -0.4px 0 0px var(--secondary-color);
  }
  .nav-logo:hover { color: var(--primary-hover); }
  .nav-logo span {
      color: var(--primary-color);
      text-shadow: 0.4px 0 0px var(--primary-color), -0.4px 0 0px var(--primary-color);
  }

  /* Expanded Stretch Search Bar */
  .search-container {
      position: relative;
      flex-grow: 1; 
      max-width: 55%; 
      margin: 0 35px;
  }
  .search-bar-input {
      width: 100%;
      padding: 12px 16px 12px 48px;
      border: 3px solid var(--secondary-color);
      border-radius: 8px; 
      font-weight: 600;
      font-size: 0.92rem;
      color: #000000;
      background-color: var(--surface-color);
      transition: var(--transition-premium);
  }
  .search-bar-input:focus {
      outline: none;
      background-color: var(--bg-color);
      box-shadow: 4px 4px 0px var(--secondary-color);
      transform: translate(-2px, -2px);
  }
  .search-icon-inside {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--secondary-color);
      font-size: 1rem;
      pointer-events: none;
  }

  /* Rectangular Premium Button Modules */
  .btn-brutal-primary, .btn-brutal-secondary {
      border: 3px solid var(--border-color);
      font-weight: 800;
      border-radius: 8px; 
      padding: 11px 22px;
      box-shadow: 3px 3px 0px var(--border-color);
      transition: var(--transition-premium);
      font-size: 0.9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
  }
  .btn-brutal-primary { background-color: var(--primary-color); color: var(--secondary-color); }
  .btn-brutal-primary:hover { background-color: var(--primary-hover); transform: translate(-2px, -2px); box-shadow: 5px 5px 0px var(--border-color); }
  .btn-brutal-secondary { background-color: var(--bg-color); color: var(--secondary-color); }
  .btn-brutal-secondary:hover { background-color: var(--surface-color); transform: translate(-2px, -2px); box-shadow: 5px 5px 0px var(--border-color); }

  /* ==========================================================================
     RESTORED COMPACT NATURAL FLOW SUB-NAVBAR 
     ========================================================================= */
  .gr-subnav-stripe {
      background-color: #FFFFFF; 
      border-bottom: 3px solid var(--secondary-color); 
      padding: 8px 0; 
      position: sticky;
      top: 86px; 
      z-index: 999;
  }

  .gr-scroll-container {
      display: flex;
      align-items: center;
      justify-content: flex-start; /* Restored back to natural flow spacing */
      overflow-x: auto;
      white-space: nowrap;
      gap: 10px; /* Tight sleek spacing matching image layout fields */
      padding: 4px 0;
      scrollbar-width: none;
  }
  .gr-scroll-container::-webkit-scrollbar { display: none; }

  .gr-filter-link {
      color: var(--secondary-color);
      text-decoration: none;
      font-size: 0.82rem; 
      font-weight: 700;
      cursor: pointer;
      padding: 6px 14px; 
      border: 2px solid transparent;
      border-radius: 30px;
      transition: var(--transition-premium);
      display: inline-flex;
      align-items: center;
  }
  .gr-filter-link:hover { background-color: var(--surface-color); }

  .gr-filter-link.active {
      color: var(--secondary-color) !important;
      background-color: var(--primary-color) !important; 
      border: 2px solid var(--secondary-color) !important;
      box-shadow: 2px 2px 0px var(--secondary-color) !important;
      transform: translate(-1px, -1px);
  }

  .gr-more-dropdown {
      color: var(--secondary-color);
      font-weight: 700;
      font-size: 0.82rem; 
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
  }

  @media(max-width: 767px) {
      .search-container { margin: 0 15px; max-width: 45%; }
      .btn-brutal-primary, .btn-brutal-secondary { padding: 8px 14px; font-size: 0.82rem; }
  }
  </style>
</head>
<body>

<?php if ($current_page !== 'login.php' && $current_page !== 'register.php'): ?>
<!-- Premium Sticky Global Navbar -->
<nav class="premium-nav">
  <div class="container-fluid px-4 px-md-5 d-flex align-items-center justify-content-between">
    <a href="/digital-store/index.php" class="nav-logo">digitalstore<span>.</span></a>

    <div class="search-container d-none d-md-block">
      <i class="fa-solid fa-magnifying-glass search-icon-inside"></i>
      <input type="text" id="live-search-input" class="search-bar-input" placeholder="Search products">
    </div>

    <div class="d-flex align-items-center gap-2">
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="/digital-store/cart.php" class="btn-brutal-secondary"><i class="fa-solid fa-cart-shopping"></i> <span>Cart</span></a>
        <a href="/digital-store/orders.php" class="btn-brutal-secondary d-none d-sm-inline-flex"><i class="fa-solid fa-receipt"></i> Orders</a>
        <a href="/digital-store/logout.php" class="btn-brutal-primary">Logout</a>
      <?php else: ?>
        <a href="/digital-store/login.php" class="btn-brutal-secondary">Log in</a>
        <a href="/digital-store/register.php" class="btn-brutal-primary">Start selling</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php if ($current_page === 'index.php'): ?>
<!-- Horizontal Sub-category Track Stripe Module -->
<div class="gr-subnav-stripe">
    <div class="container-fluid px-4 px-md-5">
        <div class="d-flex align-items-center justify-content-between position-relative">
            
            <!-- Complete, fully packed category track matrix naturally running full screen -->
            <div class="gr-scroll-container flex-grow-1 me-3">
                <div class="gr-filter-link filter-pill active" onclick="filterCategory('all', this)">All</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('drawing', this)">Drawing & Painting</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('3d', this)">3D Asset Nodes</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('design', this)">Design</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('music', this)">Music & Sound Design</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('software', this)">Software Development</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('education', this)">Education</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('business', this)">Business & Money</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('films', this)">Films</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('self', this)">Self Improvement</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('gaming', this)">Gaming</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('photography', this)">Photography</div>
                <div class="gr-filter-link filter-pill" onclick="filterCategory('comics', this)">Comics & Graphic Novels</div>
            </div>

            <div class="gr-more-dropdown ps-3 bg-white border-start">More <i class="fa-solid fa-chevron-down" style="font-size:0.75rem;"></i></div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if ($current_page !== 'index.php'): ?>
  <div class="container-fluid px-4 px-md-5" style="margin-top: 40px;">
<?php endif; ?>