$(document).ready(function() {
    
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
});
am5.ready(function() {
    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");
    // let scale = 1.1;
    // const root = am5.Root.new("chartdiv", {
    //     calculateSize: (dimensions) => {
    //         return {
    //         width: dimensions.width * scale,
    //         height: dimensions.height * scale,
    //         };
    //     },
    // });

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Disable logo
    root._logo.dispose();

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",
        pinchZoomX: false,
        paddingLeft: 0
    }));

    // Generate random data
    var date = new Date();
    date.setHours(0, 0, 0, 0);

    var value = 20;
    function generateData() {
        value = am5.math.round(Math.random() * 10 - 4.8 + value, 1);
        if (value < 0) {
            value = Math.random() * 10;
        }
        if (value > 100) {
            value = 100 - Math.random() * 10;
        }
        am5.time.add(date, "day", 1);
        return {
            date: date.getTime(),
            value: value
        };
    }

    function generateDatas(count) {
        var data = [];
        for (var i = 0; i < count; ++i) {
            data.push(generateData());
        }
        return data;
    }

    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
    baseInterval: {
        timeUnit: "day",
        count: 1
    },
    renderer: am5xy.AxisRendererX.new(root, {
        minorGridEnabled: true,
        minGridDistance: 90
    })
    }));
    xAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide x-axis labels
    xAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide x-axis grid

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));
    yAxis.get("renderer").labels.template.set("forceHidden", true);  // Hide y-axis labels
    yAxis.get("renderer").grid.template.setAll({ visible: false }); // Hide y-axis grid

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Series",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        valueXField: "date",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
        })
    }));

    series.fills.template.setAll({
        fillOpacity: 0.2,
        visible: true
    });

    // Prepare data
    var data = dailyClients.map(item => {
        return {
            date: new Date(item.date).getTime(),
            value: item.count
        };
    });

    // Set data
    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);

}); // end am5.ready()