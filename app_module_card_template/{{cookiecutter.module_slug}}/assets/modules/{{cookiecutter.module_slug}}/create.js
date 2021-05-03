// Class definition
var {{ cookiecutter.module_function }}Create = function() {
    // Private functions

	var formRepeater = function() {

		$('#academic_form_repeater, #seminar_form_repeater, #exam_form_repeater').repeater({
			initEmpty: false,

            defaultValues: {
            },

            show: function () {
				$(this).slideDown();
				datepicker();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
		});
	};

	var arrows;
	if (KTUtil.isRTL()) {
		arrows = {
			leftArrow: '<i class="la la-angle-right"></i>',
			rightArrow: '<i class="la la-angle-left"></i>'
		}
	} else {
		arrows = {
			leftArrow: '<i class="la la-angle-left"></i>',
			rightArrow: '<i class="la la-angle-right"></i>'
		}
	}
	// Private functions
	var datepicker = function () {
		// minimum setup
		$('.datePicker').datepicker({
			rtl: KTUtil.isRTL(),
			todayHighlight: true,
			orientation: "bottom left",
			templates: arrows,
			locale: 'no',
			format: 'yyyy-mm-dd',
			autoclose: true
		});

		$('.yearPicker').datepicker({
			rtl: KTUtil.isRTL(),
			todayHighlight: true,
			format: "yyyy",
			viewMode: "years",
			minViewMode: "years",
			autoclose: true
		});
	};

	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard_v3', {
			startStep: 1,
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		});

		wizard.on('beforePrev', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		});

		// Change event
		wizard.on('change', function(wizard) {
			KTUtil.scrollTop();
		});
	};

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",
			// Validation rules
			rules: {
				"info[name]": {
                    required: true
				},
            },
			messages: {
				// "info[email]": {
				// 	required: 'Email field is required',
				// 	email: 'Invalid email address',
				// 	remote:jQuery.validator.format("{0} is already taken, please enter a different email address.")
				// },
			},
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
			submitHandler: function (form) {

			}
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
							swal.fire(
								'Oops!',
								response.message,
								'error'
							)
						}
					}
				});
			}
		});
	};

    // Public functions
    return {
        init: function() {
			datepicker();
			formRepeater();

			wizardEl = KTUtil.get('kt_wizard_v3');
			formEl = $('#create_{{ cookiecutter.module_slug }}');

			initWizard();
			initValidation();
			initSubmit();

        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    {{ cookiecutter.module_function }}Create.init();
});