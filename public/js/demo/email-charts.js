function renderChart(data, labels) {
    var ctx = document.getElementById("emailChart");

    var myPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
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
}

$(document).ready(function() {
    $.ajax({
        url : '/users/emails',
        type: 'GET',
        async: true,
        success: function (data) {
            renderChart(data.Datas, data.Labels)
        }
    });
});