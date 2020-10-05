$(function() {
    //プロフィール画像が変更されたらサムネイルを表示
    $('#user_image').on('change', function(e) {
        let preview = $('.image-preview');

        if(e.target.files.length) {
            const fd = new FileReader;
            fd.onload = function(e) {
                preview.attr('src', e.target.result);
            }
            return fd.readAsDataURL(e.target.files[0]);
        }
    });

    //プロフィール変更ボタンを押した際の処理
    $('#btn-edit').on('click', function(e) {
        e.preventDefault();

        //バリデーション処理
        //エラー数格納用変数の初期化
        let errorCount = 0;
        //エラーの種類を格納する配列の初期化
        let errorType = [];

        //user_imageバリデーション
        const editImage = $('#user_image').prop('files')[0];
        //プロフィール画像が変わっている場合は以下を実行
        if(editImage) {
            //拡張子のチェック
            const checkEditImage = checkExt(editImage);
            //エラーフラグ処理
            if(!checkEditImage) {
                errorCount++;
                errorType.push('user_image');
            }
        }

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

        //introductionバリデーション
        const editIntroduction = $('#introduction').val();
        //100文字以上であればエラー
        if(editIntroduction.length > 100) {
            errorCount++;
            errorType.push('introduction');
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

        //skillsバリデーション
        const editSkillsLength = $('.checkbox-content:checked').length;
        //選択数が0または11以上であればエラー
        if(editSkillsLength === 0 || editSkillsLength > 10) {
            errorCount++;
            errorType.push('skills');
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
            //image
            if($.inArray('user_image', errorType) !== -1) {
                $('.user_image-error').addClass('is_error');
                $('.user_image-error').text('※ 添付されたファイルは使用出来ません');
            }
            
            //name
            if($.inArray('nameRequired', errorType) !== -1) {
                $('.name-error').addClass('is_error');
                $('#name').addClass('is_error');
                $('.name-error').text('※ ニックネームが入力されていません');
            }
            if($.inArray('nameMax', errorType) !== -1) {
                $('.name-error').addClass('is_error');
                $('#name').addClass('is_error');
                $('.name-error').text('※ ニックネームは20文字以内で入力してください');
            }
            
            //introduction
            if($.inArray('introduction', errorType) !== -1) {
                $('.introduction-error').addClass('is_error');
                $('#introduction').addClass('is_error');
                $('.introduction-error').text('※ プロフィールコメントは100文字以内で入力してください');
            }

            //email
            if($.inArray('emailRequired', errorType) !== -1) {
                $('.email-error').addClass('is_error');
                $('#email').addClass('is_error');
                $('.email-error').text('※ メールアドレスが入力されていません');
            }
            if($.inArray('emailRegex', errorType) !== -1) {
                $('.email-error').addClass('is_error');
                $('#email').addClass('is_error');
                $('.email-error').text('※ メールアドレスの入力形式が違います');
            }
            
            //password
            if($.inArray('passwordLength', errorType) !== -1) {
                $('.password-error').addClass('is_error');
                $('#password').addClass('is_error');
                $('.password-error').text('※ パスワードは8文字以上で入力してください');
            }
            if($.inArray('passwordConfirm', errorType) !== -1) {
                $('.password-error').addClass('is_error');
                $('#password').addClass('is_error');
                $('.password-error').text('※ 確認フィールドと一致しません');
            }
            
            //skills
            if($.inArray('skills', errorType) !== -1) {
                $('.skills-error').addClass('is_error');
                $('.skills-error').text('※ スキルは1～10個の間で選択してください');
            }
            
            //current_password
            if($.inArray('currentPasswordRequired', errorType) !== -1) {
                $('.current-password-error').addClass('is_error');
                $('#current_password').addClass('is_error');
                $('.current-password-error').text('※ 現在のパスワードを入力してください');
            }
            if($.inArray('currentPasswordMin', errorType) !== -1) {
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

    function checkExt(editImage) {
        //許可する拡張子
        const allowExts = ['jpg', 'jpeg', 'png'];

        //セットされているファイル名を取得
        const fileName = editImage.name;
        //拡張子の場所を特定
        const imageExtIndex = fileName.lastIndexOf('.');
        //拡張子格納よう変数を初期化
        let imageExt = '';

        //拡張子を取得
        if(imageExtIndex === -1) {
            imageExt = '';
        }else {
            imageExt = fileName.slice(imageExtIndex + 1);
        }

        //許可する拡張子と比較する
        if(allowExts.indexOf(imageExt) === -1) {
            return false;
        }else {
            return true;
        }
    }


    // //プロフィール変更処理
    // $('#submit-edit').on('click', function(e) {
    //     e.preventDefault();

    //     //プロフィール画像データを取得
    //     const imageData = $('#user_image').prop('files')[0];
    //     //フォームに入力されているデータをプロフィール画像以外全て取得
    //     const formData = $('#form-edit').serializeArray();

    //     //送信用のFormData作成
    //     const sendData = new FormData();

    //     //画像データ挿入
    //     sendData.append('user_image', imageData);
    //     //その他のデータ挿入
    //     for(let i = 0; i < formData.length; i++) {
    //         sendData.append(formData[i].name, formData[i].value);
    //     }

    //     //ajax通信処理
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: '/mypage/update',
    //         type: 'POST',
    //         data: sendData,
    //         processData: false,
    //         contentType: false,
    //         timeout: 10000,
    //     })
    //     //成功時
    //     .done(function(data) {
    //         console.log('success')
    //         console.log(data)
    //     })
    //     //失敗時
    //     .fail(function(data) {
    //         console.log('fail')
    //     });

    //     //確認画面を閉じる
    //     $('.check-edit-wrapper').removeClass('view');
    // })


    //キャンセルボタンを押した際の処理
    $('#cancel-edit').on('click', function(e) {
        e.preventDefault();

        //確認画面を閉じる
        $('.check-edit-wrapper').removeClass('view');
    })
})