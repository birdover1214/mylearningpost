$(function () {
    $('.checkbox-content').on('click', function() {
        const checked_length = $('input:checked').length;
        // 選択上限は10個まで
        if (checked_length > 9) {
            $('.checkbox-content:not(:checked)').prop('disabled', true);
        } else {
            $('.checkbox-content:not(:checked)').prop('disabled', false);
        }
    });
});