$(function () {
    $(document).on('click', '.toggle-book-now', function (e) {
        var id = $(this).data('id');
        $('#product-'+id).submit();
    });
});