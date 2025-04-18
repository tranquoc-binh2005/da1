<div class="password-change-container">
    <h2 class="form-title">Đổi Mật Khẩu</h2>
    <form class="password-form">
        <div class="input-group">
            <label class="input-label" for="current-password">Mật khẩu hiện tại</label>
            <div class="input-wrapper">
                <input class="password-input" type="password" id="current-password" required autocomplete="current-password">
                <i class="fa-solid fa-eye toggle-password" data-target="current-password"></i>
            </div>
            <span class="error-message error-message-current-password"></span>
        </div>

        <div class="input-group">
            <label class="input-label" for="new-password">Mật khẩu mới</label>
            <div class="input-wrapper">
                <input class="password-input" type="password" id="new-password" required autocomplete="new-password">
                <i class="fa-solid fa-eye toggle-password" data-target="new-password"></i>
            </div>
            <span class="error-message error-message-new-password"></span>
        </div>

        <div class="input-group">
            <label class="input-label" for="confirm-password">Xác nhận mật khẩu mới</label>
            <div class="input-wrapper">
                <input class="password-input" type="password" id="confirm-password" required autocomplete="new-password">
                <i class="fa-solid fa-eye toggle-password" data-target="confirm-password"></i>
            </div>
            <span class="error-message error-message-confirm-password"></span>
        </div>

        <button class="submit-button-reset-password" type="button">Đổi Mật Khẩu</button>
    </form>
</div>

<script>
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const inputId = this.getAttribute('data-target');
            const inputField = document.getElementById(inputId);

            if (inputField.type === 'password') {
                inputField.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                inputField.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

</script>