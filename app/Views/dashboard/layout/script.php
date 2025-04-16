<!-- Vendor js -->
<script src="public/assets/js/vendor.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="public/assets/libs/jquery-knob/jquery.knob.min.js"></script>

<!-- Switchery js -->
<script src="public/assets/libs/switchery/switchery.min.js"></script>


<!-- DataTables core -->
<script src="public/assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="public/assets/libs/datatables/dataTables.bootstrap4.js"></script>

<!-- Responsive -->
<script src="public/assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="public/assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<!-- Buttons -->
<script src="public/assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="public/assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="public/assets/libs/datatables/buttons.html5.min.js"></script>
<script src="public/assets/libs/datatables/buttons.print.min.js"></script>
<script src="public/assets/libs/datatables/buttons.flash.min.js"></script>

<!-- PDF generation -->
<script src="public/assets/libs/pdfmake/pdfmake.min.js"></script>
<script src="public/assets/libs/pdfmake/vfs_fonts.js"></script>



<!-- App js -->
<script src="public/assets/js/app.min.js"></script>
<script src="public/assets/js/seo.js"></script>
<script src="public/assets/js/setupSelectMultipleAlbum.js"></script>
<script src="public/assets/js/productVariant.js"></script>
<script src="public/assets/js/productDiscount.js"></script>
<script src="public/assets/js/modalProductVariant.js"></script>
<script src="public/assets/js/changeStatus.js"></script>
<script src="public/assets/js/app.js"></script>
<script src="public/assets/js/order.js"></script>


<!-- Ckfinder -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script src="public/assets/plugins/ckfinder/ckfinder.js"></script>
<script src="public/assets/js/configCkfinder.js"></script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = false;

    const pusher = new Pusher('4a687436f925f3d980e1', {
        cluster: 'ap1',
        encrypted: true,
    });

    let currentId = <?= $_SESSION['admin']['id'] ?? 0 ?>

    const channel = pusher.subscribe('logout-force');

    channel.bind('new-logout-force', function(data) {
        if (parseInt(data.admin_id) === currentId) {
            window.location.href = '/auth/revoke'
        }
    });
</script>