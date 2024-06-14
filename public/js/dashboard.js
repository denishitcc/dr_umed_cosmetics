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
am5.ready(function() {
    // Clients Graph start
    var clientsRoot = am5.Root.new("clientchartdiv");

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
    clientsSeries.data.setAll(clientsData);

    // Make Clients Graph animate on load
    clientsChart.appear(1000, 100);
    // Clients Graph end
    
    // Enquiry Chart start
    var enquiryRoot = am5.Root.new("enquirychartdiv");

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
    console.log('EnquiryGraph',EnquiryGraph);
    // Prepare data for Enquiry Chart
    var enquiryData = EnquiryGraph.map(enquiry => {
        return {
            date: new Date(enquiry.date).getTime(),
            value: parseInt(enquiry.count) // Ensure value is an integer
        };
    });

    // Set data for Enquiry Chart
    enquirySeries.data.setAll(enquiryData);

    // Make Enquiry Chart animate on load
    enquiryChart.appear(1000, 100);
    // Enquiry Chart end
});

//filter 
// Event listener for location dropdown change
$('#locations').change(function() {
    var reportRange = $('#reportrange').text().trim(); // This should be adjusted if it doesn't give you the actual date range
    var location = $(this).val();
    filterData(reportRange, location);
});

// Function to handle data filtering based on report range and location
function filterData(reportRange, location) {
    console.log("Filtering data for Report Range:", reportRange, "and Location:", location);
    $.ajax({
        url: FilterRoute,
        type: 'POST',
        data: {
            reportRange: reportRange,
            location: location
        },
        success: function(response) {
            // Handle success response from server
            console.log("Filtering successful:", response);
            //total sales filter
            var totalSales = parseInt(response.totalSales);
            var expectedSales = parseInt(response.expected);
            $('.made_so_far').text('$' + totalSales);
            $('.expected').text('$' + (expectedSales));

            // Calculate the percentage remaining for the progress bar
            var percentageRemaining;
            if ((totalSales) === 0) {
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
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Error filtering data:", error);
            // Display error message or perform fallback actions
        }
    });
}
