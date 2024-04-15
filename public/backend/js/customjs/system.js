var System = function(){
    var themeSetting = function(){

        var form = $('#system-setting');
        var rules = {
            // logo: {required: true},
            // favicon: {required: true},
            // signature: {required: true},
        };

        var message = {
            // logo: {required: "Please upload your logo"},
            // favicon: {required: "Please upload your favicon"},
            // signature: {required: "Please upload your signature"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }



    return {
        init:function(){
            themeSetting();
        }
    }
}();
