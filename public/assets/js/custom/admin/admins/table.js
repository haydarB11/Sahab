"use strict";
var KTUsersList = (function () {
    var e,
        t,
        n,
        r,
        o = document.getElementById("kt_table_users"),
        c = () => {
            o.querySelectorAll(
                '[data-kt-users-table-filter="delete_row"]'
            ).forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    const n = t.target.closest("tr"),
                        r = n
                            .querySelectorAll("td")[1]
                            .querySelectorAll("a")[1].innerText;
                        const id = n.querySelector(
                            '[data-admin-id="admin_id"]'
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
                                  url: `/admin/admins/${id}`,
                                  type: "DELETE",
                                  processData: false,
                                  contentType: false,

                                  success: function (response) {
                                      Swal.fire({
                                          text: "You have deleted " + r + "!.",
                                          icon: "success",
                                          buttonsStyling: !1,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                              confirmButton:
                                                  "btn fw-bold btn-primary",
                                          },
                                      })
                                          .then(function () {
                                              e.row($(n)).remove().draw();
                                          })
                                          .then(function () {
                                              a();
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
                                  text: customerName + " was not deleted.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
            });
        },
         nf = () => {
            o.querySelectorAll('[data-kt-users-table-filter="edit_row"]').forEach(
                (t) => {
                    var i = new bootstrap.Modal(t.dataset.bsTarget);
                    var uu = document.querySelector(t.dataset.bsTarget);
                    var r = document.querySelector(
                        `#user_edit_form${uu.dataset.myId}`
                    );
                    var tt = document.querySelector(
                        `#user_edit_submit${uu.dataset.myId}`
                    );
                    var e = document.querySelector(
                        `#user_edit_cancel${uu.dataset.myId}`
                    );
                    var o = document.querySelector(
                        `#user_edit_close${uu.dataset.myId}`
                    );
                    var n = FormValidation.formValidation(r, {
                        fields: {
                            user_name: {
                                validators: {
                                    notEmpty: { message: "Full name is required" },
                                },
                            },
                            user_email: {
                                validators: {
                                    notEmpty: {
                                        message: "Valid email address is required",
                                    },
                                },
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: "",
                            }),
                        },
                    });

                        tt.addEventListener("click", function (e) {
                            e.preventDefault(),
                                n &&
                                    n.validate().then(function (e) {
                                        var formData = new FormData(r);

                                        console.log("validated!"),
                                            "Valid" == e
                                                ? (tt.setAttribute(
                                                      "data-kt-indicator",
                                                      "on"
                                                  ),
                                                  (tt.disabled = !0),
                                                  $.ajax({
                                                      url: r.action,
                                                      type: "POST",
                                                      data: formData,
                                                      processData: false,
                                                      contentType: false,

                                                      success: function (response) {
                                                          tt.removeAttribute(
                                                              "data-kt-indicator"
                                                          ),
                                                              Swal.fire({
                                                                  text: "Admin has been successfully updated!",
                                                                  icon: "success",
                                                                  buttonsStyling:
                                                                      !1,
                                                                  confirmButtonText:
                                                                      "Ok, got it!",
                                                                  customClass: {
                                                                      confirmButton:
                                                                          "btn btn-primary",
                                                                  },
                                                              }).then(function (e) {
                                                                  e.isConfirmed &&
                                                                      (i.hide(),
                                                                      (tt.disabled =
                                                                          !1),
                                                                      (window.location =
                                                                          r.getAttribute(
                                                                              "data-kt-redirect"
                                                                          )));
                                                              });
                                                      },

                                                      error: function (
                                                          xhr,
                                                          status,
                                                          error
                                                      ) {
                                                          tt.removeAttribute(
                                                              "data-kt-indicator"
                                                          ),
                                                              (tt.disabled = !1),
                                                              console.log(error);
                                                          Swal.fire({
                                                              text: "Admin was not updated try again.",
                                                              icon: "error",
                                                              buttonsStyling: !1,
                                                              confirmButtonText:
                                                                  "Ok, got it!",
                                                              customClass: {
                                                                  confirmButton:
                                                                      "btn fw-bold btn-primary",
                                                              },
                                                          });
                                                      },
                                                  }))
                                                : Swal.fire({
                                                      text: "Sorry, looks like there are some errors detected, please try again.",
                                                      icon: "error",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "Ok, got it!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn btn-primary",
                                                      },
                                                  });
                                    });
                        }),
                        e.addEventListener("click", function (t) {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Are you sure you would like to cancel?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, cancel it!",
                                    cancelButtonText: "No, return",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light",
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (r.reset(), i.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Your form has not been cancelled!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
                                              customClass: {
                                                  confirmButton: "btn btn-primary",
                                              },
                                          });
                                });
                        }),
                        o.addEventListener("click", function (t) {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Are you sure you would like to cancel?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, cancel it!",
                                    cancelButtonText: "No, return",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light",
                                    },
                                }).then(function (t) {
                                    t.value
                                        ? (r.reset(), i.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Your form has not been cancelled!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
                                              customClass: {
                                                  confirmButton: "btn btn-primary",
                                              },
                                          });
                                });
                        });
                }
            );
        };


    return {
        init: function () {
            o &&
                (o.querySelectorAll("tbody tr").forEach((e) => {
                    const t = e.querySelectorAll("td"),
                        n = t[2].innerText.toLowerCase();
                    let r = 0,
                        o = "minutes";
                    n.includes("yesterday")
                        ? ((r = 1), (o = "days"))
                        : n.includes("mins")
                        ? ((r = parseInt(n.replace(/\D/g, ""))),
                          (o = "minutes"))
                        : n.includes("hours")
                        ? ((r = parseInt(n.replace(/\D/g, ""))), (o = "hours"))
                        : n.includes("days")
                        ? ((r = parseInt(n.replace(/\D/g, ""))), (o = "days"))
                        : n.includes("weeks") &&
                          ((r = parseInt(n.replace(/\D/g, ""))), (o = "weeks"));
                    const c = moment().subtract(r, o).format();
                    t[2].setAttribute("data-order", c);
                    const l = moment(
                        t[3].innerHTML,
                        "DD MMM YYYY, LT"
                    ).format();
                    t[3].setAttribute("data-order", l);
                }),
                (e = $(o).DataTable({
                    info: !0,
                    order: [],
                    pageLength: 10,
                    lengthChange: !1,
                    columnDefs: [
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 4 },
                    ],
                })).on("draw", function () {
                     c();
                }),

                document
                    .querySelector('[data-kt-user-table-filter="search"]')
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),

                c(),nf()());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersList.init();
});
