var EmployeeLogin = function(){
    var validation = function(){
        var form = $('#employee-login-form');
        var rules = {
            emp_email: {required: true,email:true},
            emp_password: {required: true},
        };

        var message = {
            emp_email :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
            },
            emp_password : {
                required : "Please enter password"
            }
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    return {
        init:function(){
            validation();
        }
    }


}();
