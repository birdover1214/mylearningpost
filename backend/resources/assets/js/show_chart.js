import "Chart.js"

$(function() {

    const canvas = $("#myChart");

    var myChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: ["10/1", "10/2", "10/3", "10/4", "10/5", "10/6", "10/7", "10/8", "10/9", "10/10", "10/11", "10/12", "10/13", "10/14"],
            datasets: [{
                label: '学習時間',
                data: [12, 19, 3, 5, 2, 3, 8, 10, 9, 8, 4, 6, 11, 3],
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
})