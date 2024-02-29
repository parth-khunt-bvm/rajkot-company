var AttendanceSetting = function(){

    var addAttendanceSetting = function(){
        var form = $('#add-attendance-setting');
        var rules = {
            allowed_hours : {required: true},
        };

        var message = {
            allowed_hours : {required: "Please enter allowed hours"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    return {

        add:function(){
            addAttendanceSetting();
        },
    }
}();
