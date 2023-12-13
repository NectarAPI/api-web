$(function () {
    "use strict";
    var StatsLineOptions = {
        scales: {
            responsive: false,
            maintainAspectRatio: true,
            yAxes: [{
                display: false
            }],
            xAxes: [{
                display: false
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 0
            }
        },
        stepsize: 100
    }
    if ($('#stat-line_1').length) {
        var lineChartCanvas = $("#stat-line_1").get(0).getContext("2d");
        var gradientStroke = lineChartCanvas.createLinearGradient(100, 60, 30, 0);
        gradientStroke.addColorStop(0, '#B721FF');
        gradientStroke.addColorStop(1, '#21D4FD');
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
                datasets: [{
                    label: 'Profit',
                    data: [7, 6, 9, 7, 8, 6, 8, 5, 7, 8, 6, 7, 7],
                    borderColor: gradientStroke,
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: StatsLineOptions
        });
    }
    if ($('#stat-line_2').length) {
        var lineChartCanvas = $("#stat-line_2").get(0).getContext("2d");
        var gradientStroke = lineChartCanvas.createLinearGradient(100, 60, 30, 0);
        gradientStroke.addColorStop(0, '#08AEEA');
        gradientStroke.addColorStop(1, '#2AF598');
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
                datasets: [{
                    label: 'Profit',
                    data: [7, 6, 9, 7, 8, 6, 8, 5, 7, 8, 6, 7, 7],
                    borderColor: gradientStroke,
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: StatsLineOptions
        });
    }
    if ($('#stat-line_3').length) {
        var lineChartCanvas = $("#stat-line_3").get(0).getContext("2d");
        var gradientStroke = lineChartCanvas.createLinearGradient(100, 60, 30, 0);
        gradientStroke.addColorStop(0, '#FEE140');
        gradientStroke.addColorStop(1, '#FA709A');
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
                datasets: [{
                    label: 'Profit',
                    data: [7, 6, 9, 7, 8, 6, 8, 5, 7, 8, 6, 7, 7],
                    borderColor: '#6d7cfc',
                    borderColor: gradientStroke,
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: StatsLineOptions
        });
    }
    if ($('#stat-line_4').length) {
        var lineChartCanvas = $("#stat-line_4").get(0).getContext("2d");
        var gradientStroke = lineChartCanvas.createLinearGradient(100, 60, 30, 0);
        gradientStroke.addColorStop(0, '#ff7fc7');
        gradientStroke.addColorStop(1, '#43b4ff');
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
                datasets: [{
                    label: 'Profit',
                    data: [7, 6, 9, 7, 8, 6, 8, 5, 7, 8, 6, 7, 7],
                    borderColor: '#6d7cfc',
                    borderColor: gradientStroke,
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: StatsLineOptions
        });
    }
    if ($("#followers-bar-chart").length) {
        var a = {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {
                    responsive: !0,
                    maintainAspectRatio: !0,
                    yAxes: [{
                        display: !0,
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.03)",
                            drawBorder: !1
                        },
                        ticks: {
                            min: 20,
                            max: 80,
                            stepSize: 20,
                            fontColor: "#212529",
                            maxTicksLimit: 3,
                            callback: function (a, e, r) {
                                return a + " K"
                            },
                            padding: 10
                        }
                    }],
                    xAxes: [{
                        display: !1,
                        barPercentage: .3,
                        gridLines: {
                            display: !1,
                            drawBorder: !1
                        }
                    }]
                },
                legend: {
                    display: !1
                }
            },
            e = document.getElementById("followers-bar-chart");
        new Chart(e, {
            type: "bar",
            data: {
                labels: ["Mon", "Tue", "Wed", "Thus", "Fri", "Sat"],
                datasets: [{
                    label: "Follower",
                    data: [62, 52, 73, 58, 63, 72],
                    backgroundColor: [chartColors[0], chartColors[0], chartColors[0], chartColors[0], chartColors[0], chartColors[0]],
                    borderColor: chartColors[0],
                    borderWidth: 0
                }]
            },
            options: a
        })
    }
    if ($("#radial-chart").length) {
        a = {
            chart: {
                height: 230,
                type: "radialBar"
            },
            series: [67],
            colors: ["#696ffb"],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: "70%",
                        background: "rgba(255,255,255,0.1)"
                    },
                    track: {
                        dropShadow: {
                            enabled: !0,
                            top: 2,
                            left: 0,
                            blur: 4,
                            opacity: .02
                        }
                    },
                    dataLabels: {
                        name: {
                            offsetY: -10,
                            color: "#adb5bd",
                            fontSize: "13px"
                        },
                        value: {
                            offsetY: 5,
                            color: "#000",
                            fontSize: "20px",
                            show: !0
                        }
                    }
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "dark",
                    type: "vertical",
                    gradientToColors: ["#87D4F9"],
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: "round"
            },
            labels: ["Progress"]
        };
        (r = new ApexCharts(document.querySelector("#radial-chart"), a)).render()
    }
    
});