$(function() {
    $('.nav-dropdown').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('open');
    });
});