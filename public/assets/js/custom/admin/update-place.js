"use strict";
var KTUpdatePlace = (function () {
    var e, t, i;
    return {
        init: function () {
            (i = document.querySelector("#kt_edit_place_form")),
                (e = i.querySelector("#btn_edit_form")),
                (t = FormValidation.formValidation(i, {
                    fields: {
                        title: {
                            validators: {
                                notEmpty: { message: "Title is required" },
                            },
                        },
                        address: {
                            validators: {
                                notEmpty: { message: "Address is required" },
                            },
                        },
                        description: {
                            validators: {
                                notEmpty: { message: "Description is required" },
                            },
                        },
                        weekday_price: {
                            validators: {
                                notEmpty: { message: "Weekday price is required" },
                            },
                        },
                        weekend_price: {
                            validators: {
                                notEmpty: { message: "Weekend price is required" },
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
                                                text: "place has been successfully updated!",
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
                                                            "/admin/places";
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
                                            text: "place was not updated try again.",
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
    KTUpdatePlace.init();
});
