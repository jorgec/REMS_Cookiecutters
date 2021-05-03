// Class definition
var Form = function () {
    var arrows;

    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>',
        };
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>',
        };
    }

    // Private functions
    var datepicker = function () {
        // minimum setup
        $(".kt_datepicker").datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            locale: "no",
            format: "yyyy-mm-dd",
            autoclose: true,
        });

        $(".yearPicker").datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true,
        });
    };

    var formEl;
    var validator;

    var initValidation = function() {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {
                "name": {
                    required: true
                },
            },
            // messages: {
            // 	"info[last_name]":'Last name field is required',
            // },
            // Display error
            invalidHandler: function(event, validator) {
                KTUtil.scrollTop();

                swal.fire({
                    "title": "",
                    "text": "There are some errors in your submission. Please correct them.",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
            },

            // Submit valid form
            submitHandler: function (form) {},
        });
    };

    var initSubmit = function() {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function(e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    type: 'POSt',
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            swal.fire({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            }).then(function() {
                                window.location.replace(base_url + "{{ cookiecutter.module_slug }}");
                            });
                        } else {
                            swal.fire({
                                title: 'Oops!',
                                html: response.message,
                                icon : 'error'
                            })
                        }
                    }
                });
            }
        });
    };

    var _add_ons = function () {
        datepicker();
    };

    // Public functions
    return {
        init: function () {
            datepicker();
            _add_ons();

            formEl = $("#form_{{ cookiecutter.module_slug }}");

            initValidation();
            initSubmit();
        },
    };
}();

// Initialization
jQuery(document).ready(function () {
    Form.init();
});
