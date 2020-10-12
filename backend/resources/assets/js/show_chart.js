import "Chart.js";

//描画するグラフの設定
window.make_chart = function make_chart(labels, data)
{

    const canvas = $("#myChart");

    var myChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '学習時間(分)',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}


$(function() {
    //グラフ描画データを取得するユーザーidを取得
    const userId = $('.main-wrapper').data('id');

    const sendId = new FormData();
    sendId.append('id', userId);

    //ajaxのセットアップ
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 10000,
        cache: false,
        type: 'POST',
        data: sendId,
    });

    //エラーメッセージ表示用
    function addErrorMessage() {
        $('.error-field').css('display', 'block');
        $('.chart-menu-container').css('margin-bottom', '0.5rem');
    }
    //エラーメッセージ非表示用
    function removeErrorMessage() {
        $('.error-field').css('display', 'none');
        $('.chart-menu-container').css('margin-bottom', '1rem');
    }

    //画面遷移時のグラフ描画の為のデータを取得
    $.ajax({
        url: '/mypage/getdata',
    })
    .done(function(response) {
        const labels = Object.keys(response.times);
        const data = Object.values(response.times);
        make_chart(labels, data);
    })
    .fail(function(response) {
        //エラーメッセージの表示
        addErrorMessage();
    })

    //1週間表示ボタンを押した際の処理
    $('#btn-1week').on('click', function() {
        //エラーメッセージが表示されていたら取り除く
        removeErrorMessage();

        //ajax通信にて1週間分のデータを取得
        $.ajax({
            url: '/mypage/getdata',
            type: 'POST',
        })
        .done(function(response) {
            const labels = Object.keys(response.times);
            const data = Object.values(response.times);
            make_chart(labels, data);
            //2週間ボタンを押せるようにして、1週間ボタンを押せないようにする
            $('#btn-2week').prop('disabled', false);
            $('#btn-1week').prop('disabled', true);
        })
        .fail(function(response) {
            //エラーメッセージの表示
            addErrorMessage();
        })
    })

    //2週間表示ボタンを押した際の処理
    $('#btn-2week').on('click', function() {
        //エラーメッセージが表示されていたら取り除く
        removeErrorMessage();

        //ajax通信にて2週間分のデータを取得
        $.ajax({
            url: '/mypage/getdata2week',
            type: 'POST',
        })
        .done(function(response) {
            const labels = Object.keys(response.times);
            const data = Object.values(response.times);
            make_chart(labels, data);
            //1週間ボタンを押せるようにして、2週間ボタンを押せないようにする
            $('#btn-1week').prop('disabled', false);
            $('#btn-2week').prop('disabled', true);
        })
        .fail(function(response) {
            //エラーメッセージの表示
            addErrorMessage();
        })
    })
})