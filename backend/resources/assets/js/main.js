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

    //「投稿する」ボタンを押したら新規投稿フォーム出現
    $('#form-post-btn').on('click', function() {
        $('.main-container').toggleClass('slide');

        //「投稿する」ボタンの文章を切り替え
        if($('#form-post-btn').text() === "投稿する") {
            $('#form-post-btn').text('閉じる');
        }else if($('#form-post-btn').text() === "編集をやめる") {
            //編集モードから新規投稿モードに切り替える
            //編集中用のテキスト非表示
            $('.edit-post-text').removeClass('edit');

            //投稿フォームの中身を変更
            $('#time').val('');
            $('#comment').val('');

            //is_errorクラスが付与されたエラー項目からis_errorクラスを取り除き、displayの値をnoneに戻す
            $('.error-field:has(.is_error)').css('display', 'none');
            $('.is_error').text('');
            $('.is_error').removeClass('is_error');

            //新規投稿用のボタンに置き換える
            $('#edit-post').css('display', 'none');
            $('#submit-post').css('display', 'block');
            
            $('#form-post-btn').text('投稿する');
        }else {
            $('#form-post-btn').text('投稿する');
        }
    });


    //投稿一覧の機能ボタンを押した際の処理
    $('.post-config-wrap').on('click', function() {
        //何番目の機能ボタンが押されたか取得
        const index = $('ul .post-config-wrap').index(this);

        $('ul .post-config-wrap').eq(index).toggleClass('open');

        if($('ul .post-config-contents').eq(index).css('display') === 'none') {
            $('ul .post-config-contents').eq(index).css('display', 'block');
        }else {
            $('ul .post-config-contents').eq(index).css('display', 'none');
        }
    });


    //いいねボタンを押した際の処理
    $('.attach-favorite').on('click', function() {
        //何番目が押されたか取得
        const index = $('ul .attach-favorite').index(this);
        //投稿idを取得
        const postId = $(this).data('id');

        let sendData = new FormData();
        sendData.append('id', postId);

        $.ajax({
            url: '/favorite/attach',
            type: 'POST',
            data: sendData,
        })
        .done(function(response) {
            //ボタンの切り替え
            $('ul .attach-favorite').eq(index).css('display', 'none');
            $('ul .detach-favorite').eq(index).css('display', 'inline');
            $('ul .favorites-counter').eq(index).text(response.count)
        })
        .fail(function(response) {
            alert('通信に失敗しました');
        })

    });

    //いいね取り消しボタンを押した際の処理
    $('.detach-favorite').on('click', function() {
        //何番目が押されたか取得
        const index = $('ul .detach-favorite').index(this);
        //投稿idを取得
        const postId = $(this).data('id');

        let sendData = new FormData();
        sendData.append('id', postId);

        $.ajax({
            url: '/favorite/detach',
            type: 'POST',
            data: sendData,
        })
        .done(function(response) {
            //ボタンの切り替え
            $('ul .detach-favorite').eq(index).css('display', 'none');
            $('ul .attach-favorite').eq(index).css('display', 'inline');
            $('ul .favorites-counter').eq(index).text(response.count)
        })
        .fail(function(response) {
            alert('通信に失敗しました');
        })

    });


    //新規投稿処理
    $('#submit-post').on('click', function(e) {
        e.preventDefault();

        //送信先URLの設定
        const url = '/create';
        //バリデーション・送信処理
        dataPost(url);
    });

    //編集ボタンを押した際の処理
    $('.post-edit-btn').on('click', function() {

        const index = $('ul .post-edit-btn').index(this);

        $('ul .post-config-wrap').eq(index).toggleClass('open');
        $('ul .post-config-contents').eq(index).css('display', 'none');

        const postId = $(this).data('id');
        
        let sendData = new FormData();
        sendData.append('id', postId);

        $.ajax({
            url: '/getid',
            type: 'POST',
            data: sendData,
        })
        .done(function(response) {
            //投稿フォームを開いてボタンテキストを変更
            $('.main-container').addClass('slide');
            $('#form-post-btn').text('編集をやめる');
            //編集中用のテキスト表示
            $('.edit-post-text').addClass('edit');

            //投稿フォームの中身を変更
            $('#skill').val(response.postData.skill_id);
            $('#time').val(response.postData.time);
            $('#comment').val(response.postData.comment);

            //編集用のボタンに置き換える
            $('#submit-post').css('display', 'none');
            $('#edit-post').css('display', 'block');
            $('#edit-post').attr('data-edit', postId);
        })
        .fail(function(response) {
            alert('データの取得に失敗しました');
        })
    })

    //編集後の送信処理
    $('#edit-post').on('click', function(e) {
        e.preventDefault();

        //編集した投稿データのidを取得
        const postId = $(this).data('edit');

        //送信先URLの設定
        const url = '/edit';

        //バリデーション・送信処理
        dataPost(url, postId);
    })

    //バリデーション・送信処理
    function dataPost(url, postId) {

        //is_errorクラスが付与されたエラー項目からis_errorクラスを取り除き、displayの値をnoneに戻す
        $('.error-field:has(.is_error)').css('display', 'none');
        $('.is_error').text('');
        $('.is_error').removeClass('is_error');

        //バリデーション処理
        //エラー数格納用変数の初期化
        let errorCount = 0;
        //エラーの種類を格納する配列の初期化
        let errorType = [];
        
        //time
        const postTime = $('#time').val();
        //未入力や、0以下または24*60よりも大きい値の場合エラー
        if(!postTime) {
            errorCount++;
            errorType.push('timeRequired');
        }else if(postTime <= 0) {
            errorCount++;
            errorType.push('timeMin');
        }else if(postTime > 24*60) {
            errorCount++;
            errorType.push('timeMax');
        }

        //comment
        const postComment = $('#comment').val();
        //未入力または100文字以上でエラー
        if(!postComment) {
            errorCount++;
            errorType.push('commentRequired');
        }else if(postComment.length > 100) {
            errorCount++;
            errorType.push('commentLength');
        }

        if(errorCount > 0) {
            //エラーメッセージの表示
            //time
            if($.inArray('timeRequired', errorType) !== -1) {
                $('.time-error').addClass('is_error');
                $('#time').addClass('is_error');
                $('.time-error').text('※ 時間を入力してください');
            }else if($.inArray('timeMin', errorType) !== -1) {
                $('.time-error').addClass('is_error');
                $('#time').addClass('is_error');
                $('.time-error').text('※ 時間は1以上で入力してください');
            }else if($.inArray('timeMax', errorType) !== -1) {
                $('.time-error').addClass('is_error');
                $('#time').addClass('is_error');
                $('.time-error').text('※ 1日分以上の値は入力できません');
            }

            if($.inArray('commentRequired', errorType) !== -1) {
                $('.comment-error').addClass('is_error');
                $('#comment').addClass('is_error');
                $('.comment-error').text('※ この項目は必須入力です');
            }else if($.inArray('commentLength', errorType) !== -1) {
                $('.comment-error').addClass('is_error');
                $('#comment').addClass('is_error');
                $('.comment-error').text('※ 100文字以内で入力してください');
            }

            //is_errorクラスが付与されたエラー項目にエラーメッセージを表示
            $('.error-field:has(.is_error)').css('display', 'block');

        }else {

            //フォームに入力されているデータを全て取得
            const formData = $('#form-post').serializeArray();
    
            //送信用のFormData作成
            let sendData = new FormData();

            //編集の場合はidを挿入
            if(postId) {
                //console.log(postId)
                sendData.append('id', postId);
            }
    
            //全てのデータ挿入
            for(let i = 0; i < formData.length; i++) {
                sendData.append(formData[i].name, formData[i].value);
            }
    
            //ajax通信処理
            $.ajax({
                url: url,
                type: 'POST',
                data: sendData,
            })
            //成功時
            .done(function(response) {
                //console.log(data);
                location.reload();
            })
            //失敗時
            .fail(function(response) {
                //Laravel側のバリデーションエラー
                if(response.status === 422) {
                    //エラーメッセージを表示する
                    if(response.responseJSON.errors.skill) {
                        $('.select-error').addClass('is_error');
                        $('#skill').addClass('is_error');
                        $('.select-error').text(response.responseJSON.errors.skill);        
                    }

                    if(response.responseJSON.errors.time) {
                        $('.time-error').addClass('is_error');
                        $('#time').addClass('is_error');
                        $('.time-error').text(response.responseJSON.errors.time);
                    }

                    if(response.responseJSON.errors.comment) {
                        $('.comment-error').addClass('is_error');
                        $('#comment').addClass('is_error');
                        $('.comment-error').text(response.responseJSON.errors.comment);
                    }

                    //is_errorクラスが付与されたエラー項目にエラーメッセージを表示
                    $('.error-field:has(.is_error)').css('display', 'block');

                }else {
                    console.log(response)
                    $('.select-error').addClass('is_error');
                    $('#skill').addClass('is_error');
                    $('.select-error').text('※ 投稿処理に失敗しました');

                    //is_errorクラスが付与されたエラー項目にエラーメッセージを表示
                    $('.error-field:has(.is_error)').css('display', 'block');
                }
            });
        }
    }
})