<div class="card card-flush h-xl-50">
    <!--begin::Header-->
    <div class="card-header py-5">
        <!--begin::Title-->
        <h3 class="card-title fw-bold text-gray-800">Bookings</h3>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
            <div id="datePicker_20" data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4 datePicker">
                <!--begin::Display range-->
                <div class="text-gray-600 fw-bold">Loading date range...</div>
                <!--end::Display range-->
                <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                    <span class="path6"></span>
                </i>
            </div>
            <!--end::Daterangepicker-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
        <!--begin::Items-->
        <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">
            <!--begin::Item-->
            <div class="me-md-2">
                <!--begin::Statistics-->
                <div class="d-flex mb-2">
                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$total_sums_20}}</span>
                    <span class="fs-4 fw-semibold text-gray-400 me-1">KWD</span>
                </div>
                <!--end::Statistics-->
            </div>
            <!--end::Item-->
        </div>
        <!--end::Items-->
        <!--begin::Chart-->
        <div id="kt_charts_widget_20" class="min-h-auto ps-4 pe-6" data-kt-chart-info="Revenue" style="height: 300px"></div>
        <!--end::Chart-->
    </div>
    <!--end::Card body-->
</div>
<script type="text/javascript">
    //var data1 = [34.5, 34.5, 35, 35, 35.5, 35.5, 35, 35, 35.5, 35.5, 35, 35, 34.5, 34.5, 35, 35, 35.4, 35.4, 35];
    var data1 = <?php echo json_encode($sums_20)?>;
    //var data2 = ["", "Apr 02", "Apr 03", "Apr 04", "Apr 05", "Apr 06", "Apr 07", "Apr 08", "Apr 09", "Apr 10", "Apr 11", "Apr 12", "Apr 13", "Apr 14", "Apr 17", "Apr 18", "Apr 19", "Apr 21", ""];
    var data2 = <?php echo json_encode($days_20)?>;
    var KTChartsWidget20 = function() {
        var e = {
                self: null,
                rendered: !1,
                s: null
            },
            t = function(e) {

                var t = document.getElementById("kt_charts_widget_20");
                if (t) {
                    var a = parseInt(KTUtil.css(t, "height")),
                        l = KTUtil.getCssVariableValue("--bs-gray-500"),
                        r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                        o = KTUtil.getCssVariableValue("--bs-danger"),
                        i = KTUtil.getCssVariableValue("--bs-danger"),
                        s = {
                            series: [{
                                name: t.getAttribute("data-kt-chart-info"),
                                //data: [34.5, 34.5, 35, 35, 35.5, 35.5, 35, 35, 35.5, 35.5, 35, 35, 34.5, 34.5, 35, 35, 35.4, 35.4, 35]
                                data: data1
                            }],
                            chart: {
                                fontFamily: "inherit",
                                type: "area",
                                height: a,
                                toolbar: {
                                    show: !1
                                }
                            },
                            plotOptions: {},
                            legend: {
                                show: !1
                            },
                            dataLabels: {
                                enabled: !1
                            },
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: .4,
                                    opacityTo: 0,
                                    stops: [0, 80, 100]
                                }
                            },
                            stroke: {
                                curve: "smooth",
                                show: !0,
                                width: 3,
                                colors: [o]
                            },
                            xaxis: {
                                //categories: ["", "Apr 02", "Apr 03", "Apr 04", "Apr 05", "Apr 06", "Apr 07", "Apr 08", "Apr 09", "Apr 10", "Apr 11", "Apr 12", "Apr 13", "Apr 14", "Apr 17", "Apr 18", "Apr 19", "Apr 21", ""],
                                categories : data2,
                                axisBorder: {
                                    show: !1
                                },
                                axisTicks: {
                                    show: !1
                                },
                                tickAmount: 6,
                                labels: {
                                    rotate: 0,
                                    rotateAlways: !0,
                                    style: {
                                        colors: l,
                                        fontSize: "12px"
                                    }
                                },
                                crosshairs: {
                                    position: "front",
                                    stroke: {
                                        color: o,
                                        width: 1,
                                        dashArray: 3
                                    }
                                },
                                tooltip: {
                                    enabled: !0,
                                    formatter: void 0,
                                    offsetY: 0,
                                    style: {
                                        fontSize: "12px"
                                    }
                                }
                            },
                            yaxis: {
                                //max: 36.3,
                                //min: 33,
                                tickAmount: 6,
                                labels: {
                                    style: {
                                        colors: l,
                                        fontSize: "12px"
                                    },
                                    formatter: function(e) {
                                        return parseInt(e) + " KWD"
                                    }
                                }
                            },
                            states: {
                                normal: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                hover: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                active: {
                                    allowMultipleDataPointsSelection: !1,
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                }
                            },
                            tooltip: {
                                style: {
                                    fontSize: "12px"
                                },
                                y: {
                                    formatter: function(e) {
                                        return  parseInt(e) + " KWD"
                                    }
                                }
                            },
                            colors: [i],
                            grid: {
                                borderColor: r,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: !0
                                    }
                                }
                            },
                            markers: {
                                strokeColor: o,
                                strokeWidth: 3
                            }
                        };
                    e.s = s;
                    e.self = new ApexCharts(t, s), setTimeout((function() {
                        e.self.render(), e.rendered = !0
                    }), 200);

                }
            };
        return {
            init: function() {
                t(e), KTThemeMode.on("kt.thememode.change", (function() {
                    e.rendered && e.self.destroy(), t(e)
                }))
            },
            getOptions: function() {
                return e.self; // Return the value of 's'
            }
        }
    }();
    "undefined" != typeof module && (module.exports = KTChartsWidget20), KTUtil.onDOMContentLoaded((function() {
        KTChartsWidget20.init()
    }));

</script>
