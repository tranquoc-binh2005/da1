<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upvex - Responsive Admin Dashboard Template</title>
    <base href="<?=BASE_URL?>">
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
                            <a href="/">
                                <span><img src="\public\assets\images\logo-light.png" alt="" height="26"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Vui lòng điền tài khoản và mật khẩu để đăng nhập vào hệ thống</p>
                        </div>

                        <h5 class="auth-title">Đăng nhập</h5>

                        <form action="/auth/authenticate" method="POST">

                            <div class="form-group mb-3">
                                <label for="emailaddress">Email</label>
                                <input class="form-control" name="email" type="email" id="emailaddress" value="<?= old('email')?>" required="" placeholder="Vui lòng nhập tài khoản email">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Mật khẩu</label>
                                <input class="form-control" name="password" type="password" required="" id="password" placeholder="Vui lòng nhập mật khẩu">
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

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox checkbox-info">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                    <label class="custom-control-label" for="checkbox-signin">Ghi nhớ tôi</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-danger btn-block" type="submit">Đăng nhập</button>
                            </div>

                        </form>

                        <div class="text-center">
                            <h5 class="mt-3 text-muted">Đăng nhập với</h5>
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
                        <p> <a href="pages-recoverpw.html" class="text-muted ml-1">Quên mật khẩu?</a></p>
                        <p class="text-muted">Bạn chưa có tài khoản? <a href="/auth/register" class="text-muted ml-1"><b class="font-weight-semibold">Đăng ký ngay</b></a></p>
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
    2025 &copy; Coppyrighting <a href="" class="text-muted">Hạt Vàng</a>
</footer>

<!-- Vendor js -->
<script src="assets\js\vendor.min.js"></script>

<!-- App js -->
<script src="assets\js\app.min.js"></script>

</body>
</html>