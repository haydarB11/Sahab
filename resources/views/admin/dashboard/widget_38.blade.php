<div class="card card-flush h-xl-50 mb-5 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-7">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            Services Bookings
        </h3>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
            <div id="datePicker_38" data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4 datePicker">
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
    <!--begin::Body-->
    <div class="card-body d-flex align-items-end px-0 pt-3 pb-5">
        <!--begin::Chart-->
        <div id="kt_charts_widget_38_chart" class="h-325px w-100 min-h-auto ps-4 pe-6"></div>
        <!--end::Chart-->
    </div>
    <!--end: Card Body-->
</div>
<script>
    //var data3 = [54, 42, 75, 110, 23, 87, 50];
    var data3 = <?php echo json_encode($sums_38)?>;
    //var data4 = ["E2E", "IMC", "SSMC", "SSBD", "ICCD", "PAN", "SBN"];
    var data4 = <?php echo json_encode($data_38)?>;
    var KTChartsWidget38 = function() {
        var e = {
                self: null,
                rendered: !1
            },
            t = function() {
                var t = document.getElementById("kt_charts_widget_38_chart");
                if (t) {
                    var a = parseInt(KTUtil.css(t, "height")),
                        l = KTUtil.getCssVariableValue("--bs-gray-900"),
                        r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                        o = {
                            series: [{
                                name: "LOI Issued",
                                data: data3
                            }],
                            chart: {
                                fontFamily: "inherit",
                                type: "bar",
                                height: a,
                                toolbar: {
                                    show: !1
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: !1,
                                    columnWidth: ["28%"],
                                    borderRadius: 5,
                                    dataLabels: {
                                        position: "top"
                                    },
                                    startingShape: "flat"
                                }
                            },
                            legend: {
                                show: !1
                            },
                            dataLabels: {
                                enabled: !0,
                                offsetY: -28,
                                style: {
                                    fontSize: "13px",
                                    colors: [l]
                                },
                                formatter: function(e) {
                                    return e
                                }
                            },
                            stroke: {
                                show: !0,
                                width: 2,
                                colors: ["transparent"]
                            },
                            xaxis: {
                                categories: data4,
                                axisBorder: {
                                    show: !1
                                },
                                axisTicks: {
                                    show: !1
                                },
                                labels: {
                                    style: {
                                        colors: KTUtil.getCssVariableValue("--bs-gray-500"),
                                        fontSize: "13px"
                                    }
                                },
                                crosshairs: {
                                    fill: {
                                        gradient: {
                                            opacityFrom: 0,
                                            opacityTo: 0
                                        }
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: KTUtil.getCssVariableValue("--bs-gray-500"),
                                        fontSize: "13px"
                                    },
                                    formatter: function(e) {
                                        return e + "M"
                                    }
                                }
                            },
                            fill: {
                                opacity: 1
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
                                        return +e + "M"
                                    }
                                }
                            },
                            colors: [KTUtil.getCssVariableValue("--bs-primary"), KTUtil.getCssVariableValue("--bs-primary-light")],
                            grid: {
                                borderColor: r,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: !0
                                    }
                                }
                            }
                        };
                    e.self = new ApexCharts(t, o), setTimeout((function() {
                        e.self.render(), e.rendered = !0
                    }), 200)
                }
            };
        return {
            init: function() {
                t(), KTThemeMode.on("kt.thememode.change", (function() {
                    e.rendered && e.self.destroy(), t()
                }))
            },
            getOptions: function() {
                return e.self; // Return the value of 's'
            }
        }
    }();
    "undefined" != typeof module && (module.exports = KTChartsWidget38), KTUtil.onDOMContentLoaded((function() {
        KTChartsWidget38.init()
    }));
</script>
