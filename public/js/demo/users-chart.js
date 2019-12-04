function renderChart(data) {
    var ctx = document.getElementById("myPieChart");

    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["> 18 ans", "18-25 ans", "26-35 ans", "36-50 ans", "> 50 ans"],
            datasets: [{
                data: data,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', 'mediumpurple', 'mediumorchid'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', 'rebeccapurple', 'darkorchid'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10
            },
            legend: {
                display: false
            },
            cutoutPercentage: 50
        }

    });

    Chart.pluginService.register({
        beforeDraw: function(chart) {
            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;

            ctx.restore();
            var fontSize = (height / 114).toFixed(2);
            ctx.font = fontSize + "em sans-serif";
            ctx.textBaseline = "middle";

            var text = "Âges",
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    });

}

$(document).ready(function() {
    $.ajax({
        url : '/users/ages',
        type: 'GET',
        async: true,
        success: function (data) {
            renderChart(data)
        }
    });
});