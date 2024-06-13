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