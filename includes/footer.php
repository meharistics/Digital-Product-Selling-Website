<?php
// Determine current page for smart structural layout container matching
$current_page = basename($_SERVER['PHP_SELF']);

// Close the conditional layout container opened in header.php if not on the homepage
if ($current_page !== 'index.php'): 
?>
  </div> <!-- Closing the container opened in header.php -->
<?php endif; ?>

<style>
/* ==========================================================================
   POLISHED GUMROAD-STYLE PREMIUM DARK FOOTER
   ========================================================================== */
.gumroad-footer {
    background-color: #000000;
    color: #FFFFFF;
    padding: 85px 0 45px 0;
    margin-top: 100px;
    font-family: var(--font-main), 'Plus Jakarta Sans', 'Inter', sans-serif;
    border-top: 1px solid #111111;
}

/* Left Subscription Column Typography */
.gumroad-subscribe-heading {
    font-size: 2.4rem;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -1.2px;
    color: #FFFFFF;
    margin-bottom: 32px;
    max-width: 520px;
}

/* Inline Input Wrapper Grid */
.gumroad-input-box {
    display: flex;
    max-width: 460px;
    width: 100%;
    margin-bottom: 35px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

/* Highly Legible Input Mechanics */
.gumroad-email-field {
    flex-grow: 1;
    background-color: #0A0A0A;
    border: 1.5px solid #2D2D2D;
    border-right: none;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
    padding: 16px 18px;
    font-size: 0.98rem;
    color: #FFFFFF;
    font-weight: 600;
    outline: none;
    transition: all 0.25s ease;
}

/* Enhanced Contrast Placeholder (Dominant & Legible) */
.gumroad-email-field::placeholder {
    color: #A0AEC0; 
    opacity: 1;
    font-weight: 500;
}

/* High-End Focus State Highlight */
.gumroad-email-field:focus {
    border-color: var(--primary-color); /* Highlight pink border line on click */
    background-color: #111111;
}

/* The Exact Premium Pink Button Element */
.btn-gumroad-arrow {
    background-color: var(--primary-color); /* #FF90E8 */
    color: #000000;
    border: 1.5px solid #2D2D2D;
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    padding: 0 28px;
    font-size: 1.3rem;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-gumroad-arrow:hover {
    background-color: var(--primary-hover); /* #FF75DE */
    transform: scale(1.02);
}

/* Platform Metadata Text */
.gumroad-copyright-line {
    font-size: 0.95rem;
    font-weight: 700;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 15px;
}
.gumroad-logo-dot {
    background-color: var(--primary-color);
    color: #000000;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    font-weight: 900;
}

/* Directory Link Structural Controls */
.gumroad-link-col {
    padding-top: 8px;
}
.gumroad-vertical-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.gumroad-vertical-menu li {
    margin-bottom: 14px;
}
.gumroad-vertical-menu a {
    color: #E2E8F0;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-block;
}
/* Link Hover states color track seamlessly to the pink startup theme accent */
.gumroad-vertical-menu a:hover {
    color: var(--primary-color);
    transform: translateX(2px);
}

/* Spaced out base social link bar layout structure */
.gumroad-social-strip {
    margin-top: 70px;
    padding-top: 35px;
    border-top: 1px solid #1A1A1A;
    display: flex;
    justify-content: center;
    gap: 110px; 
}
.gumroad-icon-link {
    color: #FFFFFF;
    font-size: 1.35rem;
    text-decoration: none;
    transition: all 0.2s ease;
}
.gumroad-icon-link:hover {
    color: var(--primary-color);
    transform: scale(1.15);
}

@media (max-width: 991px) {
    .gumroad-social-strip { gap: 55px; }
}
@media (max-width: 767px) {
    .gumroad-footer { padding-bottom: 95px; }
    .gumroad-subscribe-heading { font-size: 1.9rem; }
    .gumroad-social-strip {
        gap: 20px;
        justify-content: space-between;
    }
}
</style>

<!-- Clean Refined Dark Footer -->
<footer class="gumroad-footer">
    <div class="container">
        <div class="row g-5">
            
            <!-- Left Panel: Subscription Engine Box -->
            <div class="col-lg-7">
                <h3 class="gumroad-subscribe-heading">
                    Subscribe to get tips and tactics to grow the way you want.
                </h3>
                
                <form onsubmit="event.preventDefault(); alert('Subscribed successfully!'); this.reset();" class="gumroad-input-box">
                    <input type="email" class="gumroad-email-field" placeholder="Your email address" required autocomplete="email">
                    <button type="submit" class="btn-gumroad-arrow" aria-label="Subscribe">→</button>
                </form>

                <div class="gumroad-copyright-line">
                    <span class="gumroad-logo-dot">G</span> © Digital Store, Inc.
                </div>
            </div>

            <!-- Right Column 1: Core Navigation Links -->
            <div class="col-6 col-md-3 col-lg-2 offset-lg-1 gumroad-link-col">
                <ul class="gumroad-vertical-menu">
                    <li><a href="/digital-store/index.php">Discover</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="/digital-store/index.php">Pricing</a></li>
                    <li><a href="/digital-store/index.php">Features</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Jobs</a></li>
                    <li><a href="#">Small Bets</a></li>
                </ul>
            </div>

            <!-- Right Column 2: Assistance Hub -->
            <div class="col-6 col-md-3 col-lg-2 gumroad-link-col">
                <ul class="gumroad-vertical-menu">
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Board meetings</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

        </div>

        <!-- Base Horizontal Layout Vectors Row Tray -->
        <div class="gumroad-social-strip">
            <a href="#" class="gumroad-icon-link" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="gumroad-icon-link" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
            <a href="#" class="gumroad-icon-link" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="gumroad-icon-link" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="gumroad-icon-link" aria-label="Pinterest"><i class="fa-brands fa-pinterest"></i></a>
        </div>

    </div>
</footer>

<!-- Bootstrap JavaScript Runtime Core Dependency Assembly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>