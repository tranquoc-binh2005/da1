<?php
namespace App\Traits;
trait HasAlert
{

    private function import(): void
    {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    }
    protected function with(string $type = '', string $title = '', string $message = ''): void
    {
        $this->import();
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "' . $type . '",
                    title: "' . $title . '",
                    text: "' . $message . '"
                })
            });
        </script>';
    }

    function alertSuccess($title, $text, $path)
    {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "' . $title . '",
                    text: "' . $text . '"
                }).then(function() {
                    window.location.href = "' . $path . '";
                });
            });
            </script>';
    }

    function alertSuccessNotRender($title, $text)
    {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "' . $title . '",
                    text: "' . $text . '"
                });
            });
            </script>';
    }

    function dialogShowSuccessAddCart($title, $nameProduct, $pathImg, $pathPre, $pathBack)
    {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
    Swal.fire({
        title: "' . $title . '",
        html: `
          <img src="/php2/Public/Image/' . $pathImg . '" alt="Product Image" style="width:100px;height:100px;">
          <h2>' . $nameProduct . '</h2>
        `,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xem giỏ hàng",
        cancelButtonText: "Tiếp tục mua sắm"
      }).then((result) => {
        if (result.isConfirmed) {
          // Action for "Continue Shopping"
          console.log("Continue Shopping");
          // For example, redirect to another page
          window.location.href = "' . $pathPre . '";
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          // Action for "View Cart"
          console.log("View Cart");
          // For example, redirect to the cart page
          window.location.href = "' . $pathBack . '";
        }
      });
          </script>';
    }
    function alertError($title, $text, $path)
    {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "' . $title . '",
                text: "' . $text . '"
            }).then(function() {
                window.location.href = "' . $path . '";
            });
        });
        </script>';
    }

//    function delete($title, $text, $deleteUrl, $backUrl)
//    {
//        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
//        echo '<script>
//                document.addEventListener("DOMContentLoaded", function() {
//                    Swal.fire({
//                        title: "' . $title . '",
//                        text: "' . $text . '",
//                        icon: "warning",
//                        showCancelButton: true,
//                        confirmButtonColor: "#3085d6",
//                        cancelButtonColor: "#d33",
//                        confirmButtonText: "Đúng, xoá nó!",
//                        cancelButtonText: "Hủy"
//                    }).then((result) => {
//                        if (result.isConfirmed) {
//                            window.location.href = "' . $deleteUrl . '";
//                        } else {
//                            window.location.href = "' . $backUrl . '";
//                        }
//                    });
//                });
//              </script>';
//    }
//
//    function update($title, $text, $updateUrl, $backUrl)
//    {
//        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
//        echo '<script>
//                document.addEventListener("DOMContentLoaded", function() {
//                    Swal.fire({
//                        title: "' . $title . '",
//                        text: "' . $text . '",
//                        icon: "question",
//                        showCancelButton: true,
//                        confirmButtonColor: "#3085d6",
//                        cancelButtonColor: "#d33",
//                        confirmButtonText: "Đúng !",
//                        cancelButtonText: "Hủy"
//                    }).then((result) => {
//                        if (result.isConfirmed) {
//                            window.location.href = "' . $updateUrl . '";
//                        } else {
//                            window.location.href = "' . $backUrl . '";
//                        }
//                    });
//                });
//              </script>';
//    }

}