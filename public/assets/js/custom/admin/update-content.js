"use strict";
var KTUpdateContent = (function () {
    var e, t, i;
    return {
        init: function () {
            (i = document.querySelector("#kt_update_content_form")),
                (e = i.querySelector("#btn_edit_form")),
                (t = FormValidation.formValidation(i, {
                    fields: {
                        about_en: {
                            validators: {
                                notEmpty: { message: "About English is required" },
                            },
                        },
                        about_ar: {
                            validators: {
                                notEmpty: { message: "About Arabic is required" },
                            },
                        },
                        privacy_en: {
                            validators: {
                                notEmpty: { message: "Privacy Policy English is required" },
                            },
                        },
                        privacy_ar: {
                            validators: {
                                notEmpty: { message: "Privacy Policy Arabic is required" },
                            },
                        },
                        terms_en: {
                            validators: {
                                notEmpty: { message: "Terms English is required" },
                            },
                        },
                        terms_ar: {
                            validators: {
                                notEmpty: { message: "Terms Arabic is required" },
                            },
                        },
                        email: {
                            validators: {
                                notEmpty: { message: "Email is required" },
                            },
                        },
                        phone: {
                            validators: {
                                notEmpty: { message: "Phone is required" },
                            },
                        },
                        facebook: {
                            validators: {
                                notEmpty: { message: "Facebook Url is required" },
                            },
                        },
                        instagram: {
                            validators: {
                                notEmpty: { message: "Instagram Url is required" },
                            },
                        },
                        X: {
                            validators: {
                                notEmpty: { message: "X Url is required" },
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
                }));
            var url = i.action;

            e.addEventListener("click", function (ii) {
                var formData = new FormData(i);
                ii.preventDefault(),
                    t &&
                        t.validate().then(function (t) {
                            "Valid" == t
                                ? (e.setAttribute("data-kt-indicator", "on"),
                                  (e.disabled = !0),
                                  $.ajax({
                                      url: url,
                                      type: "POST",
                                      data: formData,
                                      processData: false,
                                      contentType: false,

                                      success: function (response) {
                                          e.setAttribute(
                                              "data-kt-indicator",
                                              "off"
                                          ),
                                              Swal.fire({
                                                  text: "content has been successfully updated!",
                                                  icon: "success",
                                                  buttonsStyling: !1,
                                                  confirmButtonText:
                                                      "Ok, got it!",
                                                  customClass: {
                                                      confirmButton:
                                                          "btn btn-primary",
                                                  },
                                              }).then(function (ee) {
                                                  ee.isConfirmed &&
                                                      (e.disabled = !1);

                                              });
                                      },

                                      error: function (xhr, status, error) {
                                          e.setAttribute(
                                              "data-kt-indicator",
                                              "off"
                                          ),
                                              (e.disabled = !1),
                                              console.log(error);
                                          Swal.fire({
                                              text: "content was not updated try again.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
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
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUpdateContent.init();
});
