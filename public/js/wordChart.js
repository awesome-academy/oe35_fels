var SITEURL = window.location.origin;

/* Initial AJAX setup header when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function renderChart(labels, data) {
    var ctx = document.getElementById("wordChart").getContext('2d');
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Word Learned',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(255, 159, 64, 0.2)'
            }, ]
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: false,
                text: 'Word Learned By Month'
            },
            animation: {
                animateScale: true,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        },
                        stepSize: 1
                    }
                }]
            },
        }
    };
    var wordChart = new Chart(ctx, config);
}

function getChartData() {
    $.ajax({
        url: SITEURL + '/statistic/chart-data',
        type: 'get',
        success: function (result) {
            var data = result.month;
            var labels = result.labels;
            renderChart(labels, data);
        },
        error: function (result) {
            console.log(result);
        },
    });
}

getChartData();
