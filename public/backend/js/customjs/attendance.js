var Attendance = function () {
    var addAttendance = function () {
        $('.select2').select2();

        $('body').on('click', '.add-attendance-button', function () {
         var attendanceform = $('#add-attendance-form');
         var rules = {
            employee_id: { required: true },
         };

         var message = {
            employee_id: { required: "Please select employee" },
         }
         handleFormValidateWithMsg(attendanceform, rules, message, function (attendanceform) {
             handleAjaxFormSubmit(attendanceform, true);
         });

            // optText = 'New elemenet';
            // optValue = 'newElement';

            // var html = "";
            // html = '<div class="row removediv">'+
            //         '<div class="col-md-4">'+
            //         '<div class="form-group">'+
            //         '<label>Absent Employee'+
            //         '<span class="text-danger">*</span>'+
            //         '</label>'+
            //         `<select class="form-control select2 employee_id" id="employee_id" name="employee_id">'+
            //         '<option value="">Please select Employee Name</option>'+
            //         '@foreach ($employee as $key => $value )'+
            //         '<option value="${optValue}">${optText}</option>'+
            //         '@endforeach'+
            //         '</select>`+
            //         '</div>'+
            //         '</div>'+
            //         '<div class="col-md-4">'+
            //         '<div class="form-group">'+
            //         '<label>Reson</label>'+
            //         '<textarea class="form-control" id="" cols="30" rows="1" name="reason" id="reason"></textarea>'+
            //         '</div>'+
            //         '</div>'+
            //         '<div class="col-md-2 padding-left-5 padding-right-5">'+
            //         '<div class="form-group">'+
            //         '<label>&nbsp;</label><br>'+
            //         '<a href="javascript:;" class="my-btn btn btn-success add-attendance-button"><i class="my-btn fa fa-plus"></i></a>'+
            //         '<a href="javascript:;" class="my-btn btn btn-danger remove-attendance ml-2"><i class="my-btn fa fa-minus"></i></a>' +
            //         '</div>'+
            //         '</div>'+
            //         '</div>';

            // $("#add_attendance_div").append(html)

            var customValid = true;
            $('#add-attendance-form').validate({
                debug: true,
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                rules: {
                    employee_id: { required: true }
                },
                messages: {
                    employee_id: { required: "Please select employee" },
                },

                invalidHandler: function (event, validator) {
                    validateTrip = false;
                    customValid = customerInfoValid();
                },

                submitHandler: function (form) {
                    $(".submitbtn:visible").attr("disabled", "disabled");
                    $("#loader").show();
                    customValid = customerInfoValid();
                    if (customValid)
                    {
                        var options = {
                            resetForm: false, // reset the form after successful submit
                            success: function (output) {
                                handleAjaxResponse(output);
                            }
                        };
                        $(form).ajaxSubmit(options);
                    }else{
                        $(".submitbtn:visible").prop("disabled",false);
                        $("#loader").hide();
                    }
                },

                errorPlacement: function(error, element) {
                    customValid = customerInfoValid();
                    var elem = $(element);
                    if (elem.hasClass("select2-hidden-accessible")) {
                        element = $("#select2-" + elem.attr("id") + "-container").parent();
                        error.insertAfter(element);
                    }else {
                        if (elem.hasClass("radio-btn")) {
                            element = elem.parent().parent();
                            error.insertAfter(element);
                        }else{
                            error.insertAfter(element);
                        }
                    }
                },
            });

            function customerInfoValid() {
                var customValid = true;
                $('.employee_select').each(function () {
                    var elem = $(this);
                    if ($(this).is(':visible')) {
                        if ($(this).val() == '' || $(this).val() == null) {
                            $(this).parent().find('.attendance_error').text('Please Select Employee');
                            customValid = false;
                        } else {
                            $(this).parent().find('.attendance_error').text('');
                        }
                    }
                });
                return customValid;
            }
        });

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;

        $("#datepicker_date").val(today);

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
        $("body").on("click", ".show-type-form", function() {
            $("#show-type-form").html('-').addClass('remove-type-form');
            $("#show-type-form").html('-').removeClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })

        $("body").on("click", ".remove-type-form", function() {
            $("#show-type-form").html('+').removeClass('remove-type-form');
            $("#show-type-form").html('+').addClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })
    }

    return {
        // init: function () {
        //     list();
        // },
        add: function () {
            addAttendance();
        },
        edit: function () {
            editAttendance();
        },
    }
}();
