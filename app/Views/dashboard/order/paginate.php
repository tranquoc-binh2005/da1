<?php
$query = $_GET;
unset($query['page']);
$queryString = http_build_query($query);
$queryString = $queryString ? $queryString . '&' : '';

$totalPages = $orders['total_pages'];
$currentPage = $orders['current_page'];
?>

<ul class="pagination pagination-rounded text-right">
    <li class="paginate_button page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
        <a href="/dashboard/orders/index?<?= $queryString ?>page=<?= max(1, $currentPage - 1) ?>" class="page-link">
            <i class="mdi mdi-chevron-left"></i>
        </a>
    </li>

    <?php
    echo '<li class="paginate_button page-item ' . ($currentPage == 1 ? 'active' : '') . '">
            <a href="/dashboard/orders/index?' . $queryString . 'page=1" class="page-link">1</a>
          </li>';

    if ($currentPage > 4) {
        echo '<li class="paginate_button page-item disabled"><span class="page-link">...</span></li>';
    }

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
        echo '<li class="paginate_button page-item ' . ($currentPage == $i ? 'active' : '') . '">
                <a href="/dashboard/orders/index?' . $queryString . 'page=' . $i . '" class="page-link">' . $i . '</a>
              </li>';
    }

    if ($currentPage < $totalPages - 3) {
        echo '<li class="paginate_button page-item disabled"><span class="page-link">...</span></li>';
    }

    if ($totalPages > 1) {
        echo '<li class="paginate_button page-item ' . ($currentPage == $totalPages ? 'active' : '') . '">
                <a href="/dashboard/orders/index?' . $queryString . 'page=' . $totalPages . '" class="page-link">' . $totalPages . '</a>
              </li>';
    }
    ?>

    <li class="paginate_button page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
        <a href="/dashboard/orders/index?<?= $queryString ?>page=<?= min($totalPages, $currentPage + 1) ?>" class="page-link">
            <i class="mdi mdi-chevron-right"></i>
        </a>
    </li>
</ul>
