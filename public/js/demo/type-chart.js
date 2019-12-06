Chart.pluginService.register({
    beforeDraw: function (chart) {
        if (chart.config.options.elements.center) {
            //Get ctx from string
            var ctx = chart.chart.ctx;

            //Get options from the center object in options
            var centerConfig = chart.config.options.elements.center;
            var fontStyle = centerConfig.fontStyle || 'Arial';
            var txt = centerConfig.text;
            var color = centerConfig.color || '#000';
            var sidePadding = centerConfig.sidePadding || 20;
            var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
            //Start with a base font of 30px
            ctx.font = "30px " + fontStyle;

            //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
            var stringWidth = ctx.measureText(txt).width;
            var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

            // Find out how much the font can grow in width.
            var widthRatio = elementWidth / stringWidth;
            var newFontSize = Math.floor(30 * widthRatio);
            var elementHeight = (chart.innerRadius * 2);

            // Pick a new font size so it will not be larger than the height of label.
            var fontSizeToUse = Math.min(newFontSize, elementHeight);

            //Set font settings to draw it correctly.
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
            var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
            ctx.font = fontSizeToUse+"px " + fontStyle;
            ctx.fillStyle = color;

            //Draw text in center
            ctx.fillText(txt, centerX, centerY);
        }
    }
});

function typeChart(data) {
    var ctx = document.getElementById("type-chart");

    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Canard", "Chat", "Cheval", "Chèvre", "Chien", "Cochon d'Inde", "Furet", "Lapin", "Mignon", "Vache"],
            datasets: [{
                data: data,
                backgroundColor: ['#006278', '#d7bec2', '#e0ad6d', '#868d82', '#be9da3', '#bfa27f', '#c8b399', '#5a5757', '#e7b42a', '#ad7a4c'],
                hoverBackgroundColor: ['#024e5f', '#bda7ab', '#b58c59', '#71776e', '#a5888d', '#988164', '#a3927d', '#363434', '#ad871f', '#7c5736'],
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
            elements: {
                center: {
                    text: 'Types',
                    color: 'black', //Default black
                    sidePadding: 20 //Default 20 (as a percentage)
                }
            },
            cutoutPercentage: 50
        }
    });
}

function raceChart(data) {
    var ctx = document.getElementById("race-chart");

    var myPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Race 0", "Race 1", "Race 2", "Race 3", "Race 4", "Race 5", "Race 6", "Race 7", "Race 8", "Race 9", "Race 10", "Race 11", "Race 12", "Race 13", "Race 14", "Race 15", "Race 16", "Race 17", "Race 18", "Race 19", "Race 20", "Race 21", "Race 22"],
            datasets: [{
                data: data,
                backgroundColor: ['#006278', '#d7bec2', '#e0ad6d', '#868d82', '#be9da3', '#bfa27f', '#c8b399', '#5a5757', '#e7b42a', '#ad7a4c', '#006278', '#d7bec2', '#e0ad6d', '#868d82', '#be9da3', '#bfa27f', '#c8b399', '#5a5757', '#e7b42a', '#ad7a4c', '#5a5757', '#e7b42a', '#ad7a4c'],
                hoverBackgroundColor: ['#024e5f', '#bda7ab', '#b58c59', '#71776e', '#a5888d', '#988164', '#a3927d', '#363434', '#ad871f', '#7c5736', '#024e5f', '#bda7ab', '#b58c59', '#71776e', '#a5888d', '#988164', '#a3927d', '#363434', '#ad871f', '#7c5736', '#363434', '#ad871f', '#7c5736'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleFontColor: 'black',
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
            elements: {
                center: {
                    text: 'Races',
                    color: 'black', //Default black
                    sidePadding: 20 //Default 20 (as a percentage)
                }
            },
            cutoutPercentage: 50
        }
    });
}

$(document).ready(function() {
    $.ajax({
        url : '/pets/types',
        type: 'GET',
        async: true,
        success: function (data) {
            typeChart(data)
        }
    });
});
$('#type-race').change(function() {
    $('.number').html('Attendez...');
    if ($(this).val() === "Type") {
        $.ajax({
            url : '/pets/types',
            type: 'GET',
            async: true,
            success: function (data) {
                typeChart(data);
                $('#race-chart').css("display", "none");
                $('#type-chart').css("display", "block");
                $('.labels').css("display", "block");
                $('.number').html('Nombre d\'animaux par types');
            }
        });
    } else {
        $.ajax({
            url : '/pets/races',
            type: 'GET',
            async: true,
            success: function (data) {
                raceChart(data);
                $('#type-chart').css("display", "none");
                $('#race-chart').css("display", "block");
                $('.labels').css("display", "none");
                $('.number').html('Nombre d\'animaux par races');
            }
        });
    }
});