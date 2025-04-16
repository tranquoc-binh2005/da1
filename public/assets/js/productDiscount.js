const getHtmlDiscount = () => `
    <div class="discount-item col-md-12 row">
        <div class="col-md-3">
            <label for="discount" class="col-form-label">Giá trị giảm giá (%)</label>
            <input type="number" class="form-control" name="discount" required>
            <div class="invalid-feedback">Vui lòng nhập giá trị giảm giá</div>
        </div>
        <div class="col-md-4">
            <label for="start_date" class="col-form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="start_date" required>
            <div class="invalid-feedback">Vui lòng chọn ngày bắt đầu</div>
        </div>
        <div class="col-md-4">
            <label for="end_date" class="col-form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_date" required>
            <div class="invalid-feedback">Vui lòng chọn ngày kết thúc</div>
        </div>
        <div class="col-md-1">
            <label for="sku" class="col-form-label">&nbsp;</label>
            <button type="button" class="form-control block btn-trash-product-discount">
                <li class="la la-trash"></li>
            </button>
        </div>
    </div>`;

const checkDiscountForms = () => {
    const discountForms = $('.discount-item').length;
    $('#addDiscountBtn, #discountContainer p').toggle(discountForms === 0);
}

const validateDiscountForm = () => {
    let isValid = true;
    $('.discount-item').each(function() {
        const $inputs = $(this).find('input');
        const [discount, startDate, endDate] = $inputs.map((_, el) => $(el).val()).get();
        
        $inputs.toggleClass('is-invalid', !discount || !startDate || !endDate);
        
        if (startDate && endDate && startDate > endDate) {
            isValid = false;
            $(this).find('input[name="end_date"]')
                .addClass('is-invalid')
                .next('.invalid-feedback')
                .text('Ngày kết thúc phải sau ngày bắt đầu');
        }
    });
    return isValid;
}

const addTemplateProductDiscount = () => {
    $('.btn-add-discount-product').on('click', () => {
        $('#discountContainer').append(getHtmlDiscount());
        checkDiscountForms();
    });
};

$(document)
    .on('click', '.btn-trash-product-discount', function() {
        $(this).closest('.discount-item').remove();
        checkDiscountForms();
    })
    .on('submit', 'form', e => {
        if (!validateDiscountForm()) {
            e.preventDefault();
            return false;
        }
    })
    .ready(() => {
        addTemplateProductDiscount();
        checkDiscountForms();
    });
