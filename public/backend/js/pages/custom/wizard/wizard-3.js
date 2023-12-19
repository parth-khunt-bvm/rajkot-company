/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*******************************************************!*\
  !*** ../demo1/src/js/pages/custom/wizard/wizard-3.js ***!
  \*******************************************************/


// Class definition
var KTWizard3 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];

	// Private functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						wizard.goTo(wizard.getNewStep());

						KTUtil.scrollTop();
					} else {
						// Swal.fire({
						// 	text: "Sorry, looks like there are some errors detected, please try again.",
						// 	icon: "error",
						// 	buttonsStyling: false,
						// 	confirmButtonText: "Ok, got it!",
						// 	customClass: {
						// 		confirmButton: "btn font-weight-bold btn-light"
						// 	}
						// }).then(function () {
						// 	KTUtil.scrollTop();
						// });
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Changed event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
			// Validate form before submit
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						_formEl.submit(); // submit form
                    }
					//  else {
					// 	// Swal.fire({
					// 	// 	text: "Sorry, looks like there are some errors detected, please try again.",
					// 	// 	icon: "error",
					// 	// 	buttonsStyling: false,
					// 	// 	confirmButtonText: "Ok, got it!",
					// 	// 	customClass: {
					// 	// 		confirmButton: "btn font-weight-bold btn-light"
					// 	// 	}
					// 	// }).then(function () {
					// 	// 	KTUtil.scrollTop();
					// 	// });
					// }
				});
			}
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					first_name: {
						validators: {
							notEmpty: {
								message: 'Please enter first name'
							}
						}
					},
					last_name: {
						validators: {
							notEmpty: {
								message: 'Please enter last name'
							}
						}
					},
					technology: {
						validators: {
							notEmpty: {
								message: 'Please select technology'
							}
						}
					},
					dob: {
						validators: {
							notEmpty: {
								message: 'Please enter date of birth'
							}
						}
					},
					doj: {
						validators: {
							notEmpty: {
								message: 'Please enter date of joining'
							}
						}
					},
                    personal_email: {
						validators: {
							notEmpty: {
								message: 'Please enter personal email'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					bank_name: {
						validators: {
							notEmpty: {
								message: 'Please enter bank name'
							}
						}
					},
					acc_holder_name: {
						validators: {
							notEmpty: {
								message: 'Please enter account holder name'
							},

						}
					},
					account_number: {
						validators: {
							notEmpty: {
								message: 'Please enter account number'
							},
							digits: {
								message: 'input type must be an integer. Please enter a valid integer value.'
							}
						}
					},
					ifsc_code: {
						validators: {
							notEmpty: {
								message: 'Please enter ifsc code'
							},
						}
					},
					aadhar_card_number: {
						validators: {
							notEmpty: {
								message: 'Please enter aadhar card number'
							},
							digits: {
								message: 'input type must be an integer. Please enter a valid integer value.'
							}
						}
					},
                    google_pay: {
						validators: {
							notEmpty: {
								message: 'Please enter google pay number'
							},
							digits: {
								message: 'input type must be an integer. Please enter a valid integer value.'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					parent_name: {
						validators: {
							notEmpty: {
								message: 'Please enter parent name'
							}
						}
					},
					address: {
						validators: {
							notEmpty: {
								message: 'Please enter address'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					experience: {
						validators: {
							notEmpty: {
								message: 'Please enter experience'
							}
						}
					},
					hired_by: {
						validators: {
							notEmpty: {
								message: 'Please enter hired by'
							}
						}
					},
                    salary: {
						validators: {
							notEmpty: {
								message: 'Please enter salary'
							}
						}
					},
					status: {
						validators: {
							notEmpty: {
								message: 'Please select status'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Validate fields when clicking the Submit button
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v3');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard3.init();
});

/******/ })()
;
//# sourceMappingURL=wizard-3.js.map
