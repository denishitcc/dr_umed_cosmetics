//tooltip with progrssbar
$(function () {
    $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});

$(".progress-bar").each(function(){
    each_bar_width = $(this).attr('aria-valuenow');
    $(this).width(each_bar_width + '%');
});
//tooltip with progrssbar


// Setup CSRF token for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Date range picker setup
$(function() {
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    // The event listener here.
    $('#reportrange').on('apply.daterangepicker', function(e, picker) {
        var reportRange = picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY');
        var location = $('#locations').val();
        filterData(reportRange, location);
    });

    cb(start, end);
});

//filter 
// Event listener for location dropdown change
$('#locations').change(function() {
    var reportRange = $('#reportrange').text().trim(); // This should be adjusted if it doesn't give you the actual date range
    var location = $(this).val();
    filterData(reportRange, location);
});

// Function to handle data filtering based on report range and location
// Declare variables for the series globally
var ClientFilterData = [];
var EnquiryFilterData = [];
var isfilter_client = 0;
var isfilter_enquiry = 0;
var clientsRoot, enquiryRoot, xAxis, chart, currentData
var isfilter_sales_performance = 0;
var SalesPerformanceFilterData=[];
var dayData, weekData, monthData;

function filterData(reportRange, location) {
    $.ajax({
        url: FilterRoute,
        type: 'POST',
        data: {
            reportRange: reportRange,
            location: location
        },
        success: function(response) {
            // Handle success response from server
            //total sales filter
            var totalSales = parseInt(response.totalSales);
            var expectedSales = parseInt(response.expected);
            $('.made_so_far').text('$' + totalSales);
            $('.expected').text('$' + (expectedSales));

            // Calculate the percentage remaining for the progress bar
            var percentageRemaining;
            if ((expectedSales) === 0) {
                percentageRemaining = 0;
            } else {
                percentageRemaining = (totalSales / expectedSales) * 100;
            }

            // Update the progress bar's width and aria-valuenow attribute
            var totalSalesProgressBar = $('.sales_progress');
            totalSalesProgressBar.css('width', percentageRemaining + '%');
            totalSalesProgressBar.attr('aria-valuenow', percentageRemaining);

            //total appointments filter
            var scheduledApp = parseInt(response.scheduledApp);
            var completedApp = parseInt(response.completedApp);
            var cancelledApp = parseInt(response.cancelledApp);
            var totalApp = parseInt(response.totalApp);

            $('.scheduled_app').text(scheduledApp);
            $('.completed_app').text(completedApp);
            $('.cancelled_app').text(cancelledApp);

            // Calculate the scheduled appt for the progress bar
            var scheduledpercentageRemaining;
            if (scheduledApp === 0 || totalApp === 0) {
                scheduledpercentageRemaining = 0;
            } else {
                scheduledpercentageRemaining = (scheduledApp / totalApp) * 100;
            }

            // Update the progress bar's width and aria-valuenow attribute
            var ScheduledProgressBar = $('.scheduled');
            ScheduledProgressBar.css('width', scheduledpercentageRemaining + '%');
            ScheduledProgressBar.attr('aria-valuenow', scheduledpercentageRemaining);

            // Calculate the completed appt for the progress bar
            var completedpercentageRemaining;
            if (completedApp === 0 || totalApp === 0) {
                completedpercentageRemaining = 0;
            } else {
                completedpercentageRemaining = (completedApp / totalApp) * 100;
            }

            // Update the progress bar's width and aria-valuenow attribute
            var CompletedprogressBar = $('.completed');
            CompletedprogressBar.css('width', completedpercentageRemaining + '%');
            CompletedprogressBar.attr('aria-valuenow', completedpercentageRemaining);

            // Calculate the cancelled appt for the progress bar
            var cancelledpercentageRemaining;
            if (cancelledApp === 0 || totalApp === 0) {
                cancelledpercentageRemaining = 0;
            } else {
                cancelledpercentageRemaining = (cancelledApp / totalApp) * 100;
            }

            // Update the progress bar's width and aria-valuenow attribute
            var cancelledprogressBar = $('.cancelled');
            cancelledprogressBar.css('width', cancelledpercentageRemaining + '%');
            cancelledprogressBar.attr('aria-valuenow', cancelledpercentageRemaining);
            
            // total clients filter
            $('.total_client').text(response.totalFilterClients);
            var ClientFilterData = response.clientGraph.map(item => {
                return {
                    date: new Date(item.date).getTime(),
                    value: parseInt(item.count)
                };
            });

            //total enquiry filter
            $('.total_enquiry').text(response.totalFilterEnquiries);
            var EnquiryFilterData = response.enquiryGraph.map(item => {
                return {
                    date: new Date(item.date).getTime(),
                    value: parseInt(item.count)
                };
            });
            isfilter_client=1;
            isfilter_enquiry=1;
            amchart(ClientFilterData,EnquiryFilterData);
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Error filtering data:", error);
            // Display error message or perform fallback actions
        }
    });
}
function amchart(ClientFilterData = [],EnquiryFilterData = [], filterType = 'month') {
    if (clientsRoot) {
        clientsRoot.dispose();
    }
    if (enquiryRoot) {
        enquiryRoot.dispose();
    }
    if (enquiryRoot) {
        enquiryRoot.dispose();
    }

    am5.ready(function() {
        // Clients Graph start
        clientsRoot = am5.Root.new("clientchartdiv");

        // Set themes
        clientsRoot.setThemes([
            am5themes_Animated.new(clientsRoot)
        ]);

        // Create chart
        var clientsChart = clientsRoot.container.children.push(am5xy.XYChart.new(clientsRoot, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none",
            pinchZoomX: false,
            paddingLeft: 0
        }));

        // Remove logo
        clientsRoot._logo.dispose();

        // Create axes (hidden)
        var clientsXAxis = clientsChart.xAxes.push(am5xy.DateAxis.new(clientsRoot, {
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(clientsRoot, {
                minorGridEnabled: true,
                minGridDistance: 90
            })
        }));
        clientsXAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide x-axis labels
        clientsXAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide x-axis grid

        var clientsYAxis = clientsChart.yAxes.push(am5xy.ValueAxis.new(clientsRoot, {
            renderer: am5xy.AxisRendererY.new(clientsRoot, {})
        }));
        clientsYAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide y-axis labels
        clientsYAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide y-axis grid

        // Add series for Clients Graph
        var clientsSeries = clientsChart.series.push(am5xy.LineSeries.new(clientsRoot, {
            name: "Clients Series",
            xAxis: clientsXAxis,
            yAxis: clientsYAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(clientsRoot, {
                labelText: "{valueY}"
            })
        }));

        clientsSeries.fills.template.setAll({
            fillOpacity: 0.2,
            visible: true
        });

        // Prepare data for Clients Graph
        var clientsData = ClientsGraph.map(item => {
            return {
                date: new Date(item.date).getTime(),
                value: parseInt(item.count) // Ensure value is an integer
            };
        });
        

        // Set data for Clients Graph
        if (isfilter_client == 1) {
            
            // Handle single data point case
            if (ClientFilterData.length === 1) {
                const singleDataPoint = ClientFilterData[0];
                ClientFilterData = [
                    { date: singleDataPoint.date - 86400000, value: 0 }, // Add a point one day before with value 0
                    singleDataPoint,
                    { date: singleDataPoint.date + 86400000, value: 0 } // Add a point one day after with value 0
                ];
            }
            console.log('ClientFilterData',ClientFilterData);
            clientsSeries.data.setAll(ClientFilterData);
        } else {
            
            // Handle single data point case
            if (clientsData.length === 1) {
                const singleDataPoint = clientsData[0];
                clientsData = [
                    { date: singleDataPoint.date - 86400000, value: 0 }, // Add a point one day before with value 0
                    singleDataPoint,
                    { date: singleDataPoint.date + 86400000, value: 0 } // Add a point one day after with value 0
                ];
            }
            console.log('clientsData',clientsData);
            clientsSeries.data.setAll(clientsData);
        }
        // Make Clients Graph animate on load
        clientsChart.appear(1000, 100);
        // Clients Graph end

        // Enquiry Chart start
        enquiryRoot = am5.Root.new("enquirychartdiv");

        // Set themes
        enquiryRoot.setThemes([
            am5themes_Animated.new(enquiryRoot)
        ]);

        // Create chart
        var enquiryChart = enquiryRoot.container.children.push(am5xy.XYChart.new(enquiryRoot, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: false,
            paddingLeft: 0
        }));

        // Remove logo
        enquiryRoot._logo.dispose();

        // Create axes (hidden)
        var enquiryXAxis = enquiryChart.xAxes.push(am5xy.DateAxis.new(enquiryRoot, {
            maxDeviation: 0.2,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(enquiryRoot, {
                labels: {
                    text: "" // Empty string to remove labels
                },
                grid: {
                    disabled: true // Disable grid lines
                }
            }),
            tooltip: am5.Tooltip.new(enquiryRoot, {})
        }));
        enquiryXAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide x-axis labels
        enquiryXAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide x-axis grid

        var enquiryYAxis = enquiryChart.yAxes.push(am5xy.ValueAxis.new(enquiryRoot, {
            renderer: am5xy.AxisRendererY.new(enquiryRoot, {
                labels: {
                    text: "" // Empty string to remove labels
                },
                grid: {
                    disabled: true // Disable grid lines
                }
            })
        }));
        enquiryYAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide y-axis labels
        enquiryYAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide y-axis grid

        // Add series for Enquiry Chart
        var enquirySeries = enquiryChart.series.push(am5xy.LineSeries.new(enquiryRoot, {
            name: "Enquiry Series",
            xAxis: enquiryXAxis,
            yAxis: enquiryYAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(enquiryRoot, {
                labelText: "{valueY}"
            })
        }));
        // Prepare data for Enquiry Chart
        var enquiryData = EnquiryGraph.map(enquiry => {
            return {
                date: new Date(enquiry.date).getTime(),
                value: parseInt(enquiry.count) // Ensure value is an integer
            };
        });

        // Set data for Enquiry Chart
        if (isfilter_enquiry == 1) {
            // Handle single data point case start
            if (EnquiryFilterData.length === 1) {
                const singleDataPoint = EnquiryFilterData[0];
                EnquiryFilterData = [
                    { date: singleDataPoint.date - 86400000, value: 0 }, // Add a point one day before with value 0
                    singleDataPoint,
                    { date: singleDataPoint.date + 86400000, value: 0 } // Add a point one day after with value 0
                ];
            }
            // Handle single data point case end
            console.log('EnquiryFilterData',EnquiryFilterData);
            enquirySeries.data.setAll(EnquiryFilterData);
        } else {
            // Handle single data point case start
            if (enquiryData.length === 1) {
                const singleDataPoint = enquiryData[0];
                enquiryData = [
                    { date: singleDataPoint.date - 86400000, value: 0 }, // Add a point one day before with value 0
                    singleDataPoint,
                    { date: singleDataPoint.date + 86400000, value: 0 } // Add a point one day after with value 0
                ];
            }
            // Handle single data point case end
            console.log('EnquiryData',enquiryData);
            enquirySeries.data.setAll(enquiryData);
        }

        // Make Enquiry Chart animate on load
        enquiryChart.appear(1000, 100);
        // Enquiry Chart end

        // Sales Performance Chart start
        var salesPerformanceRoot = am5.Root.new("Salesperformancechartdiv");

        monthData = [
            { "period": "Jan", "expected": 80, "achieved": 75 },
            { "period": "Feb", "expected": 85, "achieved": 80 },
            { "period": "Mar", "expected": 90, "achieved": 85 },
            { "period": "Apr", "expected": 95, "achieved": 90 },
            { "period": "May", "expected": 100, "achieved": 95 },
            { "period": "Jun", "expected": 105, "achieved": 100 },
            { "period": "Jul", "expected": 110, "achieved": 105 },
            { "period": "Aug", "expected": 115, "achieved": 110 },
            { "period": "Sep", "expected": 120, "achieved": 115 },
            { "period": "Oct", "expected": 125, "achieved": 120 },
            { "period": "Nov", "expected": 130, "achieved": 125 },
            { "period": "Dec", "expected": 135, "achieved": 130 }
        ];

        weekData = [
            { "period": "Week 1", "expected": 20, "achieved": 18 },
            { "period": "Week 2", "expected": 22, "achieved": 20 },
            { "period": "Week 3", "expected": 25, "achieved": 23 },
            { "period": "Week 4", "expected": 28, "achieved": 26 }
        ];

        dayData = [
            { "period": "Mon", "expected": 5, "achieved": 4 },
            { "period": "Tue", "expected": 6, "achieved": 5 },
            { "period": "Wed", "expected": 7, "achieved": 6 },
            { "period": "Thu", "expected": 8, "achieved": 7 },
            { "period": "Fri", "expected": 9, "achieved": 8 },
            { "period": "Sat", "expected": 10, "achieved": 9 },
            { "period": "Sun", "expected": 11, "achieved": 10 }
        ];

        currentData = monthData;

        // Set themes
        salesPerformanceRoot.setThemes([
            am5themes_Animated.new(salesPerformanceRoot)
        ]);

        // Create chart
        chart = salesPerformanceRoot.container.children.push(am5xy.XYChart.new(salesPerformanceRoot, {
            panX: false,
            panY: false,
            paddingLeft: 0,
            wheelX: "panX",
            wheelY: "zoomX",
            layout: salesPerformanceRoot.verticalLayout
        }));

        // Add legend
        var legend = chart.children.push(
            am5.Legend.new(salesPerformanceRoot, {
                centerX: am5.p50,
                x: am5.p50
            })
        );

        // Create axes
        var xRenderer = am5xy.AxisRendererX.new(salesPerformanceRoot, {
            cellStartLocation: 0.1,
            cellEndLocation: 0.9,
            minorGridEnabled: true
        });

        xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(salesPerformanceRoot, {
            categoryField: "period",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(salesPerformanceRoot, {})
        }));

        xRenderer.grid.template.setAll({
            location: 1
        });

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(salesPerformanceRoot, {
            renderer: am5xy.AxisRendererY.new(salesPerformanceRoot, {
                strokeOpacity: 0.1
            })
        }));
        
        // Add "IN AUD" label to y-axis
        yAxis.children.push(am5.Label.new(salesPerformanceRoot, {
            rotation: -90,
            text: "IN AUD",
            y: am5.p50,
            centerX: am5.p50
        }));

        // Add series
        function makeSeries(name, fieldName, color) {
            var series = chart.series.push(am5xy.ColumnSeries.new(salesPerformanceRoot, {
                name: name,
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: fieldName,
                categoryXField: "period",
                fill: color
            }));

            series.columns.template.setAll({
                tooltipText: "{name}, {categoryX}: {valueY}",
                width: am5.percent(90),
                tooltipY: 0,
                strokeOpacity: 0
            });

            series.data.setAll(currentData);

            series.bullets.push(function() {
                return am5.Bullet.new(salesPerformanceRoot, {
                    locationY: 0,
                    sprite: am5.Label.new(salesPerformanceRoot, {
                        text: "{valueY}",
                        fill: salesPerformanceRoot.interfaceColors.get("alternativeText"),
                        centerY: 0,
                        centerX: am5.p50,
                        populateText: true
                    })
                });
            });

            legend.data.push(series);
        }

        // Initial chart setup
        makeSeries("Expected", "expected", am5.color(0x2E93FA)); // Blue color
        makeSeries("Achieved", "achieved", am5.color(0xFFAD33)); // Orange color

        // Call updateSalesPerformanceChart to set initial data
        updateSalesPerformanceChart();
    });
}
function filterSalesPerfornaceData(period) {
    switch (period) {
        case 'day':
            currentData = dayData;
            break;
        case 'week':
            currentData = weekData;
            break;
        case 'month':
        default:
            currentData = monthData;
            break;
    }
    updateSalesPerformanceChart();
}

function updateSalesPerformanceChart() {
    xAxis.data.setAll(currentData);
    chart.series.each(function (series) {
        series.data.setAll(currentData);
    });
}
// Initial call to setup the graphs
amchart();