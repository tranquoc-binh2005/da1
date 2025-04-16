<div class="ibox-content">
    <div class="product-variant" id="unitContainer">
        <?php
        $unitIds = isset($units) && !empty($units) ? $units : [];

        if (empty($unitIds)) {
            $oldVariantIds = old('variant_id', []);
            $oldUnitIds = old('unit_id', []);
            $oldSkus = old('sku', []);
            $oldPrices = old('price', []);
            $oldStocks = old('stock', []);

            if (!empty($oldUnitIds)) {
                foreach ($oldUnitIds as $index => $unitId) {
                    $unitIds[] = [
                        'variant_id' => $oldVariantIds,
                        'unit_id' => $unitId,
                        'sku' => $oldSkus[$index] ?? '',
                        'price' => $oldPrices[$index] ?? '',
                        'stock' => $oldStocks[$index] ?? '',
                    ];
                }
            }
        }

        foreach ($unitIds as $variant):
            ?>
            <div class="col-md-12 row variant-item">
                <div class="col-md-3">
                    <label for="unit" class="col-form-label">Khối lượng</label>
                    <select class="form-control" name="unit_id[]" id="unit">
                        <?php foreach ($unit_products as $unit_product): ?>
                            <option value="<?=$unit_product['id']?>" <?= $unit_product['id'] == $variant['unit_id'] ? 'selected' : '' ?>><?=$unit_product['value'] . $unit_product['unit']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" class="form-control" name="variant_id[]" id="variant_id" value="<?= ($variant['id']) ?? null ?>">

                <div class="col-md-2">
                    <label for="price" class="col-form-label">Giá</label>
                    <input type="text" class="form-control" name="price[]" id="price" value="<?= ($variant['price']) ?>">
                </div>

                <div class="col-md-2">
                    <label for="stock" class="col-form-label">Số lượng</label>
                    <input type="text" class="form-control" name="stock[]" id="stock" value="<?= $variant['stock'] ?>">
                </div>

                <div class="col-md-4">
                    <label for="sku" class="col-form-label">SKU</label>
                    <input type="text" class="form-control" name="sku[]" id="sku" value="<?= ($variant['sku']) ?>">
                </div>

                <div class="col-md-1">
                    <label for="sku" class="col-form-label"> &nbsp; </label>
                    <button type="button" class="form-control block btn-trash-product-variant">
                        <li class="la la-trash"></li>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="col-md-12 text-right mb-0 mt-2 pr-30">
        <br>
        <button type="button" class="btn btn-info waves-effect waves-light btn-add-variant-product" id="addVariantBtn">Thêm biến thể</button>
    </div>
</div>
