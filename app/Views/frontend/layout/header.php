<div class="loader-container">
    <div class="loading"></div>
</div>
<!-- Header -->
<header>
    <div class="header-container container">
        <div class="logo">
            <img src="/public/hatvang/assets/img/logo-hatvang.png" alt="Hat Vang Logo">
        </div>
        <div class="menu-main">
            <a href="/trang-chu">Trang chủ</a>
            <div class="dropdown">
                <a href="/san-pham">Sản phẩm</a>
                <div class="dropdown-content">
                    <?=$dataHeader ?? []?>
                </div>
            </div>
            <a href="/bai-viet">Bài viết</a>
            <a href="/gioi-thieu">Giới thiệu</a>
            <a href="/lien-he">Liên hệ</a>
        </div>
        <div class="menu-secondary mr-20">
            <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="#" class="icon-menu">
                <span class="span-icon">0</span>
                <i class="fa-regular fa-heart"></i>
            </a>
            <a href="/gio-hang" class="icon-menu">
                <span class="span-icon" id="countCart">
                    <?=isset($dataCart['cart']) ? count($dataCart['cart']) : 0?>
                </span>
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <div class="dropdown">
                <a href="#"><i class="fa-regular fa-user"></i></a>
                <div class="dropdown-content">
                    <?php
                    if(isset($_SESSION['user'])){
                        echo '<a href="/dang-xuat">Đăng xuất</a>';
                    } else {
                        echo '<a href="/dang-nhap">Đăng nhập</a>';
                    }
                    ?>
                    <a href="/thong-tin-ca-nhan">Thông tin cá nhân</a>
                    <a href="/cap-nhat-mat-khau">Cập nhật mật khẩu</a>
                    <a href="/cap-nhat-dia-chi">Cập nhật địa chỉ</a>
                    <a href="/don-hang">Đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
</header>