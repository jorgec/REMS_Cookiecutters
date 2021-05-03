"use strict";

// Class definition
var {{cookiecutter.module_function}}View = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('transaction_view', {
			startStep: 1,
			// clickableSteps: false
		});

		// Validation before going to next page
		// wizard.on('beforeNext', function(wizardObj) {
		// 	if (validator.form() !== true) {
		// 		wizardObj.stop();  // don't go to the next step
		// 	}
		// });

		// wizard.on('beforePrev', function(wizardObj) {
		// 	if (validator.form() !== true) {
		// 		wizardObj.stop();  // don't go to the next step
		// 	}
		// });

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
				/* Validation rule sample
				//= Step 1
				address1: {
					required: true
				},

				//= Step 2
				package: {
					required: true
				},

				//= Step 3
				delivery: {
					required: true
				},

				//= Step 4
				locaddress1: {
					required: true
				}

				 */

				/* ==================== begin: Add model fields ==================== */

				/* ==================== end: Add model fields ==================== */

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
					success: function() {
						KTApp.unprogress(btn);
						//KTApp.unblock(formEl);

						swal.fire({
							"title": "",
							"text": "The application has been successfully submitted!",
							"type": "success",
							"confirmButtonClass": "btn btn-secondary"
						});
					}
				});
			}
		});
	};

	return {
		// public functions
		init: function() {
			wizardEl = KTUtil.get('transaction_view');
			formEl = $('#kt_form');

			initWizard();
			// initValidation();
			// initSubmit();
		}
	};
}();

jQuery(document).ready(function() {
	{{cookiecutter.module_function}}View.init();
});