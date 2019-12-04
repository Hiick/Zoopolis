function renderChart(data) {
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
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
            cutoutPercentage: 80
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