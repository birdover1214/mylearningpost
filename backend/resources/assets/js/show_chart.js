//描画するグラフの設定
function make_chart(labels, data)
{

    const canvas = $("#myChart");

    window.myChart = new Chart(canvas, {
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

    const sendData = new FormData();
    sendData.append('id', userId);

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
        data: sendData,
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
        const labels = Object.keys(response.data);
        const data = Object.values(response.data);
        make_chart(labels, data);
    })
    .fail(function(response) {
        //エラーメッセージの表示
        addErrorMessage();
    })

    //1週間表示ボタンを押した際の処理
    $('#btn-1week').on('click', function() {
        //表示切り替えなので変数にchangeを渡す
        const prevOrNextOrChange = 'change';
        //1週間表示の為変数に1weekを渡す
        const setWeek = '1week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    //2週間表示ボタンを押した際の処理
    $('#btn-2week').on('click', function() {
        //表示切り替えなので変数にchangeを渡す
        const prevOrNextOrChange = 'change';
        //2週間表示の為変数に2weekを渡す
        const setWeek = '2week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    //prev-1weekボタンを押した際の処理
    $('.prev-1week').on('click', function() {
        //prevボタンを押したので変数にprevを渡す
        const prevOrNextOrChange = 'prev';
        //1週間表示の為変数に1weekを渡す
        const setWeek = '1week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    //next-1weekボタンを押した際の処理
    $('.next-1week').on('click', function() {

        //nextボタンを押したので変数にnextを渡す
        const prevOrNextOrChange = 'next';
        //1週間表示の為変数に1weekを渡す
        const setWeek = '1week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    //prev-2weekボタンを押した際の処理
    $('.prev-2week').on('click', function() {
        //prevボタンを押したので変数にprevを渡す
        const prevOrNextOrChange = 'prev';
        //2週間表示の為変数に2weekを渡す
        const setWeek = '2week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    //next-2weekボタンを押した際の処理
    $('.next-2week').on('click', function() {

        //nextボタンを押したので変数にnextを渡す
        const prevOrNextOrChange = 'next';
        //2週間表示の為変数に2weekを渡す
        const setWeek = '2week';

        _getChartData(setWeek, prevOrNextOrChange);
    })

    
    //データの取得とグラフ再描画処理
    function _getChartData(setWeek, prevOrNextOrChange) {
        //エラーメッセージが表示されていたら取り除く
        removeErrorMessage();

        //取得するデータ範囲を決める為data-countの値の取得
        let sendCount = '';
        if(setWeek === '1week' && prevOrNextOrChange === 'prev') {
            sendCount = $('.prev-1week').data('count');
        }else if(setWeek === '1week' && prevOrNextOrChange === 'next') {
            sendCount = $('.next-1week').data('count');
        }else if(setWeek === '2week' && prevOrNextOrChange === 'prev') {
            sendCount = $('.prev-2week').data('count');
        }else if(setWeek === '2week' && prevOrNextOrChange === 'next') {
            sendCount = $('.next-2week').data('count');
        }else {
            sendCount = 0;
        }

        console.log(sendCount)

        //sendCountとsetWeekの値をsendDataに追加
        sendData.append('week', setWeek);
        sendData.append('count', sendCount);

        //データを取得しグラフを描画
        $.ajax({
            url: '/mypage/getdata',
            type: 'POST',
        })
        .done(function(response) {
            //現在表示しているグラフを破棄
            myChart.destroy();
            //グラフの描画処理
            const labels = Object.keys(response.data);
            const data = Object.values(response.data);
            make_chart(labels, data);
            //prevボタンを押した場合はnextボタンを押せるようにする
            //nextボタンを押した場合はsendCountの値によってnextボタンを押せないようにする
            //1週間2週間の切り替えの場合はボタン配置を切り替える
            if(setWeek === '1week' && prevOrNextOrChange === 'prev') {

                //next-1weekボタンを押せるようにする
                $('.next-1week').prop('disabled', false);
                //data-countの値を更新する
                $('.prev-1week').data('count', sendCount + 1);
                $('.next-1week').data('count', sendCount - 1);

            }else if(setWeek === '1week' && prevOrNextOrChange === 'next') {

                //data-countの値を更新する
                $('.prev-1week').data('count', sendCount + 1);
                $('.next-1week').data('count', sendCount - 1);
                //nextボタンを押した際のsendCountが1だった場合、次のデータはないのでnextボタンを押せないようにする
                if(sendCount === 0) {
                    $('.next-1week').prop('disabled', true);
                }

            }else if(setWeek === '2week' && prevOrNextOrChange === 'prev') {

                //next-2weekボタンを押せるようにする
                $('.next-2week').prop('disabled', false);
                //data-countの値を更新する
                $('.prev-2week').data('count', sendCount + 1);
                $('.next-2week').data('count', sendCount - 1);

            }else if(setWeek === '2week' && prevOrNextOrChange === 'next') {

                //data-countの値を更新する
                $('.prev-2week').data('count', sendCount + 1);
                $('.next-2week').data('count', sendCount - 1);
                //nextボタンを押した際のsendCountが1だった場合、次のデータはないのでnextボタンを押せないようにする
                if(sendCount === 0) {
                    $('.next-2week').prop('disabled', true);
                }

            }else if(setWeek === '1week'){

                //2週間ボタンを押せるようにして、1週間ボタンを押せないようにする
                $('#btn-2week').prop('disabled', false);
                $('#btn-1week').prop('disabled', true);
                //prev-2weekボタンとnext-2weekボタンのdata-countをリセットし、非表示にする
                $('.prev-2week').data('count', 1);
                $('.next-2week').data('count', -1);
                $('.prev-2week').css('display', 'none');
                $('.next-2week').css('display', 'none');
                $('.next-1week').prop('disabled', true);
                //prev-1weekボタンとnext-1weekボタンを表示する
                $('.prev-1week').css('display', 'block');
                $('.next-1week').css('display', 'block');

            }else {

                //1週間ボタンを押せるようにして、2週間ボタンを押せないようにする
                $('#btn-1week').prop('disabled', false);
                $('#btn-2week').prop('disabled', true);
                //prev-1weekボタンとnext-1weekボタンのdata-countリセットし、非表示にする
                $('.prev-1week').data('count', 1);
                $('.next-1week').data('count', -1);
                $('.prev-1week').css('display', 'none');
                $('.next-1week').css('display', 'none');
                $('.next-2week').prop('disabled', true);
                //prev-2weekボタンとnext-2weekボタンを表示する
                $('.prev-2week').css('display', 'block');
                $('.next-2week').css('display', 'block');

            }
        })
        .fail(function(response) {
            //エラーメッセージの表示
            addErrorMessage();
        })
    }
})