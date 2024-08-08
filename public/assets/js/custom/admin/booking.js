"use strict";
var KTAppBooking = (function () {
    var t,
        e,
        flat,
        a = (ee, t, n) => {
            var r = ee[0] ? new Date(ee[0]) : null,
                o = ee[1] ? new Date(ee[1]) : null;

            $.fn.dataTable.ext.search.push(function (e, t, n) {
                var a = r,
                    c = o,
                    l = new Date(t[14]);

                return (
                    (null === a && null === c) ||
                    (null === a && c >= l) ||
                    (a <= l && null === c) ||
                    (a <= l && c >= l)
                );
            }),
                e.draw();
        },
        n = () => {
            t.querySelectorAll('[data-booking-filter="delete_row"]').forEach(
                (t) => {
                    t.addEventListener("click", function (t) {
                        t.preventDefault();
                        const n = t.target.closest("tr"),
                            r = n.querySelector(
                                '[data-booking-filter="booking_id"]'
                            ).innerText;
                        Swal.fire({
                            text: "Are you sure you want to delete " + r + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton:
                                    "btn fw-bold btn-active-light-primary",
                            },
                        }).then(function (t) {
                            t.value
                                ? $.ajax({
                                      url: `/admin/students/destroy/${r}`,
                                      type: "GET",
                                      processData: false,
                                      contentType: false,

                                      success: function (response) {
                                          Swal.fire({
                                              text:
                                                  "You have deleted " +
                                                  r +
                                                  "!.",
                                              icon: "success",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn fw-bold btn-primary",
                                              },
                                          }).then(function () {
                                              e.row($(n)).remove().draw();
                                          });
                                      },

                                      error: function (xhr, status, error) {
                                          console.log(error);
                                          Swal.fire({
                                              text: r + " was not deleted.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn fw-bold btn-primary",
                                              },
                                          });
                                      },
                                  })
                                : "cancel" === t.dismiss &&
                                  Swal.fire({
                                      text: r + " was not deleted.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Ok, got it!",
                                      customClass: {
                                          confirmButton:
                                              "btn fw-bold btn-primary",
                                      },
                                  });
                        });
                    });
                }
            );
        };
    return {
        init: function () {
            (t = document.querySelector("#kt_datatable_booking")) &&
                ((e = $(t).DataTable({
                    info: !1,
                    order: [],
                    pageLength: 10,
                    columnDefs: [

                        {
                            orderable: !1,
                            targets: 0,
                        },
                        {
                            orderable: !1,
                            targets: 7,
                        },
                    ],
                })).on("draw", function () {
                    n();
                }),
                (() => {
                    const e = "Bookings";
                    new $.fn.dataTable.Buttons(t, {
                        buttons: [
                            { extend: "copyHtml5", title: e },
                            { extend: "excelHtml5", title: e },
                            { extend: "csvHtml5", title: e },
                            { extend: "pdfHtml5", title: e },
                        ],
                    })
                        .container()
                        .appendTo($("#booking_views_export")),
                        document
                            .querySelectorAll(
                                "#booking_export_menu [data-booking-export]"
                            )
                            .forEach((t) => {
                                t.addEventListener("click", (t) => {
                                    t.preventDefault();
                                    const e = t.target.getAttribute(
                                        "data-booking-export"
                                    );
                                    document
                                        .querySelector(
                                            ".dt-buttons .buttons-" + e
                                        )
                                        .click();
                                });
                            });
                })(),
                document
                    .querySelector('[data-booking-filter="search"]')
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                (() => {
                    const t = document.querySelector(
                        '[data-booking-filter="status"]'
                    );
                    $(t).on("change", (t) => {
                        let n = t.target.value;
                        "all" === n && (n = ""), e.column(13).search(n).draw();
                    });
                })(),
                n(),
                (() => {
                    const e = document.querySelector("#kt_booking_flatpickr");
                   flat = $(e).flatpickr({
                        altInput: !0,
                        altFormat: "d/m/Y",
                        dateFormat: "d/m/Y",
                        mode: "range",
                        onChange: function (e, t, n) {
                            a(e, t, n);
                        },
                    });
                })(),
                document
                    .querySelector("#kt_booking_flatpickr_clear")
                    .addEventListener("click", (e) => {
                        flat.clear();
                    }));
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppBooking.init();
});
