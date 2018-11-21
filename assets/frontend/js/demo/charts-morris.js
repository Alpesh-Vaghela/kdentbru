// Charts.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
$(document).ready(function() {

    // MORRIS AREA CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================

    var day_data = [{
        year: "2008",
        value: 10
    }, {
        year: "2009",
        value: 15
    }, {
        year: "2010",
        value: 5
    }, {
        year: "2011",
        value: 15
    }, {
        year: "2012",
        value: 10
    }, {
        year: "2013",
        value: 15
    }];
    Morris.Area({
        element: 'demo-morris-area',
        data: day_data,
        xkey: 'year',
        ykeys: ['value'],
        labels: ['value'],
        gridEnabled: true,
        lineColors: ['#29b7d3'],
        lineWidth: 2,
        pointSize: 2,
        pointStrokeColors: ['#FFFFFF'],
        parseTime: false,
        resize: true,
        fillOpacity: 0.7,
        hideHover: 'auto'
    });


    // COMBINED AREA CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================

    month_data = [{
        month: "1",
        a: 400,
        b: 130
    }, {
        month: "2",
        a: 350,
        b: 180
    }, {
        month: "3",
        a: 400,
        b: 140
    }, {
        month: "4",
        a: 400,
        b: 250
    }, {
        month: "5",
        a: 450,
        b: 230
    }, {
        month: "6",
        a: 550,
        b: 170
    }, {
        month: "7",
        a: 480,
        b: 200
    }, {
        month: "8",
        a: 550,
        b: 260
    }, {
        month: "9",
        a: 500,
        b: 240
    }, {
        month: "10",
        a: 610,
        b: 350
    }, {
        month: "11",
        a: 520,
        b: 320
    }, {
        month: "12",
        a: 570,
        b: 370
    }];
    Morris.Area({
        element: 'demo-morris-combo-area',
        data: month_data,
        xkey: 'month',
        ykeys: ['a', 'b'],
        labels: ['value A', 'value B'],
        gridEnabled: true,
        lineColors: ['#3eb489', '#f0300b'],
        lineWidth: 2,
        parseTime: false,
        resize: true,
        hideHover: 'auto'
    });



    // MORRIS LINE CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    var day_data = [{
        year: "2008",
        value: 10
    }, {
        year: "2009",
        value: 15
    }, {
        year: "2010",
        value: 5
    }, {
        year: "2011",
        value: 15
    }, {
        year: "2012",
        value: 10
    }, {
        year: "2013",
        value: 15
    }];
    Morris.Line({
        element: 'demo-morris-line',
        data: day_data,
        xkey: 'year',
        ykeys: ['value'],
        labels: ['value'],
        gridEnabled: true,
        lineColors: ['#29b7d3'],
        lineWidth: 2,
        parseTime: false,
        resize: true,
        hideHover: 'auto'
    });


    // COMBINED LINE CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================

    month_data = [{
        month: "1",
        a: 400,
        b: 130
    }, {
        month: "2",
        a: 350,
        b: 180
    }, {
        month: "3",
        a: 400,
        b: 140
    }, {
        month: "4",
        a: 400,
        b: 250
    }, {
        month: "5",
        a: 450,
        b: 230
    }, {
        month: "6",
        a: 550,
        b: 170
    }, {
        month: "7",
        a: 480,
        b: 200
    }, {
        month: "8",
        a: 550,
        b: 260
    }, {
        month: "9",
        a: 500,
        b: 240
    }, {
        month: "10",
        a: 610,
        b: 350
    }, {
        month: "11",
        a: 520,
        b: 320
    }, {
        month: "12",
        a: 570,
        b: 370
    }];
    Morris.Line({
        element: 'demo-morris-combo',
        data: month_data,
        xkey: 'month',
        ykeys: ['a', 'b'],
        labels: ['value A', 'value B'],
        gridEnabled: true,
        lineColors: ['#3eb489', '#f0300b'],
        lineWidth: 2,
        parseTime: false,
        resize: true,
        hideHover: 'auto'
    });



    // MORRIS BAR CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    Morris.Bar({
        element: 'demo-morris-bar',
        data: [{
            y: '2009',
            a: 20,
            b: 16,
            c: 12
        }, {
            y: '2010',
            a: 10,
            b: 22,
            c: 30
        }, {
            y: '2011',
            a: 5,
            b: 14,
            c: 20
        }, {
            y: '2012',
            a: 5,
            b: 12,
            c: 19
        }, {
            y: '2013',
            a: 20,
            b: 19,
            c: 13
        }, {
            y: '2014',
            a: 28,
            b: 22,
            c: 20
        }, ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Series A', 'Series B', 'Series C'],
        gridEnabled: true,
        barColors: ['#E9422E', '#FAC552', '#3eb489'],
        resize: true,
        hideHover: 'auto'
    });



    // MORRIS STACK BAR CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    Morris.Bar({
        element: 'demo-morris-stack-bar',
        data: [{
            y: '2009',
            a: 20,
            b: 16,
            c: 12
        }, {
            y: '2010',
            a: 10,
            b: 22,
            c: 30
        }, {
            y: '2011',
            a: 5,
            b: 14,
            c: 20
        }, {
            y: '2012',
            a: 5,
            b: 12,
            c: 19
        }, {
            y: '2013',
            a: 20,
            b: 19,
            c: 13
        }, {
            y: '2014',
            a: 28,
            b: 22,
            c: 20
        }, ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Series A', 'Series B', 'Series C'],
        gridEnabled: true,
        barColors: ['#E9422E', '#FAC552', '#3eb489'],
        resize: true,
        stacked: true,
        hideHover: 'auto'
    });



    // MORRIS DONUT CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    Morris.Donut({
        element: 'demo-morris-donut',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "COD Sales",
            value: 40
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        colors: ['#679dc6', '#3980b5', '#95BBD7', '#0B62A4'],
        resize: true
    });

    // COLORFUL MORRIS DONUT CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    Morris.Donut({
        element: 'demo-morris-color-donut',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "COD Sales",
            value: 40
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        colors: ['#E9422E', '#FAC552', '#3eb489', '#29b7d3'],
        resize: true
    });

    // FORMATTED MORRIS DONUT CHART
    // =================================================================
    // Require MorrisJS Chart
    // -----------------------------------------------------------------
    // http://morrisjs.github.io/morris.js/
    // =================================================================
    Morris.Donut({
        element: 'demo-morris-formatted-donut',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "COD Sales",
            value: 40
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        formatter: function(x) {
            return '$' + Morris.pad2(x % 60)
        },
        colors: ['#679dc6', '#3980b5', '#95BBD7', '#0B62A4'],
        resize: true,
    });

});