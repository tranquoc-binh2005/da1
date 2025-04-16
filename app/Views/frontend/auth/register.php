<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title ?? 'Đăng ký tài khoản'?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #1e5130;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .login-link {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .login-link a {
            color: #f78c40;
            text-decoration: none;
        }
        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            width: 100%;
            padding-right: 35px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .checkbox-group {
            text-align: left;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .register-btn {
            width: 100%;
            padding: 12px;
            background-color: #0a4d21;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-btn:hover {
            background-color: #073b19;
        }
        .error-message {
            font-size: 12px;
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Đăng ký tài khoản</h2>
    <p class="login-link">Bạn đã có tài khoản? <a href="/dang-nhap">Đăng nhập ngay</a></p>
    <form action="/xu-ly-dang-ky-tai-khoan" method="POST">
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?=old('email')?>" placeholder="Nhập email của bạn">
            <p class="error-message">
                <?php
                if(isset($errors['email']) && count($errors['email'])){
                    foreach($errors['email'] as $error){
                        echo $error . '</br>';
                    }
                }
                ?>
            </p>
        </div>
        <div class="input-group">
            <label for="password">Mật khẩu</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
                <span class="toggle-password">👁️</span>
            </div>
            <p class="error-message">
                <?php
                if(isset($errors['password']) && count($errors['password'])){
                    foreach($errors['password'] as $error){
                        echo $error . '</br>';
                    }
                }
                ?>
            </p>
        </div>
        <div class="input-group">
            <label for="confirm-password">Xác nhận mật khẩu</label>
            <div class="password-wrapper">
                <input type="password" name="confirm_password" id="confirm-password" placeholder="Nhập lại mật khẩu">
                <span class="toggle-password">👁️</span>
            </div>
            <p class="error-message">
                <?php
                if(isset($errors['confirm_password']) && count($errors['confirm_password'])){
                    foreach($errors['confirm_password'] as $error){
                        echo $error . '</br>';
                    }
                }
                ?>
            </p>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="agree" name="agree">
            <label for="agree">Bằng cách tạo tài khoản, tôi đồng ý với Điều khoản sử dụng và Chính sách quyền riêng tư</label>
        </div>
        <button type="submit" class="register-btn">Đăng ký</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector(".toggle-password");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.textContent = "🙈";
            } else {
                passwordInput.type = "password";
                togglePassword.textContent = "👁️";
            }
        });
    });
</script>

</body>
</html>
