var EmployeeDashboard = function(){
    var editProfile = function () {
        var form = $('#update-personal-info');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            // branch : {required: true},
            // technology : {required: true},
            // designation : {required: true},
            gmail : {required: true, email:true},
            // gmail_password : {required: true},
        };

        var message = {
            first_name : {required: "Please enter your first name"},
            last_name : {required: "Please enter your last name"},
            // branch : {required: "Please enter your last name"},
            // technology : {required: "Please enter your last name"},
            // designation : {required: "Please enter your last name"},
            gmail :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
            },
            // gmail_password : {required: "Please enter your last name"},

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        // var form = $('#update-bank-info');
        // var rules = {
        //     bank_name : {required: true},
        // };

        // var message = {
        //     bank_name : {required: "Please enter your bank name"},
        // }
        // handleFormValidateWithMsg(form, rules,message, function(form) {
        //     handleAjaxFormSubmit(form,true);
        // });

        // var form = $('#update-parent-info');
        // var rules = {
        //     personal_number : {required: true},
        //     emergency_contact : {required: true},
        // };

        // var message = {
        //     personal_number : {required: "Please enter your personal number"},
        //     emergency_contact : {required: "Please enter your emergency contact"},
        // }
        // handleFormValidateWithMsg(form, rules,message, function(form) {
        //     handleAjaxFormSubmit(form,true);
        // });


        // var form = $('#update-company-info');
        // var rules = {
        //     hired_by : {required: true},
        // };

        // var message = {
        //     hired_by : {required: "Please select manager name"},
        // }
        // handleFormValidateWithMsg(form, rules,message, function(form) {
        //     handleAjaxFormSubmit(form,true);
        // });


        // $(".datepicker_date").datepicker({
        //     format: 'd-M-yyyy',
        //     todayHighlight: true,
        //     autoclose: true,
        //     orientation: "bottom auto",
        // });
        // $(".date_of_birth").datepicker({
        //     format: 'd-M-yyyy',
        //     todayHighlight: true,
        //     autoclose: true,
        //     orientation: "bottom auto",
        //     endDate: new Date()
        // });


    }
    var password = function(){
        var form = $('#change-password');
        var rules = {
            old_password: {required: true},
            new_password: {required: true},
            new_confirm_password: {required: true,equalTo: "#password"},

        };

        var message = {
            old_password: {required: "Please enter your password"},
            new_password: {required: "Please enter your new password"},
            new_confirm_password: {
                required: "Please enter confirm password",
                equalTo: "New Password and confirmn password not match"
            },
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    return {
        edit_profile:function(){
            editProfile()
        },
        change_password:function(){
            password();
        },
    }
}();
