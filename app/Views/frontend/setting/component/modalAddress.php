<div class="address-modal" id="addressModal">
    <div class="address-modal-content">
        <div class="address-modal-title">Thêm địa chỉ mới</div>
        <form>
            <input type="hidden" id="addressId" value="" />
            <div class="form-group">
                <label for="fullName">Họ và tên</label>
                <input type="text" id="fullName" class="address-shopping-name" placeholder="Nhập họ và tên" />
                <span class="text-danger error-message-name"></span>
            </div>
            <div class="form-group mt-20">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" class="address-shopping-phone" placeholder="Nhập số điện thoại" />
                <span class="text-danger error-message-phone"></span>
            </div>
            <div class="form-group mt-20">
                <label for="address">Địa chỉ</label>
                <textarea id="address" cols="5" class="address-shopping-address" rows="5"></textarea>
                <span class="text-danger error-message-address"></span>
            </div>
            <div class="mt-20">
                <input type="checkbox" id="add-default" class="address-shopping-isDefault"/>
                <label for="add-default">Đặt làm địa chỉ mặc định</label>
            </div>
            <div class="modal-actions mt-20">
                <button type="button" class="btn-cancel" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn-save btn-save-address-shopping">Lưu</button>
            </div>
        </form>
    </div>
</div>