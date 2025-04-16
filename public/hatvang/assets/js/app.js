const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));
const normalizeString = (string) => {
    return string.normalize('NFD') // Chuyển đổi thành dạng phân tách dấu
        .replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu
        .replace(/[^a-zA-Z0-9\s]/g, '') // Loại bỏ ký tự không phải chữ cái và số
        .toLowerCase();
};

const formatCurrencyVN = (number) => {
    number = Number(number); // đảm bảo là kiểu số
    return number.toLocaleString('vi-VN') + '₫';
}

const filterOutstandingProductByCategories = () => {
    $(document).on('click', '.filter-product-by-category', function (e) {
        e.preventDefault();

        let categoryId = $(this).data('id');
        let url = window.location.pathname + '?product_catalogue_id=' + categoryId;

        $('.filter-product-by-category').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                let html = $(response).find('.product-grid').html();

                $('.product-grid').html(html);

                // window.history.pushState({}, '', url);
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    });
};

const filterOutstandingProductByCategoriesHomePage = () => {
    $(document).on('click', '.li-filter-product-by-category', async function (e) {
        e.preventDefault();

        $('.loader-container').show();
        let categoryId = $(this).data('id');
        let categoryName = $(this).data('name');

        $('.titleCategory').text(`Danh mục sản phẩm: ${categoryName}`);

        let url = new URL(window.location.href);

        url.searchParams.set('product_catalogue_id', categoryId);

        window.history.pushState({}, '', url);

        $('.li-filter-product-by-category').removeClass('active');
        $(this).addClass('active');

        loadProducts(url.toString());
    });
};


const filterProductByKeyword = () => {
    $(document).on('submit keyup', '.filter-search-product', async function (e) {
        e.preventDefault();

        let keyword = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('keyword', normalizeString(keyword));

        window.history.pushState({}, '', url);

        loadProducts(url.toString());
    });
};

const filterProductBySort = () => {
    $(document).on('change', '.filter-select-product', async function (e) {
        e.preventDefault();

        $('.loader-container').show();

        let option = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('sort', option);

        window.history.pushState({}, '', url);

        loadProducts(url.toString());
    });
};

const filterProductByPerpage = () => {
    $(document).on('change', '.filter-perpage-product', async function (e) {
        e.preventDefault();

        $('.loader-container').show();

        let perpage = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('perpage', perpage);

        window.history.pushState({}, '', url);

        loadProducts(url.toString());
    });
};

const loadProducts = (url) => {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        success: async function (response) {
            let html = $(response).find('.main-content-product').html();
            let paginationHtml = $(response).find('.pagination').html();

            await sleep(500);
            if (!html || html.trim() === '') {
                $('.main-content-product').html('<p>Không tìm thấy sản phẩm hợp lệ...</p>');
            } else {
                $('.main-content-product').html(html);
            }

            if (paginationHtml) {
                let $pagination = $('<div>' + paginationHtml + '</div>'); // Đưa vào DOM tạm

                const urlParams = new URLSearchParams(url.split('?')[1]);
                const categoryId = urlParams.get('product_catalogue_id');

                // Duyệt và sửa lại các link trong phân trang
                $pagination.find('a').each(function () {
                    let href = $(this).attr('href');
                    if (href) {
                        let newUrl = new URL(href, window.location.origin);
                        newUrl.searchParams.set('product_catalogue_id', categoryId);
                        $(this).attr('href', newUrl.pathname + '?' + newUrl.searchParams.toString());
                    }
                });
                $('.pagination').html($pagination.html());
            }

            window.history.pushState({}, '', url);
            $('.loader-container').hide();
        },
        error: function () {
            $('.loader-container').hide();
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
};

const handlePaginationAjax = () => {
    $(document).on('click', '.pagination a.page-number', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        if (!url || $(this).hasClass('disabled') || $(this).hasClass('active')) return;

        $('.loader-container').show();
        window.history.pushState({}, '', url);
        loadProducts(url);
    });
};

const syncFiltersWithUrl = () => {
    let url = new URL(window.location.href);
    let keyword = url.searchParams.get('keyword');
    let sort = url.searchParams.get('sort');
    let perpage = url.searchParams.get('perpage');
    let categoryId = url.searchParams.get('product_catalogue_id');

    if (keyword) $('.filter-search-product').val(keyword);

    if (sort) $('.filter-select-product').val(sort);

    if (perpage) $('.filter-perpage-product').val(perpage);

    if (categoryId) $(`.li-filter-product-by-category[data-id="${categoryId}"]`).addClass('active');
};

const handleResetFilter = () => {
    $(document).on('click', '.reset-filter-product', function (e) {
        e.preventDefault();
        const currentPath = window.location.pathname;
        window.history.pushState({}, '', currentPath);

        $('.filter-search-product').val('');
        $('.filter-select-product').val('');
        $('.filter-perpage-product').val('');
        $('.li-filter-product-by-category').removeClass('active');

        loadProducts(currentPath);
    });
};

$(document).ready(function () {
    filterOutstandingProductByCategories();
    filterOutstandingProductByCategoriesHomePage();
    handlePaginationAjax();
    filterProductByKeyword();
    filterProductBySort();
    filterProductByPerpage();
    syncFiltersWithUrl();
    handleResetFilter();
});
