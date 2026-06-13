<?php
session_start();
require_once 'db.php';

if(!isset($_SESSION['store_id'])) {
    header('Location: index.php');
    exit;
}

$store_id = $_SESSION['store_id'];
$store_name = $_SESSION['store_name'];

// دریافت تراکنش‌های این فروشگاه
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE store_id = ? ORDER BY created_at DESC");
$stmt->execute([$store_id]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// محاسبه آمار
$total_sales = 0;
$pending_count = 0;
foreach($transactions as $t) {
    $total_sales += $t['amount'];
    if($t['status'] == 'pending') $pending_count++;
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <title>داشبورد - <?php echo $store_name; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h2>خوش آمدید، <?php echo $store_name; ?></h2>
            <a href="logout.php" class="logout-btn">خروج</a>
        </div>

        <div class="stats">
            <div class="stat-box">
                <span>مجموع فروش</span>
                <strong><?php echo number_format($total_sales); ?> تومان</strong>
            </div>
            <div class="stat-box">
                <span>تعداد تراکنش‌ها</span>
                <strong><?php echo count($transactions); ?></strong>
            </div>
            <div class="stat-box">
                <span>در انتظار پرداخت</span>
                <strong><?php echo $pending_count; ?></strong>
            </div>
        </div>

        <h3>لیست تراکنش‌ها</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام مشتری</th>
                    <th>مبلغ</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $index => $t): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $t['customer_name']; ?></td>
                    <td><?php echo number_format($t['amount']); ?> تومان</td>
                    <td>
                        <span class="status <?php echo $t['status']; ?>">
                            <?php 
                                $status_map = ['pending' => 'در انتظار', 'paid' => 'پرداخت شده', 'overdue' => 'معوق'];
                                echo $status_map[$t['status']];
                            ?>
                        </span>
                    </td>
                    <td><?php echo $t['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($transactions)): ?>
                <tr><td colspan="5">هیچ تراکنشی یافت نشد</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>