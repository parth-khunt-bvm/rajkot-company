var System = function(){
    var themeSetting = function(){

        var form = $('#system-setting');
        var rules = {
            theme_color_code: {required: true},
            sidebar_color: {required: true},
            sidebar_menu_font_color: {required: true},
            // logo: {required: true},
            // favicon: {required: true},
            // signature: {required: true},
        };

        var message = {
            theme_color_code: {required: "Please select theme color code"},
            sidebar_color: {required: "Please select sidebar color"},
            sidebar_menu_font_color: {required: "Please select sidebar menu font color"},
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
