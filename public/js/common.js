$(document).ready(function () {
    $(document).on('click', '.toggle-cancel', function () {
        var _url = $(this).data('back');
        window.location = _url;
    });
});
