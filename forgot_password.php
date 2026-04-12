<?php
session_start();
require_once 'db_config.php';

$step    = $_GET['step'] ?? 'request';  // 'request' | 'reset'
$token   = $_GET['token'] ?? '';
$message = '';
$error   = '';

// ---- STEP 1: User submits email ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'request') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $con = getDBConnection();
        $stmt = mysqli_prepare($con, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Generate a token and store it in session (simple method – no email sending needed for localhost)
            $resetToken = bin2hex(random_bytes(32));
            $_SESSION['reset_token'] = $resetToken;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_expiry'] = time() + 3600; // 1 hour

            // In a real app you would email this link. For localhost, display it directly:
            $resetLink = "http://localhost/ORIGINALPROJECT/forgot_password.php?step=reset&token=" . $resetToken;
            $message = "✅ Password reset link generated!<br><br>
                        <strong>For localhost testing, click here:</strong><br>
                        <a href='{$resetLink}' style='color:#1ae4c0;'>{$resetLink}</a><br><br>
                        <small>(In a live website, this link is sent to your email.)</small>";
        } else {
            // Don't reveal if email exists (security best practice)
            $message = "✅ If that email is registered, a reset link has been sent.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}

// ---- STEP 2: User submits new password ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'reset') {
    $newPass = $_POST['password']  ?? '';
    $confirm = $_POST['confirm']   ?? '';
    $tok     = $_POST['token']     ?? '';

    if (empty($newPass) || strlen($newPass) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($newPass !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (!isset($_SESSION['reset_token']) || $_SESSION['reset_token'] !== $tok) {
        $error = "Invalid or expired reset link. Please try again.";
    } elseif (time() > ($_SESSION['reset_expiry'] ?? 0)) {
        $error = "Reset link has expired. Please request a new one.";
    } else {
        $email  = $_SESSION['reset_email'];
        $hashed = password_hash($newPass, PASSWORD_BCRYPT);
        $con    = getDBConnection();

        $stmt = mysqli_prepare($con, "UPDATE users SET password = ? WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed, $email);

        if (mysqli_stmt_execute($stmt)) {
            unset($_SESSION['reset_token'], $_SESSION['reset_email'], $_SESSION['reset_expiry']);
            $message = "✅ Password updated! <a href='login.php' style='color:#1ae4c0;'>Click here to login</a>.";
            $step = 'done';
        } else {
            $error = "Something went wrong. Please try again.";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
}

// Validate token on GET for reset step
if ($step === 'reset' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['reset_token']) || $_SESSION['reset_token'] !== $token) {
        $error = "Invalid or expired reset link.";
        $step  = 'request';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password – Pdf To Audio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Poppins', sans-serif;
    }
    .auth-card {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 20px;
      padding: 45px 40px;
      width: 100%; max-width: 450px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.4);
      color: #fff;
    }
    .brand-logo { text-align:center; margin-bottom:8px; font-size:1.8rem; font-weight:700; color:#1ae4c0; }
    .auth-card h2 { text-align:center; font-size:1.2rem; font-weight:400; color:rgba(255,255,255,0.7); margin-bottom:25px; }
    .form-label { color:rgba(255,255,255,0.85); font-size:0.9rem; }
    .form-control {
      background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2);
      color:#fff; border-radius:10px; padding:12px 15px;
    }
    .form-control:focus { background:rgba(255,255,255,0.15); border-color:#1ae4c0; color:#fff; box-shadow:0 0 0 3px rgba(26,228,192,0.2); outline:none; }
    .form-control::placeholder { color:rgba(255,255,255,0.4); }
    .password-toggle { cursor:pointer; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.6); border-radius:0 10px 10px 0; padding:0 14px; }
    .btn-main { background:linear-gradient(135deg,#1ae4c0,#0ab89a); border:none; color:#000; font-weight:600; padding:13px; border-radius:10px; width:100%; font-size:1rem; margin-top:10px; transition:all 0.3s; }
    .btn-main:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(26,228,192,0.4); }
    .alert { border-radius:10px; font-size:0.9rem; }
    .back-link { text-align:center; margin-top:20px; font-size:0.9rem; color:rgba(255,255,255,0.5); }
    .back-link a { color:#1ae4c0; text-decoration:none; }
  </style>
</head>
<body>
<div class="auth-card">
  <div class="brand-logo">🎧 Pdf To Audio</div>

  <?php if ($step === 'request'): ?>
    <h2>Reset your password</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($message): ?><div class="alert alert-info"><?= $message ?></div><?php endif; ?>

    <?php if (!$message): ?>
    <form method="POST" action="forgot_password.php?step=request">
      <div class="mb-3">
        <label class="form-label">Registered Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>
      <button type="submit" class="btn-main"><i class="bi bi-send me-2"></i>Send Reset Link</button>
    </form>
    <?php endif; ?>

  <?php elseif ($step === 'reset'): ?>
    <h2>Enter your new password</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="POST" action="forgot_password.php?step=reset">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
          <input type="password" name="password" id="newpass" class="form-control" placeholder="Min. 6 characters" required>
          <button type="button" class="password-toggle" onclick="togglePass('newpass','eye1')"><i class="bi bi-eye" id="eye1"></i></button>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <div class="input-group">
          <input type="password" name="confirm" id="confirmpass" class="form-control" placeholder="Re-enter password" required>
          <button type="button" class="password-toggle" onclick="togglePass('confirmpass','eye2')"><i class="bi bi-eye" id="eye2"></i></button>
        </div>
      </div>
      <button type="submit" class="btn-main"><i class="bi bi-lock-fill me-2"></i>Update Password</button>
    </form>

  <?php elseif ($step === 'done'): ?>
    <h2>Password Updated!</h2>
    <div class="alert alert-success"><?= $message ?></div>
  <?php endif; ?>

  <div class="back-link"><a href="login.php"><i class="bi bi-arrow-left me-1"></i>Back to Login</a></div>
</div>

<script>
function togglePass(fieldId, iconId) {
  const f = document.getElementById(fieldId), i = document.getElementById(iconId);
  f.type = f.type === 'password' ? 'text' : 'password';
  i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
