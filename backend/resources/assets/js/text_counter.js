window.addEventListener('DOMContentLoaded', function() {
    const defaultCount = $('.input-textarea').val().length;
    $('.text-counter').text(defaultCount);
})

$(function() {
    $('.input-textarea').keyup(function() {
        let count = $(this).val().length;
        $('.text-counter').text(count);
    });
});