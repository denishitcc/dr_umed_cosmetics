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
var GenderFilterData = [];
var isfilter_client = 0;
var isfilter_enquiry = 0;
var isfilter_gender = 0;
var clientsRoot, enquiryRoot, xAxis, chart, currentData
var isfilter_sales_performance = 0;
var SalesPerformanceFilterData=[];
var dayData, weekData, monthData;
var salesfilter = 1;

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

            //gender filter
            var GenderFilterData = response.genderGraph;

            // console.log(genderRatioData);
            console.log('all_Data_filter',GenderFilterData);
            if (GenderFilterData) {
                GenderFilterData = [
                    {
                        category: "Women", 
                        value: GenderFilterData.Female ? parseInt(GenderFilterData.Female) : 0, 
                        sliceSettings: { fill: am5.color(0x00B678) }
                    }, 
                    {
                        category: "Men", 
                        value: GenderFilterData.Male ? parseInt(GenderFilterData.Male) : 0, 
                        sliceSettings: { fill: am5.color(0x82BEFC) }
                    }
                ];
            }

            isfilter_client=1;
            isfilter_enquiry=1;
            isfilter_gender=1;
            salesfilter=0;
            amchart(ClientFilterData,EnquiryFilterData,GenderFilterData,salesfilter);
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Error filtering data:", error);
            // Display error message or perform fallback actions
        }
    });
}
var gender_ration_root; // Declare variable for root instance
function amchart(ClientFilterData = [],EnquiryFilterData = [], GenderFilterData= [],salesfilter,filterType = 'month') {
    if (clientsRoot) {
        clientsRoot.dispose();
    }
    if (enquiryRoot) {
        enquiryRoot.dispose();
    }
    if (enquiryRoot) {
        enquiryRoot.dispose();
    }
    // Dispose of existing root instance if it exists
    if (gender_ration_root) {
        gender_ration_root.dispose();
    }

    // Create a new root instance
    gender_ration_root = am5.Root.new("GenderRatiochartdiv");

    // Set up themes
    gender_ration_root.setThemes([am5themes_Animated.new(gender_ration_root)]);

    // Remove logo (optional)
    gender_ration_root._logo.dispose();

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
        if(salesfilter == undefined)
        {
            var salesPerformanceRoot = am5.Root.new("Salesperformancechartdiv");

            var currentData = [];

            // Set themes
            salesPerformanceRoot.setThemes([
                am5themes_Animated.new(salesPerformanceRoot)
            ]);

            salesPerformanceRoot._logo.dispose();
            
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
                minorGridEnabled: true,
                minGridDistance: 30,
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
            filterSalesPerformaceData('month');
            //Sales performance chart end
        }

        //Gender ratio start
        // Set up data
        //if filter
        if (GenderFilterData.length > 0) {
            // Initialize an array to store pie chart data
            var data = [];
            console.log('GenderFilterData',GenderFilterData);
            // Iterate through each item in GenderFilterData
            GenderFilterData.forEach(item => {
                // Construct data for each category (Women and Men)
                data.push({
                    category: item.category === 'Women' ? "Women" : "Men", // Assuming item has a property like 'gender' to distinguish Female/Male
                    value: parseInt(item.value), // Assuming item has a property like 'count' for the value
                    sliceSettings: {
                        fill: item.category === 'Women' ? am5.color(0x00B678) : am5.color(0x82BEFC) // Adjust fill based on gender
                    }
                });
            });
        } else{
            //if Current month data by default
            var genderRatioData = gender_ratio;
            console.log(genderRatioData);
    
            var data = [
                {
                    category: "Women", 
                    value: genderRatioData.Female ? parseInt(genderRatioData.Female) : 0, 
                    sliceSettings: { fill: am5.color(0x00B678) }
                }, 
                {
                    category: "Men", 
                    value: genderRatioData.Male ? parseInt(genderRatioData.Male) : 0, 
                    sliceSettings: { fill: am5.color(0x82BEFC) }
                }
            ];
        }
        console.log('all_Data',data);

        var pieChart = gender_ration_root.container.children.push(am5percent.PieChart.new(gender_ration_root, {
            width: am5.p100,
            height: am5.p100,
            innerRadius: am5.percent(50)
        }));

        // Configure pie series
        var pieSeries = pieChart.series.push(am5percent.PieSeries.new(gender_ration_root, {
            valueField: "value",
            categoryField: "category"
        }));

        pieSeries.slices.template.setAll({
            templateField: "sliceSettings",
            strokeOpacity: 0
        });

        // Handle slice selection
        var currentSlice;
        pieSeries.slices.template.on("active", function(active, slice) {
            if (currentSlice && currentSlice != slice && active) currentSlice.set("active", false);

            label1.setAll({
                fill: slice.get("fill"),
                text: gender_ration_root.numberFormatter.format(slice.dataItem.get("valuePercentTotal"), "#.'%'")
            });

            label2.set("text", slice.dataItem.get("category"));

            currentSlice = slice;
        });

        pieSeries.labels.template.set("forceHidden", true);
        pieSeries.ticks.template.set("forceHidden", true);
        pieSeries.data.setAll(data);

        // Labels setup
        var label1 = pieChart.seriesContainer.children.push(am5.Label.new(gender_ration_root, {
            text: "",
            fontSize: 35,
            fontWeight: "bold",
            centerX: am5.p50,
            centerY: am5.p50
        }));

        var label2 = pieChart.seriesContainer.children.push(am5.Label.new(gender_ration_root, {
            text: "",
            fontSize: 12,
            centerX: am5.p50,
            centerY: am5.p50,
            dy: 30
        }));

        // Ensure first slice is active
        pieSeries.events.on("datavalidated", function() {
            if (pieSeries.slices.length > 0) {
                pieSeries.slices.getIndex(0).set("active", true);
            }
        });

        // Add legend
        var legend = pieChart.children.push(am5.Legend.new(gender_ration_root, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));

        legend.data.setAll(pieSeries.dataItems);
    });
}
function fetchSalesData(period, callback) {
    $.ajax({
        url: SalesPerformanceFilter, // Replace with your actual API endpoint
        type: 'POST',
        dataType: 'json',
        data: { period: period }, // Send the period as a parameter to the server
        success: function(data) {
            callback(data);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
}
function filterSalesPerformaceData(period) {
    fetchSalesData(period, function(data) {
        currentData = data;
        updateSalesPerformanceChart();
    });
}

function updateSalesPerformanceChart() {
    xAxis.data.setAll(currentData);
    chart.series.each(function(series) {
        series.data.setAll(currentData);
    });
}
// Initial call to setup the graphs
amchart();