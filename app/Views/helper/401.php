<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title ?? 'UnAuthorized'?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .error-container {
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.9);
        }
        .error-code {
            font-size: 150px;
            font-weight: bold;
            background: linear-gradient(90deg, #dc3545, #ffc107); /* Gradient chữ */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: wobble 2s infinite; /* Lắc lư liên tục */
        }
        .error-message {
            font-size: 28px;
            color: #6c757d;
            animation: pulse 1.5s infinite; /* Nhịp đập */
        }
        .btn-home {
            margin-top: 25px;
            padding: 10px 20px;
            font-size: 18px;
            background: linear-gradient(90deg, #0d6efd, #6610f2); /* Gradient nút */
            border: none;
            transition: transform 0.3s ease;
        }
        .btn-home:hover {
            transform: scale(1.1); /* Phóng to khi hover */
        }
    </style>
</head>
<body>
<div class="error-container animate__animated animate__fadeIn">
    <h1 class="error-code animate__animated animate__wobble"><?=$code ?? '401'?></h1>
    <p class="error-message animate__animated animate__pulse">
        <?=$message ?? 'UnAuthorized'?>
    </p>
    <a href="/" class="btn btn-primary btn-home animate__animated animate__bounceIn animate__delay-1s">
        Quay về trang chủ
    </a>
</div>

<!-- Bootstrap 5 JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>