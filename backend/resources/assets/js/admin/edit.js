$(function() {
    //プロフィール変更ボタンを押した際の処理
    $('#btn-edit').on('click', function(e) {
        e.preventDefault();

        //is_errorクラスが付与されたエラー項目からis_errorクラスを取り除き、displayの値をnoneに戻す
        $('.error-field:has(.is_error)').css('display', 'none');
        $('.is_error').text('');
        $('.is_error').removeClass('is_error');

        //バリデーション処理
        //エラー数格納用変数の初期化
        let errorCount = 0;
        //エラーの種類を格納する配列の初期化
        let errorType = [];

        //nameバリデーション
        const editName = $('#name').val();
        //未入力または20文字以上であればエラー
        if(!editName) {
            errorCount++;
            errorType.push('nameRequired');
        }else if(editName.length > 20) {
            errorCount++;
            errorType.push('nameMax');
        }

        //emailバリデーション
        const editEmail = $('#email').val();
        //正規表現
        const regex = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        //未入力または正規表現に合わなければエラー
        if(!editEmail.length) {
            crrorCount++;
            errorType.push('emailRequired');
        }else if(!editEmail.match(regex)) {
            errorCount++;
            errorType.push('emailRegex');
        }

        //passwordバリデーション
        const editPassword = $('#password').val();
        const editConfirmPassword = $('#password-confirm').val();
        //8文字以下、またはeditPasswordとeditConfirmPasswordが不一致ならばエラー
        if(editPassword.length > 0 && editPassword.length < 8 ) {
            errorCount++;
            errorType.push('passwordLength');
        }else if(editPassword !== editConfirmPassword) {
            errorCount++;
            errorType.push('passwordConfirm');
        }

        //current_passwordバリデーション
        const currentPassword = $('#current_password').val();
        //未入力、または8文字以下であればエラー
        if(!currentPassword) {
            errorCount++;
            errorType.push('currentPasswordRequired');
        }else if(currentPassword.length < 8) {
            errorCount++;
            errorType.push('currentPasswordMin');
        }

        //エラーがあればエラーメッセージを表示
        if(errorCount > 0) {
            //エラータイプによって表示を切り替え
            //name
            if($.inArray('nameRequired', errorType) !== -1) {
                $('.name-error').addClass('is_error');
                $('#name').addClass('is_error');
                $('.name-error').text('※ 管理者名が入力されていません');
            }else if($.inArray('nameMax', errorType) !== -1) {
                $('.name-error').addClass('is_error');
                $('#name').addClass('is_error');
                $('.name-error').text('※ 管理者名は20文字以内で入力してください');
            }

            //email
            if($.inArray('emailRequired', errorType) !== -1) {
                $('.email-error').addClass('is_error');
                $('#email').addClass('is_error');
                $('.email-error').text('※ メールアドレスが入力されていません');
            }else if($.inArray('emailRegex', errorType) !== -1) {
                $('.email-error').addClass('is_error');
                $('#email').addClass('is_error');
                $('.email-error').text('※ メールアドレスの入力形式が違います');
            }
            
            //password
            if($.inArray('passwordLength', errorType) !== -1) {
                $('.password-error').addClass('is_error');
                $('#password').addClass('is_error');
                $('.password-error').text('※ パスワードは8文字以上で入力してください');
            }else if($.inArray('passwordConfirm', errorType) !== -1) {
                $('.password-error').addClass('is_error');
                $('#password').addClass('is_error');
                $('.password-error').text('※ 確認フィールドと一致しません');
            }

            //current_password
            if($.inArray('currentPasswordRequired', errorType) !== -1) {
                $('.current-password-error').addClass('is_error');
                $('#current_password').addClass('is_error');
                $('.current-password-error').text('※ 現在のパスワードを入力してください');
            }else if($.inArray('currentPasswordMin', errorType) !== -1) {
                $('.current-password-error').addClass('is_error');
                $('#current_password').addClass('is_error');
                $('.current-password-error').text('※ パスワードは8文字以上です');
            }

            //is_errorクラスが付与されたエラー項目にエラーメッセージを表示
            $('.error-field:has(.is_error)').css('display', 'block');
            //トップへスクロールさせる
            $('html,body').animate({scrollTop:$('.main-global-wrapper').offset().top});
        }else {
            //確認画面を表示
            $('.check-edit-wrapper').addClass('view');
        }
        
    });

    //編集キャンセルボタンを押した際の処理
    $('#cancel-edit').on('click', function(e) {
        e.preventDefault();

        //確認画面を閉じる
        $('.check-edit-wrapper').removeClass('view');
    })

    //登録の解除ボタンを押した際の処理
    $('#btn-user-delete').on('click', function(e) {
        e.preventDefault();

        //確認画面を表示
        $('.check-delete-wrapper').addClass('view');
    })

    //登録解除キャンセルボタンを押した際の処理
    $('#cancel-delete').on('click', function(e) {
        e.preventDefault();

        //確認画面を閉じる
        $('.check-delete-wrapper').removeClass('view');
    })
})