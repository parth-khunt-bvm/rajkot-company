var Expensereport = function(){
    var report = function(){
        loadExpenseChart();

        $('body').on('change', '.change', function() {
            var html = '';
            html = '<div id="expense-reports"></div>';
            $('.expense-reports-chart').html(html);
            loadExpenseChart();
        });

        function loadExpenseChart(){
            var manager = $('#manager_id').val();
            var type = $("#type_id").val();
            var year = $("#expense_year_id").val();
            var time = $("#expense_report_time").val();
            var data = {'manager' : manager, 'type' : type,'year' : year,'time' : time} ;
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
                    const apexChart = "#expense-reports";

                    var series = [];

                    for (var key in res.amount) {
                        if (res.amount.hasOwnProperty(key)) {
                            series.push({
                                name: key,
                                type: 'column',
                                data: res.amount[key],
                            });
                        }
                    }

                    var options = {
                        series: series,

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
                error: function(err) {
                   console.log('errorr');
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
    return {
        init:function(){
            report();
        }
    }
}();
