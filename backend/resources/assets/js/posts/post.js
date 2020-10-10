$(function() {
    //ajax通信のセットアップ
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 10000,
    })

    //コメント送信処理
    $('#comment-btn').on('click', function(e) {
        e.preventDefault();

        $('.error-field').css('display', 'none');

        //バリデーション処理
        //エラー数格納用変数の初期化
        let errorCount = 0;
        //エラーの種類を格納する配列の初期化
        let errorType = [];
        
        //コメントのバリデーション
        const talkComment = $('#talks-comment').val();

        //未入力または100文字以上でエラー
        if(!talkComment) {
            errorCount++;
            errorType.push('commentRequired');
        }else if(talkComment.length > 100) {
            errorCount++;
            errorType.push('commentLength');
        }

        if(errorCount > 0) {
            //エラーメッセージの表示
            if($.inArray('commentRequired', errorType) !== -1) {
                $('.comment-error').addClass('is_error');
                $('#comment').addClass('is_error');
                $('.comment-error').text('※ コメントを入力してください');
            }else if($.inArray('commentLength', errorType) !== -1) {
                $('.comment-error').addClass('is_error');
                $('#comment').addClass('is_error');
                $('.comment-error').text('※ 100文字以内で入力してください');
            }

            $('.error-field').css('display', 'block');

        }else {

            //コメントする投稿のidを取得
            const postId = $('#talks-comment').data('postId');
            
            //送信用のFormData作成
            let sendData = new FormData();

            //送信するデータの挿入
            sendData.append('id', postId);
            sendData.append('comment', talkComment);
    
            //ajax通信処理
            $.ajax({
                url: '/talk/create',
                type: 'POST',
                data: sendData,
            })
            //成功時
            .done(function(data) {
                console.log(data);
                //location.reload();
            })
            //失敗時
            .fail(function(data) {
                console.log('fail')
            });
        }
    })
})