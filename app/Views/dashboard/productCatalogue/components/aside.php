<div class="form-group col-md-12">
    <label for="" class="col-form-label">Cấu hình nâng cao
        <span class="text-danger">*</span> <br>
    </label>
    <?php
    $status = [
        1 => "Xuất bản",
        2 => "Không xuất bản",
    ];
    ?>
    <select name="publish" class="form-control mb-2">
        <?php
        foreach ($status as $key => $value) {?>
            <option value="<?=$key?>" <?= isset($productCatalogue) && $productCatalogue['publish'] == $key ? 'selected' : ''?>>
                <?=$value?>
            </option>
        <?php } ?>
    </select>
</div>
