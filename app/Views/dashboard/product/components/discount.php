<div class="ibox-content">
    <div class="" id="discountContainer">
        <?php if(!empty($product['discount']) || !empty(old('discount'))){?>
            <div class="discount-item col-md-12 row">
                <div class="col-md-3">
                    <label for="discount" class="col-form-label">Giá trị giảm giá (%)</label>
                    <input type="number" id="discount" value="<?=isset($product) ? $product['discount'] : (old('discount'))?>" class="form-control" name="discount">
                </div>

                <div class="col-md-4">
                    <label for="start_date" class="col-form-label">Ngày bắt đầu</label>
                    <input type="date" id="start_date" value="<?=isset($product) ? $product['start_date'] : (old('start_date'))?>" class="form-control" name="start_date">
                </div>

                <div class="col-md-4">
                    <label for="end_date" class="col-form-label">Ngày kết thúc</label>
                    <input type="date" id="end_date" value="<?=isset($product) ? $product['end_date'] : (old('end_date'))?>" class="form-control" name="end_date">
                </div>

                <div class="col-md-1">
                    <label for="sku" class="col-form-label"> &nbsp; </label>
                    <button type="button" class="form-control block btn-trash-product-discount">
                        <li class="la la-trash"></li>
                    </button>
                </div>
            </div>
        <?php } else {?>
        <p class="text-center font-20">Chưa có giảm giá cho sản phẩm</p>
        <?php }?>
    </div>
    <div class="col-md-12 text-right mb-0 mt-2 pr-30">
        <br>
        <button type="button" class="btn btn-success waves-effect waves-light btn-add-discount-product" id="addDiscountBtn">Thêm giảm giá</button>
    </div>
</div>
