//tooltip with progrssbar
$(function () {
    $('[data-toggle="tooltip"]').tooltip({ trigger: 'manual' }).tooltip('show');
});

$(".progress-bar").each(function () {
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
$(function () {
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
    $('#reportrange').on('apply.daterangepicker', function (e, picker) {
        var reportRange = picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY');
        var location = $('#locations').val();
        filterData(reportRange, location);
    });

    cb(start, end);
});

//filter 
// Event listener for location dropdown change
$('#locations').change(function () {
    var reportRange = $('#reportrange').text().trim(); // This should be adjusted if it doesn't give you the actual date range
    var location = $(this).val();
    filterData(reportRange, location);
});

//appointments calendar start
$("#mycalendar").datepicker({
    dateFormat: 'yy-mm-dd' // Customize the date format as needed
});

$(".fc-today-button").click(function () {
    var todayDt = moment(context.calendar.currentData.dateProfile.currentDate).format('YYYY-MM-DD');
    $('#mycalendar').datepicker().datepicker('setDate', new Date(todayDt));
});

// Change calendar view based on user input
$('#mycalendar').change(function (e) {
    e.preventDefault();
    var inputValue = $(this).val();
    $('.view_all_appt').attr('appt-date', inputValue);

    // Fetch today's date
    var todayDate = moment().format('YYYY-MM-DD');

    // Fetch today's appointments if selected date matches today's date
    var isToday = moment(inputValue).isSame(todayDate, 'day');
    var headerText = isToday ? "Today's appointments" : `${moment(inputValue).format('DD MMMM')} appointments`;
    $('.error').remove();
    //fetch today's appointments

    var location_ids = $('#locations').val();
    $.ajax({
        url: TodayAppointments, // Replace with your actual API endpoint
        type: 'POST',
        dataType: 'json',
        data: { date: inputValue, location_ids: location_ids }, // Send the period as a parameter to the server
        success: function (data) {
            var appointmentsContainer = $('.black_calendar_appointment');
            var appointmentHeader = $('.all_appt h5');

            appointmentHeader.text(headerText); // Update the header text

            appointmentsContainer.empty(); // Clear the current list

            if (data.length > 0) {
                data.forEach(function (appt) {
                    var clientName = appt.firstname && appt.lastname ? `${appt.firstname} ${appt.lastname}` : "No Client";
                    var appointmentHtml = `
                        <li class="edit_appt" id="${appt.id}" loc-id="${appt.location_id}">
                            <div class="d-flex justify-content-between">
                                <b class="doc_name">${clientName}</b>
                                <span class="app_time">${moment(appt.start_date).format('h:mm A')}</b>
                            </div>
                            <span class="service_name">${appt.service_name} with <b>${appt.staff.first_name} ${appt.staff.last_name}</b></span>`;

                    if (appt.note && appt.note.common_notes) {
                        let commonNotes = appt.note.common_notes;
                        let truncatedNotes = commonNotes.length > 20 ? commonNotes.substring(0, 20) + '...' : commonNotes;
                        appointmentHtml += `<div class="notes">Booking Note: ${truncatedNotes}</div>`;
                    }

                    appointmentHtml += `</li>`;
                    appointmentsContainer.append(appointmentHtml);
                });
            } else {
                $('.all_appt').after('<span class="error">No appointments for the selected date.</span>');
            }
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
});

$('.view_all_appt').click(function () {
    var date = $(this).attr('appt-date');
    window.location.href = '/calender?appt_date=' + date;
});

$(document).on('click', '.edit_appt', function (e) {
    var appointmentId = $(this).attr('id');
    var locationId = $(this).attr('loc-id');

    // Store the appointment ID in local storage
    localStorage.setItem('appointmentId', appointmentId);
    localStorage.setItem('locationId', locationId);
    // Redirect to the calendar page
    window.location.href = '/calender';
})
//client tab status change start
$(document).on('click','.flexSwitchCheckDefault',function(){
    var id =$(this).attr('ids');
    var chk = $(this).val();
    var url = "clients/updateStatus";
    $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data: {// change data to this object
          _token : $('meta[name="csrf-token"]').attr('content'), 
          id:id,
          chk:chk
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
      
      Swal.fire({
        title: "Client Status!",
        text: "Client Status updated successfully.",
        icon: "success",
      }).then((result) => {
              window.location = "dashboard"//'/player_detail?username=' + name;
            // location.reload();
          });
    } else {
      Swal.fire({
        title: "Error!",
        text: response.message,
        icon: "error",
      });
    }
        },
        error: function (jqXHR, exception) {

        }
    });
})
//client tab status change end
//appointments calendar end

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
var SalesPerformanceFilterData = [];
var dayData, weekData, monthData;
var salesfilter = 1;
var salesPerformanceRoot; // Declare salesPerformanceRoot globally
var chart; // Declare chart globally
var xAxis; // Declare xAxis globally
var SalesPerformanceyAxis; // Declare SalesPerformanceyAxis globally
var currentData = []; // Declare currentData globally
var legend; // Declare legend globally
var clientGraphRoot, clientGraphChart, clientGraphXAxis, clientGraphLegend;
// var chartTopSellingTreatments,rootTopSellingTreatments,xAxisTopSellingTreatments,yAxisTopSellingTreatments;
var rootTopSellingTreatments, chartTopSellingTreatments, xAxisTopSellingTreatments, yAxisTopSellingTreatments;
var currentData = {};
var treatmentlegend;
function filterData(reportRange, location) {
    //for appointment component start
    $('.error').remove();
    var todayDate = moment().format('YYYY-MM-DD');
    var inputValue = $('#mycalendar').val();
    var isToday = moment(inputValue).isSame(todayDate, 'day');
    var headerText = isToday ? "Today's appointments" : `${moment(inputValue).format('DD MMMM')} appointments`;
    //for appointment component end
    $.ajax({
        url: FilterRoute,
        type: 'POST',
        data: {
            reportRange: reportRange,
            location: location,
            date: inputValue//for appointment component
        },
        success: function (response) {
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
            console.log('all_Data_filter', GenderFilterData);
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

            isfilter_client = 1;
            isfilter_enquiry = 1;
            isfilter_gender = 1;
            salesfilter = 0;

            //Appointment location filter
            if (response.appointmentComp.length > 0) {
                var appointmentsContainer = $('.black_calendar_appointment');
                var appointmentHeader = $('.all_appt h5');

                appointmentHeader.text(headerText); // Update the header text

                appointmentsContainer.empty(); // Clear the current list

                response.appointmentComp.forEach(function (appt) {
                    var clientName = appt.firstname && appt.lastname ? `${appt.firstname} ${appt.lastname}` : "No Client";
                    var appointmentHtml = `
                        <li class="edit_appt" id="${appt.id}" loc-id="${appt.location_id}">
                            <div class="d-flex justify-content-between">
                                <b class="doc_name">${clientName}</b>
                                <span class="app_time">${moment(appt.start_date).format('h:mm A')}</b>
                            </div>
                            <span class="service_name">${appt.service_name} with <b>${appt.staff.first_name} ${appt.staff.last_name}</b></span>`;

                    if (appt.note && appt.note.common_notes) {
                        let commonNotes = appt.note.common_notes;
                        let truncatedNotes = commonNotes.length > 20 ? commonNotes.substring(0, 20) + '...' : commonNotes;
                        appointmentHtml += `<div class="notes">Booking Note: ${truncatedNotes}</div>`;
                    }

                    appointmentHtml += `</li>`;
                    appointmentsContainer.append(appointmentHtml);
                });
            } else {
                var appointmentsContainer = $('.black_calendar_appointment');
                var appointmentHeader = $('.all_appt h5');

                appointmentHeader.text(headerText); // Update the header text

                appointmentsContainer.empty(); // Clear the current list
                $('.all_appt').after('<span class="error">No appointments for the selected date.</span>');
            }
            amchart(ClientFilterData, EnquiryFilterData, GenderFilterData, salesfilter);
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error("Error filtering data:", error);
            // Display error message or perform fallback actions
        }
    });
}
var gender_ration_root; // Declare variable for root instance
function amchart(ClientFilterData = [], EnquiryFilterData = [], GenderFilterData = [], salesfilter, filterType = 'month') {
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

    am5.ready(function () {
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
            console.log('ClientFilterData', ClientFilterData);
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
            console.log('clientsData', clientsData);
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
            console.log('EnquiryFilterData', EnquiryFilterData);
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
            console.log('EnquiryData', enquiryData);
            enquirySeries.data.setAll(enquiryData);
        }

        // Make Enquiry Chart animate on load
        enquiryChart.appear(1000, 100);
        // Enquiry Chart end

        // Sales Performance Chart start
        if (salesfilter == undefined) {
            createSalesPerformanceChart();
        }

        //Gender ratio start
        // Set up data
        //if filter
        if (GenderFilterData.length > 0) {
            // Initialize an array to store pie chart data
            var data = [];
            console.log('GenderFilterData', GenderFilterData);
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
        } else {
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
        console.log('all_Data', data);

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
        pieSeries.slices.template.on("active", function (active, slice) {
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
        pieSeries.events.on("datavalidated", function () {
            if (pieSeries.slices.length > 0) {
                pieSeries.slices.getIndex(0).set("active", true);
            }
        });

        // Add legend
        var legend = pieChart.children.push(am5.Legend.new(gender_ration_root, {
            centerX: am5.p50,
            x: am5.p50,
            y: am5.p100,
            dy: -28,  // Adjust this value to position the legend properly
            marginTop: 15,
            marginBottom: 15
        }));

        legend.data.setAll(pieSeries.dataItems);

        // Client's Ratio Chart start
        // Create new instances of charts
        createClientRatioChart();

        // Fetch and update client ratio chart data
        filterClientRatioData('month');
        // Client's Ratio Chart end

        // Generate random data
        // Define static data for each treatment
        createTopSellingTreatmentsChart();
        filterTopSellingTreatmentData('month');

    });
}

//start
// Function to filter service
// Define legend variable globally
var legend,dateFormatter;
var currentPeriod = 'month';
var currentData = {};

// Function to filter service
function filterService(period) {
    $.ajax({
        url: SellingTreatmentsServiceNameFilter,
        type: 'POST',
        dataType: 'json',
        data: { period: period },
        success: function (data) {
            var colors = ["#1f77b4", "#2ca02c", "#ff7f0e", "#d62728"];

            // Clear existing legend and series
            if (legend) {
                legend.dispose();
            }
            chartTopSellingTreatments.series.clear();

            for (var i = 0; i < data.length; i++) {
                var serviceName = data[i];
                if (serviceName) {
                    var color = colors[i % colors.length];
                    createTopSellingTreatmentsSeries(serviceName, [], color);
                }
            }

            // Add new legend after series are created
            legend = chartTopSellingTreatments.children.push(
                am5.Legend.new(rootTopSellingTreatments, {
                    centerX: am5.p50,
                    x: am5.p50,
                    y: am5.percent(100),
                    dy: -28,
                    centerY: am5.p100,
                    layout: rootTopSellingTreatments.horizontalLayout
                })
            );

            // Add series to legend
            legend.data.setAll(chartTopSellingTreatments.series.values);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}
// Function to set the baseInterval and create the x-axis
function setBaseIntervalAndXAxis(period) {

    let baseInterval, tooltipDateFormat;

    if (period === 'month') {
        baseInterval = { timeUnit: "month", count: 1 };
        tooltipDateFormat = "MMM";
    } else if (period === 'week') {
        baseInterval = { timeUnit: "week", count: 1 };
        tooltipDateFormat = "dd MMM"; // or any other desired format for weeks
    } else if (period === 'day') {
        baseInterval = { timeUnit: "day", count: 1 };
        tooltipDateFormat = "yyyy-MM-dd";
    }

    // Clear existing x-axis before creating a new one
    chartTopSellingTreatments.xAxes.clear();

    // Create x-axis
    xAxisTopSellingTreatments = chartTopSellingTreatments.xAxes.push(
        am5xy.DateAxis.new(rootTopSellingTreatments, {
            baseInterval: baseInterval,
            renderer: am5xy.AxisRendererX.new(rootTopSellingTreatments, {
                cellStartLocation: 0.1,
                cellEndLocation: 0.9,
                minGridDistance: 10
            }),
            tooltip: am5.Tooltip.new(rootTopSellingTreatments, {}),
            tooltipDateFormat: tooltipDateFormat
        })
    );

    // Add custom tooltip formatter for x-axis
    xAxisTopSellingTreatments.get("tooltip").label.adapters.add("text", function (text, target) {
        var dataItem = target.dataItem;
        if (dataItem) {
            var startDate = new Date(dataItem.get("valueX"));

            if (currentPeriod === 'week') {
                var endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + 6); // Set end date to 6 days later

                var startFormat = dateFormatter.format(startDate, "dd MMM");
                var endFormat = dateFormatter.format(endDate, "dd MMM");

                return startFormat + " - " + endFormat;
            }
            if (currentPeriod === 'month') {
                return dateFormatter.format(startDate, "MMM");
            }
            if (currentPeriod === 'day') {
                return dateFormatter.format(startDate, "yyyy-MM-dd");
            }
        }
        return text;
    });

    // Add custom label formatter for x-axis
    xAxisTopSellingTreatments.get("renderer").labels.template.adapters.add("text", function (text, target) {
        var dataItem = target.dataItem;
        if (dataItem) {
            var startDate = new Date(dataItem.get("value"));

            if (currentPeriod === 'week') {
                var endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + 6); // Set end date to 6 days later

                var startFormat = dateFormatter.format(startDate, "dd MMM");
                var endFormat = dateFormatter.format(endDate, "dd MMM");

                return startFormat + " - " + endFormat;
            }
            if (currentPeriod === 'month') {
                return dateFormatter.format(startDate, "MMM");
            }
            if (currentPeriod === 'day') {
                return dateFormatter.format(startDate, "dd-MM-yy");
            }
        }
        return text;
    });
}
// Function to create the chart
function createTopSellingTreatmentsChart() {
    // Create root element
    rootTopSellingTreatments = am5.Root.new("TopSellingTreatmentsChartdiv");

    // Remove amChart logo
    rootTopSellingTreatments._logo.dispose();

    // Set themes
    rootTopSellingTreatments.setThemes([
        am5themes_Animated.new(rootTopSellingTreatments)
    ]);

    // Create chart
    chartTopSellingTreatments = rootTopSellingTreatments.container.children.push(
        am5xy.XYChart.new(rootTopSellingTreatments, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            maxTooltipDistance: 0,
            width: am5.percent(100)
        })
    );

    // Add cursor
    var cursorTopSellingTreatments = chartTopSellingTreatments.set("cursor", am5xy.XYCursor.new(rootTopSellingTreatments, {
        behavior: "zoomX"
    }));
    cursorTopSellingTreatments.lineY.set("visible", false);

    // Create date formatter
    dateFormatter = am5.DateFormatter.new(rootTopSellingTreatments, {});

    // Set baseInterval and x-axis for the initial period
    setBaseIntervalAndXAxis(currentPeriod);

    // Create y-axis
    yAxisTopSellingTreatments = chartTopSellingTreatments.yAxes.push(
        am5xy.ValueAxis.new(rootTopSellingTreatments, {
            renderer: am5xy.AxisRendererY.new(rootTopSellingTreatments, {}),
            extraTooltipPrecision: 2
        })
    );
}
// Function to create a series
function createTopSellingTreatmentsSeries(name, data, color) {
    var series = chartTopSellingTreatments.series.push(
        am5xy.LineSeries.new(rootTopSellingTreatments, {
            name: name,
            xAxis: xAxisTopSellingTreatments,
            yAxis: yAxisTopSellingTreatments,
            valueYField: "price",
            valueXField: "date",
            tooltip: am5.Tooltip.new(rootTopSellingTreatments, {
                labelText: "{valueY}"
            }),
            stroke: am5.color(color),
            fill: am5.color(color)
        })
    );

    series.data.setAll(data); // Set the data array for the series

    return series; // Return the created series if needed
}
// Function to fetch data
function fetchTopSellingTreatmentsData(period, callback) {
    $.ajax({
        url: SellingTreatmentsFilter,
        type: 'POST',
        dataType: 'json',
        data: { period: period },
        success: function (data) {
            callback(data);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}
// Function to filter data based on the period
function filterTopSellingTreatmentData(period) {
    currentPeriod = period;
    setBaseIntervalAndXAxis(period);
    filterService(period);
    fetchTopSellingTreatmentsData(period, function (data) {
        currentData = data;
        updateTopSellingTreatmentsChart(period);
    });
}
// Function to update the chart with new data
function updateTopSellingTreatmentsChart(period) {
    if (!currentData) {
        console.error('No data fetched or data format incorrect.');
        return;
    }

    // Update each series with new data
    chartTopSellingTreatments.series.each(function (series) {
        var seriesName = series.get("name");
        if (currentData[seriesName]) {
            series.data.setAll(currentData[seriesName]);
        } else {
            console.warn('Data for series', seriesName, 'not found in currentData.');
        }
    });

    console.log('Chart updated with new data for period:', period);
}
function createSalesPerformanceChart() {
    salesPerformanceRoot = am5.Root.new("Salesperformancechartdiv");

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
    legend = chart.children.push(
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

    SalesPerformanceyAxis = chart.yAxes.push(am5xy.ValueAxis.new(salesPerformanceRoot, {
        renderer: am5xy.AxisRendererY.new(salesPerformanceRoot, {
            strokeOpacity: 0.1
        })
    }));

    // Add "IN AUD" label to y-axis
    SalesPerformanceyAxis.children.push(am5.Label.new(salesPerformanceRoot, {
        rotation: -90,
        text: "IN AUD",
        y: am5.p50,
        centerX: am5.p50
    }));

    // Initial chart setup
    createSalesPerformanceSeries("Expected", "expected", am5.color(0x2E93FA)); // Blue color
    createSalesPerformanceSeries("Achieved", "achieved", am5.color(0xFFAD33)); // Orange color

    // Call updateSalesPerformanceChart to set initial data
    filterSalesPerformaceData('month');
}
function createSalesPerformanceSeries(name, fieldName, color) {
    var series = chart.series.push(am5xy.ColumnSeries.new(salesPerformanceRoot, {
        name: name,
        xAxis: xAxis,
        yAxis: SalesPerformanceyAxis,
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

    series.bullets.push(function () {
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
function fetchSalesData(period, callback) {
    $.ajax({
        url: SalesPerformanceFilter, // Replace with your actual API endpoint
        type: 'POST',
        dataType: 'json',
        data: { period: period }, // Send the period as a parameter to the server
        success: function (data) {
            callback(data);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}
function filterSalesPerformaceData(period) {
    fetchSalesData(period, function (data) {
        currentData = data;
        updateSalesPerformanceChart();
    });
}
function updateSalesPerformanceChart() {
    xAxis.data.setAll(currentData);
    chart.series.each(function (series) {
        series.data.setAll(currentData);
    });
}
function createClientRatioChart() {
    clientGraphRoot = am5.Root.new("ClientRatioChartdiv");
    clientGraphRoot.setThemes([am5themes_Animated.new(clientGraphRoot)]);
    clientGraphRoot._logo.dispose();

    clientGraphChart = clientGraphRoot.container.children.push(am5xy.XYChart.new(clientGraphRoot, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: clientGraphRoot.verticalLayout
    }));

    clientGraphLegend = clientGraphChart.children.push(am5.Legend.new(clientGraphRoot, {
        centerX: am5.p50,
        x: am5.p50
    }));

    clientGraphXAxis = clientGraphChart.xAxes.push(am5xy.CategoryAxis.new(clientGraphRoot, {
        categoryField: "category",
        renderer: am5xy.AxisRendererX.new(clientGraphRoot, {
            cellStartLocation: 0.1,
            cellEndLocation: 0.9,
            minGridDistance: 10
        }),
        tooltip: am5.Tooltip.new(clientGraphRoot, {})
    }));

    clientGraphXAxis.get("renderer").labels.template.adapters.add("text", function (text, target) {
        if (target.dataItem) {
            var category = target.dataItem.get("category");
            return category;
        }
        return text;
    });

    clientGraphXAxis.get("renderer").grid.template.set("forceHidden", true);

    clientGraphYAxis = clientGraphChart.yAxes.push(am5xy.ValueAxis.new(clientGraphRoot, {
        renderer: am5xy.AxisRendererY.new(clientGraphRoot, {})
    }));

    // Example function to create series for client ratio chart
    createClientRatioSeries("Returning Clients", "returning_client_appt", am5.color(0xFF6165));
    createClientRatioSeries("New Clients", "new_clients", am5.color(0x00E396));
    createClientRatioSeries("Rebooked Clients", "rebooked_client_appt", am5.color(0xFFAD33));
    createClientRatioSeries("Casual Clients", "casual_clients", am5.color(0x58A9FB));

    clientGraphChart.appear(1000, 100);
}
function createClientRatioSeries(name, fieldName, color) {
    var clientGraphSeries = clientGraphChart.series.push(am5xy.ColumnSeries.new(clientGraphRoot, {
        name: name,
        xAxis: clientGraphXAxis,
        yAxis: clientGraphYAxis,
        stacked: true,
        valueYField: fieldName,
        categoryXField: "category",
        stroke: color,
        fill: color
    }));

    clientGraphSeries.columns.template.setAll({
        tooltipText: "{name}, {categoryX}: {valueY}",
        width: am5.percent(90),
        tooltipY: 0
    });

    clientGraphLegend.data.push(clientGraphSeries);
}
function filterClientRatioData(period) {
    fetchClientRatioData(period, function (data) {
        updateClientRatioChart(data);
    });
}
function fetchClientRatioData(period, callback) {
    $.ajax({
        url: ClientRatioFilter, // Replace with your actual API endpoint
        type: 'POST',
        dataType: 'json',
        data: { period: period }, // Send the period as a parameter to the server
        success: function (data) {
            callback(data);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}
function updateClientRatioChart(data) {
    console.log('Updating Client Ratio Chart:', data);
    if (clientGraphXAxis && clientGraphChart) {
        clientGraphXAxis.data.setAll(data);
        clientGraphChart.series.each(function (series) {
            series.data.setAll(data);
        });
    } else {
        console.error('clientGraphXAxis or clientGraphChart is undefined.');
    }
}
// Initial call to setup the graphs
amchart();