$(function () {
    $(document).on('click', '.toggle-book-now', function (e) {
        var id = $(this).data('id');
        $('#product-'+id).submit();
    });

    $(document).on('click', '.item a', function (e) {
        var name = $(this).data('name');
        $('#filter-wrapper .item').removeClass('active-2');
        $('#filter-wrapper .item').addClass('not-active');
        $('#filter-wrapper .item').removeClass('active-2-mobile');
        $('#filter-wrapper .item').addClass('not-active-2-mobile');

        $(this).parent().addClass('active-2');
        $(this).parent().removeClass('not-active');
        $(this).parent().addClass('active-2-mobile');
        $(this).parent().removeClass('not-active-2-mobile');

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

    $(document).on('click', '.dropdown-item', function (e) {
        var _type = $(this).data('type');
        var _value = $(this).data('value');

        $.ajax({
            url: '/search/filter/' + _type + '/' + _value,
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