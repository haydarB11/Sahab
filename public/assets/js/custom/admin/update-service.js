"use strict";
var KTUpdateService = (function () {
    var e, t, i;
    return {
        init: function () {
            (i = document.querySelector("#kt_edit_service_form")),
                (e = i.querySelector("#btn_edit_form")),
                (t = FormValidation.formValidation(i, {
                    fields: {
                        title: {
                            validators: {
                                notEmpty: { message: "Title is required" },
                            },
                        },
                        description: {
                            validators: {
                                notEmpty: { message: "Description is required" },
                            },
                        },
                        price: {
                            validators: {
                                notEmpty: { message: " price is required" },
                            },
                        },
                        duration: {
                            validators: {
                                notEmpty: { message: "duration is required" },
                            },
                        },
                        capacity: {
                            validators: {
                                notEmpty: { message: "capacity is required" },
                            },
                        },
                        notice_period: {
                            validators: {
                                notEmpty: { message: "notice period is required" },
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
                new Dropzone("#kt_ecommerce_add_product_media", {
                    url: "/admin/services/images",
                    paramName: "file",
                    maxFiles: 10,
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    accept: function (e, t) {
                      "wow.jpg" == e.name ? t("Naha, you don't.") : t();
                    },
                  });
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
                                                text: "service has been successfully updated!",
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
                                                    (
                                                    (e.disabled = !1));
                                                    setTimeout(() => {
                                                        window.location =
                                                            "/admin/services";
                                                    }, 2000);
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
                                            text: "service was not updated try again.",
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
    KTUpdateService.init();
});
