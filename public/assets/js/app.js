document.addEventListener('DOMContentLoaded', function () {
    const elems = Array.prototype.slice.call(document.querySelectorAll('input[data-plugin="switchery"]'));
    elems.forEach(function (html) {
        const color = html.getAttribute('data-color');
        const size = html.getAttribute('data-size');
        new Switchery(html, {
            color: color,
            size: size
        });
    });
});

$(document).ready(function () {
    $('#datatable-buttons').DataTable({
        dom: 'Bfrtip',
        paging: false,
        searching: false,
        info: false,
        buttons: [
            {
                extend: 'print',
                text: 'In',
                className: 'btn btn-danger'
            },
            {
                extend: 'pdfHtml5',
                text: 'Xuất PDF',
                className: 'btn btn-success'
            }
        ]
    });
});