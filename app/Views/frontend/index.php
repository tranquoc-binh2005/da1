<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title ?? "Hạt Vàng Organic"?></title>
    <base href="<?= rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/') . '/' ?>">
    <?php include 'layout/head.php';?>
</head>
<body>
<!-- Header -->
<?php include 'layout/header.php';?>

<div class="main-wrapper">
    <?php include "{$body}.php"; ?>
</div>

<?php include 'layout/footer.php';?>
<?php include 'layout/script.php';?>

</body>
</html>