<div class="container settings mt-20">
    <div class="sidebar-setting">
        <a href="?page=profiles">Thông tin cá nhân</a>
        <a href="?page=password">Đổi mật khẩu</a>
        <a href="?page=address">Địa chỉ giao hàng</a>
    </div>

    <div class="wrapper-container" id="wrapper-container">
        <?php
        $page = $_GET['page'] ?? 'profiles';

        switch ($page) {
            case 'dashboard':
                echo '<h2>Bảng điều khiển</h2><p>Thông tin tổng quan hệ thống.</p>';
                break;
            case 'address':
                include 'component/address.php';
                break;
            case 'profiles':
                include 'component/profile.php';
                break;
            case 'password':
                include 'component/changePassword.php';
                break;
            default:
                include 'component/profile.php';
                break;
        }
        ?>
    </div>
</div>