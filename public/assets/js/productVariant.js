let getHtml = (units = [], existingUnits = []) => {
    // Filter out already selected units
    let availableUnits = units.filter(unit => !existingUnits.includes(unit.id));
    let unitOptions = availableUnits.map(unit => `<option value="${unit.id}">${unit.value}${unit.unit}</option>`).join('');

    return `<div class="variant-item col-md-12 row">
                <div class="col-md-3">
                    <label for="unit" class="col-form-label">Khối lượng</label>
                    <select class="form-control unit-select" name="unit_id[]" id="unit">
                        <option value="">Chọn đơn vị</option>
                        ${unitOptions}
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="price" class="col-form-label">Giá</label>
                    <input type="text" class="form-control" name="price[]" id="price">
                </div>
                
                <div class="col-md-2">
                    <label for="stock" class="col-form-label">Số lượng</label>
                    <input type="text" class="form-control" name="stock[]" id="stock">
                </div>

                <div class="col-md-4">
                    <label for="sku" class="col-form-label">SKU</label>
                    <input type="text" class="form-control sku-input" name="sku[]" id="sku">
                </div>

                <div class="col-md-1">
                    <label for="sku" class="col-form-label"> &nbsp; </label>
                    <button type="button" class="form-control block btn-trash-product-variant">
                        <li class="la la-trash"></li>
                    </button>
                </div>
            </div>`;
};

const generateSku = (productName, unitValue) => {

    let sku = productName.toUpperCase().replace(/\s+/g, '');
    if (unitValue) {
        sku += unitValue.toUpperCase();
    }

    return sku;
};

const addTemplateProductVariant = () => {
    $('.btn-add-variant-product').on('click', function () {
        // Lấy danh sách các unit_id đã được chọn từ các select hiện tại
        let selectedUnits = [];
        $('.variant-item').each(function() {
            let unitId = $(this).find('select[name="unit_id[]"]').val();
            if (unitId) {
                selectedUnits.push(unitId);
            }
        });

        $.ajax({
            url: '/ajax/getAllUnitProduct',
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    // Tính tổng số unit còn lại
                    let totalUnits = res.unitIds.length;
                    let currentSelects = $('.variant-item').length;

                    if (currentSelects >= totalUnits) {
                        $('.btn-add-variant-product').hide();
                        return;
                    }

                    $('.btn-add-variant-product').data('total-units', totalUnits);

                    // Tạo HTML cho phần tử mới với danh sách unit còn lại
                    const newHtml = getHtml(res.unitIds, selectedUnits);

                    // Thêm phần tử mới vào container
                    $('#unitContainer').append(newHtml);

                    // Cập nhật lại trạng thái disable của các option
                    updateDisabledOptions();
                } else {
                    console.error("Lỗi từ server:", res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
                console.log(xhr.responseText);
            }
        });
    });
};

const updateDisabledOptions = () => {
    // Lấy tất cả unit đã được chọn (bao gồm cả từ database)
    let selectedUnits = [];
    $('.variant-item').each(function() {
        let unitId = $(this).find('select[name="unit_id[]"]').val();
        if (unitId) {
            selectedUnits.push(unitId);
        }
    });

    $('.unit-select').each(function () {
        let currentSelect = $(this);
        let currentValue = currentSelect.val();

        currentSelect.find('option').each(function () {
            let optionValue = $(this).val();
            // Nếu option đã được chọn ở select khác và không phải là giá trị hiện tại của select này
            if (selectedUnits.includes(optionValue) && optionValue !== currentValue && optionValue !== "") {
                $(this).attr('disabled', true);
            } else {
                $(this).removeAttr('disabled');
            }
        });
    });

    // Kiểm tra số lượng select trong DOM
    let totalUnits = $('.btn-add-variant-product').data('total-units');
    let currentSelects = $('.variant-item').length;
    
    if (currentSelects >= totalUnits) {
        $('.btn-add-variant-product').hide();
    } else {
        $('.btn-add-variant-product').show();
    }
};

const removeTemplateProductVariant = () => {
    $(document).on('click', '.btn-trash-product-variant', function () {
        $(this).closest('.variant-item').remove();
        updateDisabledOptions();
    });
};

// Thêm sự kiện khi thay đổi unit hoặc tên sản phẩm
const initSkuGeneration = () => {
    // Lấy tên sản phẩm từ input
    const productNameInput = $('input[name="name"]');
    
    // Xử lý khi thay đổi unit
    $(document).on('change', '.unit-select', function() {
        let productName = productNameInput.val();
        let selectedOption = $(this).find('option:selected');
        let unitValue = selectedOption.text().replace('Chọn đơn vị', '').trim();
        
        let sku = generateSku(productName, unitValue);
        $(this).closest('.variant-item').find('.sku-input').val(sku);
    });

    // Xử lý khi thay đổi tên sản phẩm
    productNameInput.on('input', function() {
        let productName = $(this).val();
        $('.unit-select').each(function() {
            let selectedOption = $(this).find('option:selected');
            let unitValue = selectedOption.text().replace('Chọn đơn vị', '').trim();
            
            let sku = generateSku(productName, unitValue);
            $(this).closest('.variant-item').find('.sku-input').val(sku);
        });
    });
};

$(document).ready(function () {
    addTemplateProductVariant();
    removeTemplateProductVariant();
    updateDisabledOptions();
    initSkuGeneration();
});
