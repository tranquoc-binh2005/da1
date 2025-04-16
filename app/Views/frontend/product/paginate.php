<?php
$query = $_GET;
$query['product_catalogue_id'] = $_GET['product_catalogue_id'] ?? '';
unset($query['page']);
$queryString = http_build_query($query);
$queryString = $queryString ? $queryString . '&' : '';
//print_r($queryString); die();

$totalPages = $products['total_pages'];
$currentPage = $products['current_page'];
?>

<div class="pagination">
    <!-- Previous Page Button -->
    <a href="/san-pham?<?= $queryString ?>page=<?= max(1, $currentPage - 1) ?>" class="page-number <?= $currentPage == 1 ? 'disabled' : '' ?>">
        &lt;
    </a>

    <!-- Page 1 Button -->
    <a href="/san-pham?<?= $queryString ?>page=1" class="page-number <?= $currentPage == 1 ? 'active' : '' ?>">1</a>

    <?php
    // Dấu "..." nếu cần thiết
    if ($currentPage > 4) {
        echo '<span class="dots">...</span>';
    }

    // Các số trang từ $start đến $end
    $start = max(2, $currentPage - 1);
    $end = min($totalPages - 1, $currentPage + 1);

    if ($currentPage <= 3) {
        $start = 2;
        $end = min(4, $totalPages - 1);
    }
    if ($currentPage >= $totalPages - 2) {
        $start = max(2, $totalPages - 3);
        $end = $totalPages - 1;
    }

    for ($i = $start; $i <= $end; $i++) {
        echo '<a href="/san-pham?' . $queryString . 'page=' . $i . '" class="page-number ' . ($currentPage == $i ? 'active' : '') . '">' . $i . '</a>';
    }

    // Dấu "..." nếu cần thiết
    if ($currentPage < $totalPages - 3) {
        echo '<span class="dots">...</span>';
    }

    // Trang cuối cùng
    if ($totalPages > 1) {
        echo '<a href="/san-pham?' . $queryString . 'page=' . $totalPages . '" class="page-number ' . ($currentPage == $totalPages ? 'active' : '') . '">' . $totalPages . '</a>';
    }
    ?>

    <!-- Next Page Button -->
    <a href="/san-pham?<?= $queryString ?>page=<?= min($totalPages, $currentPage + 1) ?>" class="page-number <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
        &gt;
    </a>
</div>
