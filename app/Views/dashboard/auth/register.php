<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng ký tài khoản hệ thống</title>
    <base href="http://localhost:8000/">
    <?php include ('app/Views/dashboard/layout/head.php')?>
</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <a href="index.html">
                                <span><img src="\public\assets\images\logo-light.png" alt="" height="26"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Don't have an account? Create your free account now.</p>
                        </div>

                        <h5 class="auth-title">Create Account</h5>

                        <form action="/auth/handleRegister" method="post">

                            <div class="form-group">
                                <label for="fullname">Họ và Tên</label>
                                <input
                                        class="form-control"
                                        type="text"
                                        name="name"
                                        id="fullname"
                                        value="<?= old('name')?>"
                                        placeholder="Nhập họ tên..."
                                        required="">
                                <span class="text-danger">
                                    <?php
                                    if(isset($errors['name']) && count($errors['name'])){
                                        foreach($errors['name'] as $error){
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="emailaddress">Email:</label>
                                <input
                                        class="form-control"
                                        type="email"
                                        name="email"
                                        id="emailaddress"
                                        value="<?= old('email')?>"
                                        required=""
                                        placeholder="Nhập địa chỉ email..."
                                >
                                <span class="text-danger">
                                    <?php
                                    if(isset($errors['email']) && count($errors['email'])){
                                        foreach($errors['email'] as $error){
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input
                                        class="form-control"
                                        type="password"
                                        name="password"
                                        required=""
                                        id="password"
                                        placeholder="Nhập mật khẩu">
                                <span class="text-danger">
                                    <?php
                                    if(isset($errors['password']) && count($errors['password'])){
                                        foreach($errors['password'] as $error){
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Xác nhận mật khẩu</label>
                                <input
                                        class="form-control"
                                        type="password"
                                        name="confirm_password"
                                        required=""
                                        id="confirm_password"
                                        placeholder="Nhập mật khẩu">
                                <span class="text-danger">
                                    <?php
                                    if(isset($errors['confirm_password']) && count($errors['confirm_password'])){
                                        foreach($errors['confirm_password'] as $error){
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox checkbox-info">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                    <label class="custom-control-label" for="checkbox-signup">Tôi đồng ý với <a href="javascript: void(0);" class="text-dark">chính sách và bảo mật</a></label>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-danger btn-block" type="submit"> Đăng ký </button>
                            </div>

                        </form>

                        <div class="text-center">
                            <h5 class="mt-3 text-muted">Đăng ký bằng phương thức khác</h5>
                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                                </li>
                            </ul>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Bạn đã có tài khoản?  <a href="pages-login.html" class="text-muted ml-1"><b class="font-weight-semibold">Đăng nhập</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<footer class="footer footer-alt">
    2019 &copy; Upvex theme by <a href="" class="text-muted">Coderthemes</a>
</footer>

<!-- Vendor js -->
<script src="assets\js\vendor.min.js"></script>

<!-- App js -->
<script src="assets\js\app.min.js"></script>

</body>
</html>