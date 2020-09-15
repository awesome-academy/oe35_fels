var SITEURL = window.location.origin;

/* Initial AJAX setup header when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$('#select-datetime').change(function () {
    var getBy = $(this).val();
    getChartData(getBy);
});

function renderChart(labels, data) {
    var ctx = document.getElementById("userChart").getContext('2d');
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'User Report',
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
                        // stepSize: 1
                    }
                }]
            },
        }
    };
    var userChart = new Chart(ctx, config);
}

function getChartData(getBy) {
    $.ajax({
        url: SITEURL + '/admin/chart-data?datetime=' + getBy,
        type: 'GET',
        success: function (result) {
            var data = result.indexs;
            var labels = result.labels;
            renderChart(labels, data);
        },
        error: function (result) {
            console.log(result);
        },
    });
}

getChartData('month');
