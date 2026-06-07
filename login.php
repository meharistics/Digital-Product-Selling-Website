<?php
session_start();
// 1. SILENT RUNTIME CONTROLLERS (No HTML output allowed above this line)
include 'includes/db.php';

$message = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == 'admin') {
            // 🔥 LOCKDOWN TRIGGER: Grant a single-use administrative workspace pass
            $_SESSION['admin_access_pass'] = true;
            header("Location: /digital-store/admin/dashboard.php");
        } else {
            header("Location: /digital-store/index.php");
        }
        exit();
    } else {
        $message = "
        <div class='brutal-error-box animate-slide-up'>
            <div class='error-icon-shield'>⚡</div>
            <div>
                <strong>Authentication Failed</strong>
                <p>We couldn't verify those credentials. Check your details and try again.</p>
            </div>
        </div>";
    }
}

// 2. LAYOUT ENGINE ACTIVATION
include 'includes/header.php';
?>

<style>
/* POLISHED VIEWPORT SPACING */
.login-root-container {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 20px 180px 20px;
}

.brutal-login-card {
    background-color: #FFFFFF;
    border: 3px solid #000000;
    border-radius: 20px;
    box-shadow: 6px 6px 0px #000000;
    width: 100%;
    max-width: 440px;
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

.brutal-login-title {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -1px;
    color: #000000;
    margin-bottom: 6px;
}

.brutal-login-sub {
    font-size: 0.88rem;
    color: #555555;
    font-weight: 600;
    margin-bottom: 25px;
}

.brutal-field-group { margin-bottom: 20px; }

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

.brutal-password-wrapper { position: relative; }

.brutal-password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    color: #000000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.brutal-error-box {
    background-color: #FFF0F0;
    border: 2.5px solid #000000;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 22px;
    display: flex;
    gap: 12px;
    box-shadow: 3px 3px 0px #000000;
}

.error-icon-shield {
    background-color: var(--primary-color);
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
}

.brutal-error-box strong { display: block; font-size: 0.85rem; font-weight: 800; color: #000000; margin-bottom: 2px; }
.brutal-error-box p { font-size: 0.78rem; color: #333333; font-weight: 600; margin: 0; line-height: 1.3; }

.btn-brutal-submit {
    width: 100%;
    background-color: var(--primary-color);
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
    margin-top: 10px;
}
.btn-brutal-submit:hover {
    background-color: var(--primary-hover);
    transform: translate(-2px, -2px);
    box-shadow: 6px 6px 0px #000000;
}

.brutal-submit-spinner {
    width: 18px;
    height: 18px;
    border: 2.5px solid #000000;
    border-top-color: transparent;
    border-radius: 50%;
    animation: brutalSpin 0.7s linear infinite;
    display: none;
}
@keyframes brutalSpin { to { transform: rotate(360deg); } }

.brutal-switch-link { text-align: center; margin-top: 25px; font-size: 0.85rem; font-weight: 600; color: #555555; }
.brutal-switch-link a {
    color: #000000;
    font-weight: 800;
    text-decoration: none;
    border-bottom: 2px solid var(--primary-color);
    transition: var(--transition-premium);
}
.brutal-switch-link a:hover { background-color: var(--primary-color); }
</style>

<div class="login-root-container">
    <div class="brutal-login-card">
        <div class="text-center">
            <span class="brutal-card-tag">SECURE ACCESS</span>
            <h2 class="brutal-login-title">Welcome Back</h2>
            <p class="brutal-login-sub">Sign in to manage downloads and software orders.</p>
        </div>

        <?= $message ?>

        <form method="POST" id="brutalLoginForm">
            <div class="brutal-field-group">
                <label class="brutal-field-label">Email Address</label>
                <input type="email" name="email" class="brutal-input-control" placeholder="name@domain.com" required autocomplete="email">
            </div>

            <div class="brutal-field-group">
                <label class="brutal-field-label">Account Password</label>
                <div class="brutal-password-wrapper">
                    <input type="password" name="password" id="brutalPasswordField" class="brutal-input-control" placeholder="••••••••" required>
                    <button type="button" id="brutalTogglePassword" class="brutal-password-toggle" title="Toggle visibility">
                        <i class="fa-regular fa-eye" id="brutalEyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" id="brutalSubmitBtn" class="btn-brutal-submit">
                <span id="brutalBtnText">Sign In Engine <i class="fa-solid fa-arrow-right ms-1"></i></span>
                <div class="brutal-submit-spinner" id="brutalBtnSpinner"></div>
            </button>
        </form>

        <div class="brutal-switch-link">
            Don't have an account? <a href="register.php">Register Now</a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const togglePassword = document.getElementById('brutalTogglePassword');
    const passwordField = document.getElementById('brutalPasswordField');
    const eyeIcon = document.getElementById('brutalEyeIcon');
    const loginForm = document.getElementById('brutalLoginForm');
    const submitBtn = document.getElementById('brutalSubmitBtn');
    const btnText = document.getElementById('brutalBtnText');
    const btnSpinner = document.getElementById('brutalBtnSpinner');

    if (togglePassword && passwordField && eyeIcon) {
        togglePassword.addEventListener('click', () => {
            const currentType = passwordField.getAttribute('type');
            const targetType = currentType === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', targetType);
            eyeIcon.className = targetType === 'text' ? 'fa-solid fa-eye-slash' : 'fa-regular fa-eye';
        });
    }

    if (loginForm && submitBtn && btnText && btnSpinner) {
        loginForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.style.opacity = '0.85';
            btnText.style.display = 'none';
            btnSpinner.style.display = 'block';
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>