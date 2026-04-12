<?php
// ============================================================
//  newsLetter.php  –  Updated version
//  Uses db_config.php and prepared statements
// ============================================================
require_once 'db_config.php';

$email = trim($_POST["email"] ?? '');

$con = getDBConnection();

// Use prepared statement
$stmt = mysqli_prepare($con, "INSERT IGNORE INTO newsletter(email) VALUES(?)");
mysqli_stmt_bind_param($stmt, "s", $email);

if (!mysqli_stmt_execute($stmt)) {
    die("Query Failed: " . mysqli_error($con));
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>

<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
  body { text-align: center; padding: 40px 0; background: #EBF0F5; }
  h1 { color: #88B04B; font-family: "Nunito Sans", sans-serif; font-weight: 900; font-size: 40px; margin-bottom: 10px; }
  p { color: #404F5E; font-family: "Nunito Sans", sans-serif; font-size: 20px; margin: 0; }
  i { color: #9ABC66; font-size: 100px; line-height: 200px; margin-left: -15px; }
  .card { background: white; padding: 60px; border-radius: 4px; box-shadow: 0 2px 3px #C8D0D8; display: inline-block; margin: 0 auto; }
</style>
<body>
  <div class="card">
    <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
      <i class="checkmark">✓</i>
    </div>
    <h1>Success</h1>
    <p>We received your request;<br /> we'll be in touch shortly!</p>
  </div>
</body>
</html>
