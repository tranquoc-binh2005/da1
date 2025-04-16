$(document).ready(function(){
    $('.banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false
    });
});

$(document).ready(function(){
    $('.product-carousel').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
        dots: false,
    });
});

$(document).ready(function(){
    $('.related-product').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false
    });
});
$('.article-slider').slick({
    slidesToShow: 3, // Hiển thị 3 bài viết cùng lúc
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    arrows: false, // Ẩn mũi tên điều hướng
});
