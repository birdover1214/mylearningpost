$(function() {
    $('.btn-dropdown').on('click', function(e) {
        e.preventDefault();
        $('.navbar-dropdown').toggleClass('open');
    });
});