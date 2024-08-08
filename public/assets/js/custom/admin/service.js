"use strict";
var KTAppService = (function () {
    var featured,
        bookable,
        o,
        t,
        e,
        n = () => {
            t.querySelectorAll('[data-service-filter="delete_row"]').forEach(
                (t) => {
                    t.addEventListener("click", function (t) {
                        t.preventDefault();
                        const n = t.target.closest("tr"),
                            r = n.querySelector(
                                '[data-service-filter="service_name"]'
                            ).innerText,
                            id = n.querySelector(
                                '[data-service-filter="service_id"]'
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
                                      url: `/admin/services/${id}`,
                                      type: "DELETE",
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
            (t = document.querySelector("#kt_datatable_services")) &&
                ((e = $(t).DataTable({
                    info: !1,
                    order: [],
                    pageLength: 10,
                    columnDefs: [
                        {
                            orderable: !0,
                            targets: 0,
                        },
                        {
                            orderable: !0,
                            targets: 1,
                        },
                    ],
                })).on("draw", function () {
                    n();
                }),
                document
                    .querySelector('[data-service-filter="search"]')
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                (o = document.querySelectorAll(
                    '[data-service-filter="available"] [name="available"]'
                )),
                (bookable = document.querySelectorAll(
                    '[data-service-filter="bookable"] [name="bookable"]'
                )),
                (featured = document.querySelectorAll(
                    '[data-service-filter="featured"] [name="featured"]'
                )),
                document
                    .querySelector('[data-service-filter="filter"]')
                    .addEventListener("click", function () {
                        let c = "";
                        o.forEach((t) => {
                            t.checked && (c = t.value), "all" === c && (c = "");
                        });
                        let cc = "";
                        bookable.forEach((t) => {
                            t.checked && (cc = t.value),
                                "all" === cc && (cc = "");
                        });
                        let ccc = "";
                        featured.forEach((t) => {
                            t.checked && (ccc = t.value),
                                "all" === ccc && (ccc = "");
                        });
                        const r = cc + " " + c + " " + ccc;
                        e.search(r).draw();
                    }),
                document
                    .querySelector('[data-service-filter="reset"]')
                    .addEventListener("click", function () {
                        (o[0].checked = !0),
                            (bookable[0].checked = !0),
                            (featured[0].checked = !0),
                            e.search("").draw();
                    }),
                n());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppService.init();
});
