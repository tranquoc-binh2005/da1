<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title ?? 'Xác nhận mã OTP'?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 15px;
        }
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .otp-inputs input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .otp-inputs input:focus {
            border-color: #007bff;
            outline: none;
        }
        .submit-btn {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Nhập mã xác nhận</h2>
    <p>Vui lòng nhập mã OTP gồm 6 chữ số được gửi đến email của bạn.</p>
    <form action="/xac-nhan-otp" method="POST">
        <div class="otp-inputs">
            <input required type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 1)">
            <input required  type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 2)">
            <input required  type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 3)">
            <input required  type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 4)">
            <input required  type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 5)">
            <input required  type="text" name="code[]" maxlength="1" oninput="moveToNext(this, 6)">
        </div>
        <button type="submit" class="submit-btn">Xác nhận</button>
    </form>
</div>

<script>
    function moveToNext(input, index) {
        const inputs = document.querySelectorAll('.otp-inputs input');
        if (input.value.length === 1 && index < inputs.length) {
            inputs[index].focus();
        }
    }
</script>
</body>
</html>