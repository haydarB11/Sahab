"use strict";
var KTUpdateProfile = (function () {
    var e, t, i;
    return {
        init: function () {
            (i = document.querySelector("#kt_edit_profile_form")),
                (e = i.querySelector("#btn_edit_form")),
                (t = FormValidation.formValidation(i, {
                    fields: {

                        email: {
                            validators: {
                                notEmpty: { message: "Email is required" },
                            },
                        },
                        old_pass: {
                            validators: {
                                notEmpty: { message: "old password is required" },
                            },
                        },
                        new_pass: {
                            validators: {
                                stringLength :{
                                    min:8,
                                    message : "new password length must be at least 8",
                                }
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
                                                  text: "profile has been successfully updated!",
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
                                              text: "profile was not updated try again.",
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
    KTUpdateProfile.init();
});
