"use strict";

// Class definition
var KTamChartsChartsDemo = function () {

    // Private functions
    var demo1 = function () {
        var chart = AmCharts.makeChart("kt_amcharts_1", {
            "type": "serial",
            "categoryField": "category",
            "startDuration": 1,
            "fontSize": 13,
            "theme": "light",
            "categoryAxis": {
                "gridPosition": "start"
            },
            "trendLines": [],
            "graphs": [{
                    "balloonText": "[[title]] of [[category]]:[[value]]",
                    "fillAlphas": 1,
                    "id": "AmGraph-1",
                    "legendColor": "undefined",
                    "title": "Sales",
                    "type": "column",
                    "valueField": "column-1"
                },
                {
                    "balloonText": "[[title]] of [[category]]:[[value]]",
                    "color": "#674E4E",
                    "fillAlphas": 1,
                    "id": "AmGraph-2",
                    "title": "Acquisition",
                    "type": "column",
                    "valueField": "column-2"
                }
            ],
            "guides": [],
            "valueAxes": [{
                "id": "ValueAxis-1",
                "title": "Axis title"
            }],
            "allLabels": [],
            "balloon": {},
            "legend": {
                "enabled": true,
                "useGraphSettings": true
            },
            "titles": [{
                "id": "Title-1",
                "size": 15,
                "text": "Monthly Commissions"
            }],
            "dataProvider": [{
                    "category": "Oct 2018",
                    "column-1": 8,
                    "column-2": 13
                },
                {
                    "category": "Nov 2018",
                    "column-1": 6,
                    "column-2": 30
                },
                {
                    "category": "Dec 2018",
                    "column-1": 2,
                    "column-2": 74
                },
                {
                    "category": "Jan 2019",
                    "column-1": "45",
                    "column-2": 56
                },
                {
                    "category": "Feb 2019",
                    "column-1": "78",
                    "column-2": 53
                },
                {
                    "category": "Mar 2019",
                    "column-1": "34",
                    "column-2": 13
                },
                {
                    "category": "Apr 2019",
                    "column-1": "56",
                    "column-2": ""
                },
                {
                    "category": "May 2019",
                    "column-1": null,
                    "column-2": ""
                },
                {
                    "category": "Jun 2019",
                    "column-1": null,
                    "column-2": 69
                },
                {
                    "category": "Jul 2019",
                    "column-1": null,
                    "column-2": 23
                },
                {
                    "category": "Aug 2019",
                    "column-1": null,
                    "column-2": 94
                },
                {
                    "category": "Sep 2019",
                    "column-1": null,
                    "column-2": 82
                }
            ],
            "valueAxes": [{
                "gridColor": "#FFFFFF",
                "gridAlpha": 0.2,
                "dashLength": 0
            }]

        });
    };


    return {
        // public functions
        init: function () {
            demo1();
        }
    };
}();

jQuery(document).ready(function () {
    KTamChartsChartsDemo.init();
});