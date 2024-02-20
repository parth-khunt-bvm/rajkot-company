/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*****************************************************************!*\
  !*** ../demo1/src/js/pages/custom/education/school/students.js ***!
  \*****************************************************************/

// Class definition


var KTAppsEducationSchoolTeacher = function() {
	// Private functions

	// basic demo
	var _demo = function() {
        var data = {};
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            url: baseurl + "admin/employee/bond/last/date/ajaxcall",
            data: { 'action': 'get-bond-last-date-employee', 'data': data },
            success: function (data) {
               var employee=  JSON.parse(data);
               function formatDate(inputDate) {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const day = inputDate.getDate();
                const month = months[inputDate.getMonth()];
                const year = inputDate.getFullYear();
                return `${day}-${month}-${year}`;
              }

               var datatable = $('#kt_datatable').KTDatatable({
                // datasource definition
                data: {
                    // type: 'remote',
                    // source: {
                    //     read: {
                    //         url: HOST_URL + '/api/datatables/demos/default.php',
                    //     },
                    // },
                    source: employee,
                    pageSize: 10, // display 20 records per page
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                },

                // layout definition
                layout: {
                    scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                    footer: false, // display/hide footer
                },

                // column sorting
                sortable: true,

                // enable pagination
                pagination: true,

                // columns definition
                columns: [
                     {
                        field: 'Employee',
                        title: 'Employee',
                        width: 300,
                        template: function(data) {

                            var user_img = 'http://127.0.0.1:8000/upload/userprofile/default.jpg';

                            var output = '<div class="d-flex align-items-center">\
                            <div class="symbol symbol-50 symbol-sm flex-shrink-0">\
                                <div class="symbol-label">\
                                    <img  height="48" class=" align-self-end" src="' + user_img + '" alt="photo"/>\
                                </div>\
                            </div>\
                            <div class="ml-4">\
                                <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.first_name + ' ' + data.last_name + '</div>\
                                <a href="#" class="text-muted font-weight-bold text-hover-primary">' + data.gmail + '</a>\
                            </div>\
                            </div>';


                            return output;
                        }
                    }, {
                        field: 'Contact',
                        title: 'Contact',
                        // width: 90,
                        template: function(row) {
                            var output = '';
                            var personalNumber = row.personal_number;
                            output += '<a href="#" class="text-dark-50 text-hover-primary font-weight-bold">' + personalNumber + '</a>';
                            return output;
                        }
                    },
                    {
                        field: 'DepartMent',
                        title: 'DepartMent',
                        // width: 90,
                        template: function(row) {
                            var output = '';
                            var technology = row.technology_name;
                            output += '<a href="#" class="text-dark-50 text-hover-primary font-weight-bold">' + technology + '</a>';
                            return output;
                        }
                    }, {
                        field: 'Designation',
                        title: 'Designation',
                        autoHide: false,
                        // width: 90,
                        template: function(row) {
                            var output = '';
                            var designation = row.designation_name;
                            output += '<a href="#" class="text-dark-50 text-hover-primary font-weight-bold">' + designation + '</a>';
                            return output;
                        },
                    },
                     {
                        field: 'Joined Date',
                        title: 'Joined Date',
                        type: 'date',
                        // width: 90,
                        format: 'MM/DD/YYYY',
                        template: function(row) {
                              const inputDate = new Date(row.DOJ);
                              const formattedDate = formatDate(inputDate);

                            var output = '';
                            output += '<div class="font-weight-bolder text-primary mb-0">' + formattedDate + '</div>';
                            return output;
                        },
                    },
                     {
                        field: 'Last Date',
                        title: 'Last Date',
                        type: 'date',
                        // width: 90,
                        format: 'MM/DD/YYYY',
                        template: function(row) {

                            const inputDate = new Date(row.bond_last_date);
                            const formattedDate = formatDate(inputDate);
                            var output = '';

                            output += '<div class="font-weight-bolder text-primary mb-0">' + formattedDate + '</div>';

                            return output;
                        },
                    },
                    ],
            });

            $('#kt_datatable_search_status').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Status');
            });

            $('#kt_datatable_search_type').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Type');
            });

            },

        });


		//$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

jQuery(document).ready(function() {
	KTAppsEducationSchoolTeacher.init();
});

/******/ })()
;
//# sourceMappingURL=students.js.map


