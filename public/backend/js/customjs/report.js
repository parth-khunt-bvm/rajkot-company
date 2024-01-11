var Report = function () {
    var expenseReport = function () {

        loadExpenseChart();

        $('body').on('change', '.change', function() {
            var html = '';
            html = '<div id="expense-reports"></div>';
            $('.expense-reports-chart').html(html);
            loadExpenseChart();
        });

        function loadExpenseChart(){
            var manager = $('#manager_id').val();
            var branch = $("#branch_id").val();
            var type = $("#type_id").val();
            var year = $("#expense_year_id").val();
            var time = $("#expense_report_time").val();
            var data = {'manager' : manager,'branch' : branch,'type' : type,'year' : year,'time' : time} ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/report/ajaxcall",
                data: { 'action': 'get-expense-reports-data', 'data' : data},
                success: function (data) {
                    $("#loader").show();
                    var res = JSON.parse(data);
                    console.log("sssss",res);
                    const apexChart = "#expense-reports";
                    var options = {
                        series: [
                            {
                                name: 'silver',
                                type: 'column',
                                data: res.amount.silver ,
                            },
                            {
                                name: 'rajkot',
                                type: 'column',
                                data: res.amount.rajkot ,
                            },
                            {
                                name: 'katargam',
                                type: 'column',
                                data: res.amount.katargam ,
                            },
                         ],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                            borderRadius: 10,
                            columnWidth: '40%',
                            dataLabels: {
                                orientation: 'vertical',
                                position: 'top',
                                textAnchor: 'middle',
                            },
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                if (val === 0) {
                                    return "";
                                }
                                return "₹ "+ val.toFixed( 0);
                            },
                            style: {
                                fontSize: '12px',
                                colors: ['#333'],
                            },
                            offsetY: 0o5,
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: res.month
                        },
                        yaxis: [
                            {
                                axisTicks: {
                                    show: true,
                                },
                                axisBorder: {
                                    show: true,
                                    color: "#9D689E"
                                },
                                labels: {
                                    style: {
                                        colors: "#9D689E",
                                    }
                                },
                                title: {
                                    text: "Sales",
                                    style: {
                                        color: "#9D689E",
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        ],
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val.toFixed(2) + " thousands";
                                }
                            }
                        },

                        // colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();

                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
        $("body").on("click", ".reset", function(){
            location.reload(true);
        });

        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $("body").on("click", "#show-expense-filter", function() {
            $("div .expense-filter").slideToggle("slow");
        })
    }

    var revenueReport = function () {

        loadRevenueChart();

        // $('body').on('change', '.change', function() {
        //     var html = '';
        //     html = '<div id="revenue-reports"></div>';
        //     $('.revenue-reports-chart').html(html);
        //     loadRevenueChart();
        // });

        $('body').on('click', '.change-revenue-report', function() {
            var html = '';
            html = '<div id="revenue-reports"></div>';
            $('.revenue-reports-chart').html(html);
            loadRevenueChart();
        });

        function loadRevenueChart(){
            var manager = $('#manager_id').val();
            var technology = $("#technology_id").val();
            var year = $("#revenue_year_id").val();
            var time = $("#revenue_report_time").val();
            var startDate = $('#start_date_id').val();
            var endDate = $('#end_date_id').val();

            var data = {'manager' : manager,'technology' : technology,'year' : year,'time' : time,'startDate': startDate, 'endDate': endDate } ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/report/ajaxcall",
                data: { 'action': 'get-revenue-reports-data', 'data' : data},
                success: function (data) {
                    $("#loader").show();
                    var res = JSON.parse(data);
                    const apexChart = "#revenue-reports";
                    var options = {
                        series: [{
                            name: 'Revenue',
                            type: 'column',
                            data: res.amount ,
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                columnWidth: '40%',
                                dataLabels: {
                                    orientation: 'vertical',
                                    position: 'top',
                                    textAnchor: 'middle',
                                },
                            },
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                if (val === 0) {
                                    return "";
                                }
                                return "₹ "+val.toFixed(0);
                            },
                            style: {
                                fontSize: '12px',
                                colors: ['#333'],
                            },
                            offsetY: 0o5,
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: res.month
                        },
                        yaxis: [
                            {
                                axisTicks: {
                                    show: true,
                                },
                                axisBorder: {
                                    show: true,
                                    color: "#9D689E"
                                },
                                labels: {
                                    style: {
                                        colors: "#9D689E",
                                    }
                                },
                                title: {
                                    text: "Sales",
                                    style: {
                                        color: "#9D689E",
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        ],
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val + " thousands"
                                }
                            }
                        },
                        // colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();

                },
                complete: function () {
                    $('#loader').hide();
                }
            });

            $("body").on("click", "#show-revenue-filter", function() {
                $("div .revenue-filter").slideToggle("slow");
            })
        }
        $("body").on("click", ".reset", function(){
            location.reload(true);
        });

        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $("body").on("change", ".change_report", function(){
            reportval = $(".change_report").val();
            if(reportval == "custom"){
                $(".date").slideDown("slow");
            } else {

                $('#start_date_id').val(" ");
                $('#end_date_id').val(" ");
                $(".date").slideUp("slow");
            }
        });
    }

    var salaryReport = function () {

        loadSalaryChart();

        $('body').on('change', '.change', function() {
            var html = '';
            html = '<div id="salary-reports"></div>';
            $('.salary-reports-chart').html(html);
            loadSalaryChart();
        });

        function loadSalaryChart(){
            var manager = $('#manager_id').val();
            var technology = $("#technology_id").val();
            var branch = $("#branch_id").val();
            var year = $("#salary_year_id").val();
            var time = $("#salary_report_time").val();
            var data = {'manager' : manager,'technology' : technology,'branch' : branch,'year' : year,'time' : time} ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/report/ajaxcall",
                data: { 'action': 'get-salary-reports-data', 'data' : data},
                success: function (data) {
                    $("#loader").show();
                    var res = JSON.parse(data);
                    const apexChart = "#salary-reports";
                    var options = {
                        series: [{
                            name: 'Salary',
                            type: 'column',
                            data: res.amount ,
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                        bar: {
                            borderRadius: 10,
                            columnWidth: '40%',
                            dataLabels: {
                                orientation: 'vertical',
                                position: 'top',
                                textAnchor: 'middle',
                            },
                        },
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                if (val === 0) {
                                    return "";
                                }
                                return "₹ "+val.toFixed(0);
                            },
                            style: {
                                fontSize: '12px',
                                colors: ['#333'],
                            },
                            offsetY: 0o5,
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: res.month
                        },
                        yaxis: [
                            {
                                axisTicks: {
                                    show: true,
                                },
                                axisBorder: {
                                    show: true,
                                    color: "#9D689E"
                                },
                                labels: {
                                    style: {
                                        colors: "#9D689E",
                                    }
                                },
                                title: {
                                    text: "Sales",
                                    style: {
                                        color: "#9D689E",
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        ],
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val + " thousands"
                                }
                            }
                        },
                        // colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();

                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
        $("body").on("click", ".reset", function(){
            location.reload(true);
        });

        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
        $("body").on("click", "#show-salary-filter", function() {
            $("div .salary-filter").slideToggle("slow");
        })
    }

    var profitLossReport = function () {

        loadProfitLossChart();

        $('body').on('change', '.change', function() {
            var html = '';
            html = '<div id="profit-loss-reports"></div>';
            $('.profit-loss-reports-chart').html(html);
            loadProfitLossChart();
        });

        function loadProfitLossChart(){
            var branch = $("#branch_id").val();
            var technology = $("#technology_id").val();
            var month = $("#month_of").val();
            var year = $("#profit_loss_year_id").val();
            var time = $("#profit_loss_report_time").val();
            var data = {'technology' : technology,'branch' : branch,'month' : month,'year' : year,'time' : time,} ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/report/ajaxcall",
                data: { 'action': 'get-profit-loss-reports-data', 'data' : data},
                success: function (data) {
                    $("#loader").show();

                    const apexChart = "#profit-loss-reports";
                    var res = JSON.parse(data);

                    var profitLoss = [];

                    for (var i = 0; i < res.amount.revenue.length; i++) {
                        var profitLossValue = res.amount.revenue[i] - res.amount.expense[i] - res.amount.salary[i];
                        profitLoss.push(profitLossValue);
                    }
                    var options = {
                        series: [{
                            name: 'Expense',
                            type: 'column',
                            data: res.amount.expense ,
                        },
                        {
                            name: 'Revenue',
                            type: 'column',
                            data: res.amount.revenue ,
                        },
                        {
                            name: 'Salary',
                            type: 'column',
                            data: res.amount.salary ,
                        },
                        {
                            name: 'profit-loss',
                            type: 'column',
                            data: res.amount.revenue.map((value, index) => value - res.amount.expense[index] - res.amount.salary[index]),
                            stack: 'total',

                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                            borderRadius: 10,
                            columnWidth: '40%',
                            dataLabels: {
                                orientation: 'vertical',
                                position: 'top',
                                textAnchor: 'middle',
                            },
                            },
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                if (val === 0) {
                                    return "";
                                }
                                return "₹ "+val.toFixed(0);
                            },
                            style: {
                                fontSize: '12px',
                                colors: ['#333'],
                            },
                            offsetY: 0o5,
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: res.month
                        },
                        yaxis: [
                            {
                                axisTicks: {
                                    show: true,
                                },
                                axisBorder: {
                                    show: true,
                                    color: "#9D689E"
                                },
                                labels: {
                                    style: {
                                        colors: "#9D689E",
                                    }
                                },
                                title: {
                                    text: "Sales",
                                    style: {
                                        color: "#9D689E",
                                    }
                                },
                                tooltip: {
                                    enabled: true
                                }
                            }
                        ],
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val + " thousands"
                                }
                            }
                        },

                        // colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();

                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }

        $("body").on("click", ".reset", function(){
            location.reload(true);
        });

        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $("body").on("click", "#show-profit-loss-filter", function() {
            $("div .profit-loss-filter").slideToggle("slow");
        })
    }

    var profitLossByTimeReport = function () {
        $('.select2').select2();
        loadExpenseChartByTime();

        $('body').on('change', '.change', function() {
            console.log("hii");
            var html = '';
            html = '<div id="profit-loss-by-time" class="d-flex justify-content-center"></div>';
            $('.profit-loss-by-time-reports-chart').html(html);
            loadExpenseChartByTime();
        });

        $('body').on('change', '.change_report', function() {

            var reportTime = $("#report_time").val();

            if(reportTime == "annually"){
                 loadExpenseChartByTime()
                var html = '';
                html = '<div id="profit-loss-by-time" class="d-flex justify-content-center"></div>';
                $('.profit-loss-by-time-reports-chart').html(html);

                function loadExpenseChartByTime(){
                    var reportTime = $("#report_time").val();
                    var data = {'reportTime' : reportTime} ;
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/report/ajaxcall",
                    data: { 'action': 'get-expense-by-time-reports-data-annually', 'data' : data},
                    success: function (data) {
                        $("#loader").show();
                        var res = JSON.parse(data);
                        const apexChart = "#profit-loss-by-time";
                        var options = {
                            series: [res.expense, res.revenue, res.salary],
                            chart: {
                                width: 380,
                                type: 'donut',
                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 200
                                    },
                                }
                            }],
                            legend: {
                                position: 'bottom',
                                display: false
                            },
                            labels: ['Expense', 'Revenue', 'salary']
                            // colors: [primary, success, warning, danger, info]
                        };
                        var chart = new ApexCharts(document.querySelector(apexChart), options);
                        chart.render();
                    },
                    complete: function () {
                        $('#loader').hide();
                    }
                });
               }
            }
            if(reportTime == "monthly"){
                loadExpenseChartByTime()
               var html = '';
               html = '<div id="profit-loss-by-time" class="d-flex justify-content-center"></div>';
               $('.profit-loss-by-time-reports-chart').html(html);

               function loadExpenseChartByTime(){
                   var reportTime = $("#report_time").val();
                   var data = {'reportTime' : reportTime} ;
               $.ajax({
                       type: "POST",
                       headers: {
                           'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                       },
                       url: baseurl + "admin/report/ajaxcall",
                       data: { 'action': 'get-expense-by-time-reports-data-monthly', 'data' : data},
                           success: function (data) {
                               $("#loader").show();
                               var res = JSON.parse(data);
                               const apexChart = "#profit-loss-by-time";
                               var options = {
                                   series: [res.expense, res.revenue, res.salary],
                                   chart: {
                                       width: 380,
                                       type: 'donut',
                                   },
                                   responsive: [{
                                       breakpoint: 480,
                                       options: {
                                           chart: {
                                               width: 200
                                           },
                                       }
                                   }],
                                   legend: {
                                       position: 'bottom',
                                       display: false
                                   },

                                   labels: ['Expense', 'Revenue', 'salary']
                                   // colors: [primary, success, warning, danger, info]
                               };

                               var chart = new ApexCharts(document.querySelector(apexChart), options);
                               chart.render();
                           },
                           complete: function () {
                               $('#loader').hide();
                           }
               });
              }
            }
            if(reportTime == "semiannually"){
            loadExpenseChartByTime()
           var html = '';
           html = '<div id="profit-loss-by-time" class="d-flex justify-content-center"></div>';
           $('.profit-loss-by-time-reports-chart').html(html);

           function loadExpenseChartByTime(){
               var reportTime = $("#report_time").val();
               var data = {'reportTime' : reportTime} ;
           $.ajax({
                   type: "POST",
                   headers: {
                       'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                   },
                   url: baseurl + "admin/report/ajaxcall",
                   data: { 'action': 'getProfitLossByTimeReportsDataSemiAnnually', 'data' : data},
                       success: function (data) {
                           $("#loader").show();
                           var res = JSON.parse(data);
                           const apexChart = "#profit-loss-by-time";
                           var options = {
                               series: [res.expense, res.revenue, res.salary],
                               chart: {
                                   width: 380,
                                   type: 'donut',
                               },
                               responsive: [{
                                   breakpoint: 480,
                                   options: {
                                       chart: {
                                           width: 200
                                       },
                                   }
                               }],
                               legend: {
                                   position: 'bottom',
                                   display: false
                               },

                               labels: ['Expense', 'Revenue', 'salary']
                               // colors: [primary, success, warning, danger, info]
                           };

                           var chart = new ApexCharts(document.querySelector(apexChart), options);
                           chart.render();
                       },
                       complete: function () {
                           $('#loader').hide();
                       }
           });
          }
            }
            if(reportTime == "quarterly"){
            loadExpenseChartByTime()
           var html = '';
           html = '<div id="profit-loss-by-time" class="d-flex justify-content-center"></div>';
           $('.profit-loss-by-time-reports-chart').html(html);

           function loadExpenseChartByTime(){
               var reportTime = $("#report_time").val();
               var data = {'reportTime' : reportTime} ;
           $.ajax({
                   type: "POST",
                   headers: {
                       'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                   },
                   url: baseurl + "admin/report/ajaxcall",
                   data: { 'action': 'getProfitLossByTimeReportsDataQuarterly', 'data' : data},
                       success: function (data) {
                           $("#loader").show();
                           var res = JSON.parse(data);
                           const apexChart = "#profit-loss-by-time";
                           var options = {
                               series: [res.expense, res.revenue, res.salary],
                               chart: {
                                   width: 380,
                                   type: 'donut',
                               },
                               responsive: [{
                                   breakpoint: 480,
                                   options: {
                                       chart: {
                                           width: 200
                                       },
                                   }
                               }],
                               legend: {
                                   position: 'bottom',
                                   display: false
                               },

                               labels: ['Expense', 'Revenue', 'salary']
                               // colors: [primary, success, warning, danger, info]
                           };

                           var chart = new ApexCharts(document.querySelector(apexChart), options);
                           chart.render();
                       },
                       complete: function () {
                           $('#loader').hide();
                       }
           });
          }
            }
        });

        function loadExpenseChartByTime(){
            var time = $("#report_time").val();
            var year = $("#profit_loss_time_year_id").val();
            var data = {'time' : time, 'year' : year} ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/report/ajaxcall",
                data: { 'action': 'get-expense-by-time-reports-data', 'data' : data},
                success: function (data) {
                    $("#loader").show();
                    var res = JSON.parse(data);
                    const apexChart = "#profit-loss-by-time";
                    var options = {
                        series: [res.expense, res.revenue, res.salary],
                        chart: {
                            width: 380,
                            type: 'donut',
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                // legend: {
                                //     // position: 'bottom',
                                //     display: false
                                // }
                            }
                        }],
                        legend: {
                            position: 'bottom',
                            display: false
                        },

                        labels: ['Expense', 'Revenue', 'salary']
                        // colors: [primary, success, warning, danger, info]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                },
                error: function(err){
                    console.log("err");
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
	}

    return {
        expense: function () {
            expenseReport();
        },
        revenue: function () {
            revenueReport();
        },
        salary: function () {
            salaryReport();
        },
        profitLoss: function () {
            profitLossReport();
        },
        profitLossByTime: function () {
            profitLossByTimeReport();
        },
    }
}();
