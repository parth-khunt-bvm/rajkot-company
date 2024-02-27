var LatterAbbreviation = function(){
    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#latter-abbreviations-list',
            'ajaxURL': baseurl + "admin/latter-abbreviations/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("click", ".show-latter-abbreviation-form", function() {
            $("#show-latter-abbreviation-form").html('-').addClass('remove-latter-abbreviation-form');
            $("#show-latter-abbreviation-form").html('-').removeClass('show-latter-abbreviation-form');
            $("#add-latter-abbreviations").slideToggle("slow");
        })

        $("body").on("click", ".remove-latter-abbreviation-form", function() {
            $("#show-latter-abbreviation-form").html('+').removeClass('remove-latter-abbreviation-form');
            $("#show-latter-abbreviation-form").html('+').addClass('show-latter-abbreviation-form');
            $("#add-latter-abbreviations").slideToggle("slow");
        })

    }
    var addLatterAbbreviation = function(){

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
          }, "Space not allowed");

        jQuery.validator.addMethod("enclosedInAngleBrackets", function(value, element) {
            return /^<.*>$/.test(value.trim()); // Checks if the value starts and ends with <>
        }, "Value must be enclosed in < and >");

        var form = $('#add-latter-abbreviations');
        var rules = {
            key : {
                required: true,
                noSpace: true,
                enclosedInAngleBrackets: true
            },
            value : {required: true}
        };

        var message = {
            key : {required: "Please enter key name"},
            value : {required: "Please enter value"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var editLatterAbbreviation = function(){

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0 && value != "";
          }, "Space not allowed");

        jQuery.validator.addMethod("enclosedInAngleBrackets", function(value, element) {
            return /^<.*>$/.test(value.trim()); // Checks if the value starts and ends with <>
        }, "Value must be enclosed in < and >");

        var form = $('#edit-latter-abbreviations');
        var rules = {
            key : {
                required: true,
                noSpace: true,
                enclosedInAngleBrackets: true
            },
            value : {required: true}
        };

        var message = {
            key : {required: "Please enter key name"},
            value : {required: "Please enter value"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addLatterAbbreviation();
        },
        edit:function(){
            editLatterAbbreviation();
        },
    }
}();
