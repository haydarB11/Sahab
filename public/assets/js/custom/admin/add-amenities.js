"use strict";
var KTModalAmenitiesAdd = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_add_amenities")
            )),
                (r = document.querySelector("#kt_modal_add_amenities_form")),
                (t = r.querySelector("#kt_modal_add_amenities_submit")),
                (e = r.querySelector("#kt_modal_add_amenities_cancel")),
                (o = r.querySelector("#kt_modal_add_amenities_close")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        title: {
                            validators: {
                                notEmpty: { message: "Title is required" },
                            },
                        },
                        title_ar: {
                            validators: {
                                notEmpty: {
                                    message: "Title Arabic is required",
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
                })),
                $(r.querySelector('[name="type"]')).on("change", function () {
                    n.revalidateField("type");
                }),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
                                var formData = new FormData(r);

                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          (t.disabled = !0),
                                          $.ajax({
                                              url: r.action,
                                              type: "POST",
                                              data: formData,
                                              processData: false,
                                              contentType: false,

                                              success: function (response) {
                                                  t.removeAttribute(
                                                      "data-kt-indicator"
                                                  ),
                                                      Swal.fire({
                                                          text: "Amenities has been successfully submitted!",
                                                          icon: "success",
                                                          buttonsStyling: !1,
                                                          confirmButtonText:
                                                              "Ok, got it!",
                                                          customClass: {
                                                              confirmButton:
                                                                  "btn btn-primary",
                                                          },
                                                      }).then(function (e) {
                                                          e.isConfirmed &&
                                                              (i.hide(),
                                                              (t.disabled = !1),
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
                                                  t.removeAttribute(
                                                      "data-kt-indicator"
                                                  ),
                                                      (t.disabled = !1),
                                                      console.log(error);
                                                  Swal.fire({
                                                      text: "Amenities was not submitted try again.",
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
                                              confirmButtonText: "Ok, got it!",
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
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTModalAmenitiesAdd.init();
});
