$(function () {
    $(document).on('click', '.toggle-book-now', function (e) {
        var id = $(this).data('id');
        $('#product-'+id).submit();
    });

    $(document).on('click', '.nav-item a', function (e) {
        var name = $(this).data('name');
        $('#filter-wrapper .nav-item').removeClass('active-2');
        $('#filter-wrapper .nav-item').addClass('not-active');

        $(this).parent().addClass('active-2');
        $(this).parent().removeClass('not-active');

        $.ajax({
            url: '/filter/search/' + name,
            type: 'post',
            data: { _token: $('#token').val(), data: $('#search-form').serialize() },
            dataType: 'json',
            beforeSend: function () {
                $('#cards-container').html("<div class='col-md-12 text-center'><img src='/img/loader.gif'></div>");
            },
            success: function (response) {
                $('#cards-container').html(response.html);
            }
        });
    });
});