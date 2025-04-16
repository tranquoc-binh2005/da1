<?php
function withInput(array $params = []): void
{
    if(count($params)) {
        foreach ($params as $key => $input) {
            $_SESSION['old'][$key] = $input;
        }
    }
}

function old(string $key = ''): array|string
{
    return $_SESSION['old'][$key] ?? '';
}

function clearOldInput(array $keys = []): void
{
    foreach ($keys as $key) {
        unset($_SESSION['old'][$key]);
    }
}

function redirect(string $type = '', string $title = '', string $text = '', string $path = ''): void
{
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "' . $type . '",
                    title: "' . $title . '",
                    text: "' . $text . '"
                }).then(function() {
                    window.location.href = "' . $path . '";
                });
            });
            </script>';
}


function formatPhoneToVN($phone): string|array|null
{
    $digits = preg_replace('/\D/', '', $phone);

    if (strpos($digits, '0') === 0) {
        $formatted = '(+84) ' . substr($digits, 1);
    } else {
        $formatted = $digits;
    }

    return $formatted;
}


function formatCurrencyVN($number): string
{
    return number_format((float) ($number ?? 0), 0, ',', '.') . '₫';
}

function formatDateTimeVN(string $datetime): string
{
    $date = new DateTime($datetime);
    return $date->format('H:i:s d-m-Y');
}

