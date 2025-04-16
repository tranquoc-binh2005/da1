<div class="address-container container">
    <div class="address-header">
        <h1 class="address-title">Địa chỉ của tôi</h1>
        <button class="address-btn-add" onclick="resetAndOpenModal()">+ Thêm địa chỉ mới</button>
    </div>

    <div class="main-address-container">
        <?php foreach ($dataAddressShopping as $val):?>
            <div class="address-item">
                <div class="address-name">
                    <?=$val['name']?>
                    <?php if ($val['isDefault'] === 1): ?>
                        <span class="address-default">Mặc định</span>
                    <?php endif; ?>
                </div>
                <div class="address-detail address-detail-address"><?=$val['address']?></div>
                <div class="address-detail address-detail-phone"><?=$val['phone']?></div>
                <div class="address-actions">
                    <button data-id="<?=$val['id']?>" class="address-btn-update">Cập nhật</button>
                    <button data-id="<?=$val['id']?>" class="address-btn-delete">Xóa</button>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<?php include 'modalAddress.php'; ?>

<script>
    function resetAndOpenModal() {
        resetModalFields();
        $('#addressModal .address-modal-title').text('Thêm địa chỉ mới');
        openModal();
    }
</script>