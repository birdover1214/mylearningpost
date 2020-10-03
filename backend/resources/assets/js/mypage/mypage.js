$(function() {
    //ajaxのセットアップ
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 10000,
        cache: false,
    });

    //画像のプレビュー処理
    $('#user_image').on('change', function(e) {
        const previewField = $('.user-image');

        if(e.target.files.length) {
            const reader = new FileReader;
            reader.onload = function(e) {
                previewField.attr('src', e.target.result);
            }

            return reader.readAsDataURL(e.target.files[0]);
        }
    });

    //画像の送信処理
    $('.submit-image').on('click', function(e) {
        e.preventDefault();
        //画像データを受け取る
        const file = document.getElementById('user_image').files[0];
        const userImageData = new FormData();
        userImageData.append("user_image", file);
        
        //画像の送信
        $.ajax({
            url: "/mypage",
            type: "POST",
            data: userImageData,
            contentType: false,
            processData: false,
            dataType: "html"
        }).done(function(data){
            alert("プロフィール画像を変更しました。");
        }).fail(function(data) {
            alert("画像の更新に失敗しました。");
        })
    })
})