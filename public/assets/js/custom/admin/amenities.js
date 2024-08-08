"use strict";
var KTAppAmenity = (function () {
    var t,
        e,
        n = () => {
            t.querySelectorAll('[data-amenity-filter="delete_row"]').forEach(
                (t) => {
                    t.addEventListener("click", function (t) {
                        t.preventDefault();
                        const n = t.target.closest("tr"),
                            r = n.querySelector(
                                '[data-amenity-filter="amenity_name"]'
                            ).innerText,
                            id = n.querySelector(
                                '[data-amenity-filter="amenity_id"]'
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
                                      url: `/admin/amenities/${id}`,
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
            (t = document.querySelector("#kt_datatable_amenities")) &&
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
                            orderable: !0,
                            targets: 1,
                        },
                    ],
                })).on("draw", function () {
                    n();
                }),

                document
                    .querySelector('[data-amenity-filter="search"]')
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                (() => {
                    const t = document.querySelector(
                        '[data-amenity-filter="status"]'
                    );
                    $(t).on("change", (t) => {
                        let n = t.target.value;
                        "all" === n && (n = ""), e.column(3).search(n).draw();
                    });
                })(),
                n());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppAmenity.init();
});
