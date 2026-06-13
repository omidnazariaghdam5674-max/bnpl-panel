<?php
session_start();
if (isset($_SESSION['store_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8">
    <title>ورود فروشگاه - سامانه BNPL</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <h2>پنل فروشندگان BNPL</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">ایمیل یا رمز عبور اشتباه است</div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>ایمیل فروشگاه:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>رمز عبور:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">ورود به پنل</button>
        </form>
    </div>
</body>

</html>