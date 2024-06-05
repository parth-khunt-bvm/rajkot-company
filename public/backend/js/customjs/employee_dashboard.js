var EmployeeDashboard = function(){
    var editProfile = function () {
        
        var form = $('#update-first-personal-info');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
        };
        var message = {
            first_name : {required: "Please enter your first name"},
            last_name : {required: "Please enter your last name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#update-personal-info');
        var rules = {
            branch : {required: true},
            technology : {required: true},
            designation : {required: true},
            gmail : {required: true, email:true},
            gmail_password : {required: true},
        };
        var message = {
            branch : {required: "Please enter your last name"},
            technology : {required: "Please enter your last name"},
            designation : {required: "Please enter your last name"},
            gmail :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
            },
            gmail_password : {required: "Please enter your last name"},
        };
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#update-bank-info');
        var rules = {
            bank_name : {required: true},
        };
        var message = {
            bank_name : {required: "Please enter your bank name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#update-parent-info');
        var rules = {
            personal_number : {required: true},
            emergency_number : {required: true},
        };
        var message = {
            personal_number : {required: "Please enter your personal number"},
            emergency_number : {required: "Please enter your emergency contact"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });


        var form = $('#update-company-info');
        var rules = {
            hired_by : {required: true},
        };
        var message = {
            hired_by : {required: "Please select manager name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#viewPassForm');
        var rules = {
            login_email : {required: true},
            login_password : {required: true}
        };
        var message = {
            login_email : {required: "Please enter your Login Email"},
            login_password : {required: "Please enter your Login Password"}
        };
        handleFormValidateWithMsg(form, rules,message);


        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
        $(".date_of_birth").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
            endDate: new Date()
        });

        $('body').on('click', '.unhashPass', function (e) {
            e.preventDefault();
            if($('#viewPassForm').valid()){
                var gmail = $('#login_email').val();
                var password = $('#login_password').val();
                var data = { 'gmail' : gmail, 'password' : password };
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "employee/save-profile/ajaxcall",
                    data: { 'action': 'check_password', 'data': data },
                    success: function (data) {
                        var response = JSON.parse(data);
                        if(response.status == true){
                            $('#unmask-pass-model').modal('toggle');
                            $('#gmail_password').removeAttr('disabled');
                            $('#gmail_password').val(response.data.gmail_password);
                            $('#slack_password').removeAttr('disabled');
                            $('#slack_password').val(response.data.slack_password);
                            var showPassBtn = $('.showPassBtn').find();
                            showPassBtn.prevObject.slideUp('slow', function() {
                                $(this).remove();
                            });
                            showPassBtn.prevObject.each(function() {
                                var newElement = $('<a href="#" class="hidePassBtn" title="Hide Password"><i class="fas fa-eye-slash"></i></a>');
                                newElement.hide();
                                $(this).after(newElement);
                                newElement.delay(300).fadeIn('slow');
                            });
                            showToster('success', 'Passwords are Successfully Showed.');
                        } else {
                            showToster('error', 'Invalid Login Credentials.');
                        }
                    },
                });
            }
        });

        $('body').on('click', '.hidePassBtn', function (e) {
            e.preventDefault();
            var $gPass = $('#gmail_password');
            var $sPass = $('#slack_password');
            var gPassMasked = '#'.repeat($gPass.val().length);
            var sPassMasked = '#'.repeat($sPass.val().length);
            $gPass.val(gPassMasked);
            $sPass.val(sPassMasked);
            $gPass.attr('disabled', 'disabled');
            $sPass.attr('disabled', 'disabled');
            var hidePassBtn = $('.hidePassBtn').find();
            hidePassBtn.prevObject.slideUp('slow', function() {
                $(this).remove();
            });
            hidePassBtn.prevObject.each(function() {
                var newElement = $('<a href="#" class="showPassBtn" data-toggle="modal" data-target="#unmask-pass-model" title="Show Password"><i class="fas fa-eye"></i></a>');
                newElement.hide();
                $(this).after(newElement);
                newElement.delay(300).fadeIn('slow');
            });
            showToster('success', 'Passwords Hidden Successfully.');
        });


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
            editProfile();
        },
        change_password:function(){
            password();
        },
    }
}();
