<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background */
        body {
            background-color: #1e5130; /* Màu nền xanh lá */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Container */
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Heading */
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Đăng ký */
        .register-link {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .register-link a {
            color: #f78c40;
            text-decoration: none;
        }

        /* Social Login Buttons */
        .social-login {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .social-login img {
            width: 20px;
            margin-right: 10px;
        }

        .fb {
            background-color: white;
            color: black;
        }

        .google {
            background-color: white;
            color: black;
        }

        /* Hoặc */
        .divider {
            margin: 20px 0;
            font-size: 14px;
            color: #666;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: "";
            width: 40%;
            height: 1px;
            background-color: #ddd;
            position: absolute;
            top: 50%;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        /* Input Group */
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

        .error-message {
            font-size: 12px;
            color: red;
            margin-top: 5px;
        }

        /* Mật khẩu */
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

        /* Quên mật khẩu */
        .forgot-password {
            text-align: right;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #f78c40;
            text-decoration: none;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #0a4d21;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #073b19;
        }

    </style>
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <h2>Đăng nhập</h2>
        <p class="register-link">Bạn chưa có tài khoản? <a href="/dang-ky-tai-khoan">Đăng ký tại đây</a></p>

<!--        <button class="social-login fb">-->
<!--            <img src="facebook-icon.png" alt="Facebook"> Log in with Facebook-->
<!--        </button>-->
<!--        <button class="social-login google">-->
<!--            <img src="google-icon.png" alt="Google"> Log in with Google-->
<!--        </button>-->

        <div class="divider">Hoặc</div>

        <form action="/xu-ly-dang-nhap" method="POST">
            <div class="input-group error">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?=old('email')?>" placeholder="Nhập email của bạn">
                <p class="error-message">
                    <?php
                    if(isset($errors['email']) && count($errors['email'])){
                        foreach($errors['email'] as $error){
                            echo $error;
                        }
                    }
                    ?>
                </p>
            </div>

            <div class="input-group error">
                <label for="password">Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu">
                    <span class="toggle-password">👁️</span>
                </div>
                <p class="error-message">
                    <?php
                    if(isset($errors['password']) && count($errors['password'])){
                        foreach($errors['password'] as $error){
                            echo $error;
                        }
                    }
                    ?>
                </p>
            </div>

            <div class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>
    </div>
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
