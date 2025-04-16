const refreshSwitchery = () => {
    document.querySelectorAll('input[data-plugin="switchery"]').forEach(el => {
        if (el.switchery) {
            el.switchery.setPosition(); // Cập nhật lại trạng thái
        }
    });
};

// Gọi lại sau khi AJAX load xong
const showModalProductVariant = () => {
    $(document).on('click', '#btnShowModalProductVariant', function () {
        let _this = $(this);
        let productId = _this.attr('data-product');
        let productName = _this.attr('data-name');

        $.ajax({
            url: '/ajax/getVariantProductById',
            type: 'POST',
            data: { productId: productId },
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    let variants = res.variant;
                    if (typeof variants === 'string') {
                        variants = JSON.parse(variants);
                    }
                    $('#nameProductVariantModal').text(`Danh sách sản phẩm biến thể của: ` + productName)
                    let tbody = $('#tbody-product-variant');
                    tbody.empty();

                    if (Array.isArray(variants) && variants.length > 0) {
                        variants.forEach(variant => {
                            let row = `
                                <tr>
                                    <td class="text-center">${variant.unit_value + variant.unit_name}</td>
                                    <td width="500px">${variant.stock}</td>
                                    <td width="500px" class="text-left">${variant.price.toLocaleString()} đ</td>
                                    <td width="120px" class="text-center">${variant.sku}</td>
                                    <td width="100px" class="text-center">
                                        <input type="checkbox"
                                            ${variant.publish === 1 ? 'checked' : ''} 
                                            data-plugin="switchery"
                                            data-color="#64b0f2"
                                            data-size="small"
                                            class="changeStatusPublish"
                                            data-field="product_variants"
                                            data-id="${variant.id}"
                                            data-column="publish"
                                            data-publish="${variant.publish}">
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });

                        // Làm mới lại Switchery
                        refreshSwitchery();
                    } else {
                        tbody.html('<tr><td colspan="5" class="text-center">Chưa có biến thể nào.</td></tr>');
                    }

                    $('#variantProduct').modal('show');
                } else {
                    console.error("Lỗi: ", res.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
                console.log(xhr.responseText);
            }
        });
    });
}

$(document).ready(function() {
    showModalProductVariant();
});
