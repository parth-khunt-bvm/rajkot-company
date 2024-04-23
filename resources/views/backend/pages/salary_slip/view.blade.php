@extends('backend.layout.app')
@section('section')
    @php

        // $data['salaryCount'] = salaryCount($salary_slip_details['basic_salary'], $salary_slip_details['working_day'], $present, $absent, $halfLeave, $shortLeave);
        // dd($data['salaryCount']);

        if ($salary_slip_details['old_basic_salary'] !== null) {
            $old_basic_salary = $salary_slip_details['old_basic_salary'];
        } else {
            $old_basic_salary = 0;
        }

        $month = [
            '',
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        $oldgrossEarnings = $old_basic_salary + numberformat($salary_slip_details['house_rent_allow']);
        $newgrossEarnings =
            $salary_slip_details['basic_salary'] + numberformat($salary_slip_details['house_rent_allow']);

        if ($salary_slip_details['working_day'] !== null && $salary_slip_details['old_working_day'] !== null) {
            $basicSalary = ($salary_slip_details['basic_salary'] + $old_basic_salary) / 2;
            $grossEarnings = ($oldgrossEarnings + $newgrossEarnings) / 2;
        } else {
            $basicSalary = $salary_slip_details['basic_salary'] + $old_basic_salary;
            $grossEarnings = $oldgrossEarnings + $newgrossEarnings;
        }

        $lopdays = $salary_slip_details['loss_of_pay'] + $salary_slip_details['old_loss_of_pay'];


        $newLopDays = $salary_slip_details['loss_of_pay'];

        $oldLopDays = $salary_slip_details['old_loss_of_pay'];

        $newLop = (numberformat($newgrossEarnings) / $salary_slip_details['working_day']) * $newLopDays;

        if ($salary_slip_details['old_working_day'] !== null) {
            $oldLop = (numberformat($oldgrossEarnings) / $salary_slip_details['old_working_day']) * $oldLopDays;
        }

        if ($salary_slip_details['working_day'] !== null && $salary_slip_details['old_working_day'] !== null) {
            $lop = ($newLop + $oldLop) / 2;
        } else {
            $lop = $newLop;
        }

        $totalDeductions =
            numberformat($salary_slip_details['income_tax']) +
            numberformat($salary_slip_details['pf']) +
            numberformat($salary_slip_details['pt']) +
            $lop;
        $totalNetPayble = numberformat($grossEarnings) - numberformat($totalDeductions);

        function AmountInWords(float $amount)
        {
            $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
            // Check if there is any number after decimal
            $amt_hundred = null;
            $count_length = strlen($num);
            $x = 0;
            $string = [];
            $change_words = [
                0 => '',
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
                4 => 'Four',
                5 => 'Five',
                6 => 'Six',
                7 => 'Seven',
                8 => 'Eight',
                9 => 'Nine',
                10 => 'Ten',
                11 => 'Eleven',
                12 => 'Twelve',
                13 => 'Thirteen',
                14 => 'Fourteen',
                15 => 'Fifteen',
                16 => 'Sixteen',
                17 => 'Seventeen',
                18 => 'Eighteen',
                19 => 'Nineteen',
                20 => 'Twenty',
                30 => 'Thirty',
                40 => 'Forty',
                50 => 'Fifty',
                60 => 'Sixty',
                70 => 'Seventy',
                80 => 'Eighty',
                90 => 'Ninety',
            ];
            $here_digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
            while ($x < $count_length) {
                $get_divider = $x == 2 ? 10 : 100;
                $amount = floor($num % $get_divider);
                $num = floor($num / $get_divider);
                $x += $get_divider == 10 ? 1 : 2;
                if ($amount) {
                    $add_plural = ($counter = count($string)) && $amount > 9 ? 's' : null;
                    $amt_hundred = $counter == 1 && $string[0] ? ' and ' : null;
                    $string[] =
                        $amount < 21
                            ? $change_words[$amount] .
                                ' ' .
                                $here_digits[$counter] .
                                $add_plural .
                                '
       ' .
                                $amt_hundred
                            : $change_words[floor($amount / 10) * 10] .
                                ' ' .
                                $change_words[$amount % 10] .
                                '
       ' .
                                $here_digits[$counter] .
                                $add_plural .
                                ' ' .
                                $amt_hundred;
                } else {
                    $string[] = null;
                }
            }
            $implode_to_Rupees = implode('', array_reverse($string));
            $get_paise =
                $amount_after_decimal > 0
                    ? 'And ' .
                        ($change_words[$amount_after_decimal / 10] .
                            "
   " .
                            $change_words[$amount_after_decimal % 10]) .
                        ' Paise'
                    : '';
            return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        }
    @endphp

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"/> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> --}}


    <style>
        .border-dashed {
            border-style: dashed !important;
        }

        .invoice-box {
            padding: 48px;
        }

        .border-bottom {
            border-bottom-width: 2px !important;
        }

        @media print {
            .invoice-box {
                padding: 0;
            }
        }
    </style>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        {{-- <div class="card-header">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div> --}}

                        <div class="container p-5">
                            <div class="invoice-box">
                                <div class="d-flex gap-4 align-items-center border-bottom my-4">
                                    <div class="mb-4">
                                        <img src="data:image/png;base64,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"
                                            class="card-logo card-logo-dark" alt="logo dark" height="72" />
                                    </div>

                                    <div class="flex-grow-1 ml-5">
                                        <h5 class="mb-1">BVM Infotech</h5>
                                        <p class="mb-0">
                                            1049-1051, Silver Business Point,near Uttran Surat - 394105 India
                                        </p>
                                    </div>

                                    <div style="text-align: right !important">
                                        <p class="mb-1">Payslip For the Month</p>
                                        <h5 class="mb-0">{{ $month[$salary_slip_details['month']] }} -
                                            {{ $salary_slip_details['year'] }}</h5>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-8">
                                    <div class="d-flex">
                                        <div class="mt-2">
                                            <table class="table table-borderless table-nowrap align-middle">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h6 class="text-uppercase">Employee Summery</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Employee Name</td>
                                                        <td class="d-flex gap-3">
                                                            <span class="mr-4">:</span>
                                                            <span
                                                                class="text-end text-dark fw-semibold font-weight-bold">{{ $salary_slip_details['first_name'] . ' ' . $salary_slip_details['last_name'] }}</span>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                <td>Employee ID</td>
                                                <td class="d-flex gap-3">
                                                    <span>:</span>
                                                    <span class="text-end text-dark fw-semibold">{{ $salary_slip_details['emp_no']}}</span>
                                                </td>
                                            </tr> --}}
                                                    <tr>
                                                        <td>Pay Period</td>
                                                        <td class="d-flex gap-3">
                                                            <span class="mr-4">:</span>
                                                            <span
                                                                class="text-end text-dark fw-semibold font-weight-bold">{{ $month[$salary_slip_details['month']] }}
                                                                - {{ $salary_slip_details['year'] }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pay Date</td>
                                                        <td class="d-flex gap-3">
                                                            <span class="mr-4">:</span>
                                                            <span
                                                                class="text-end text-dark fw-semibold font-weight-bold">{{ date_formate($salary_slip_details['pay_salary_date']) }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="border rounded-4 overflow-hidden" style="width: 250px;border-radius:10px">
                                        <div class="p-4" style="background-color: #edfcf1">
                                            <h3>₹{{ numberformat($totalNetPayble, ',') }}<h6>Employee Net Pay</h6>
                                            </h3>
                                        </div>
                                        <div class="px-4 py-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Paid Days</td>
                                                        <td class="text-start">:
                                                            {{ $salary_slip_details['working_day'] + $salary_slip_details['old_working_day'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>LOP Days</td>
                                                        <td class="text-start">: {{ $lopdays }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix mb-8"></div>
                                <div class="rounded-4 overflow-hidden mb-5"
                                    style="border-radius: 10px;border:2px solid #EBEDF3">
                                    <div class="row g-0">
                                        <div class="col-6">
                                            <div class="p-3 pb-0">
                                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                                    <tbody>
                                                        <thead
                                                            style="border: 2px dashed #dee2e6;border-top:none;border-left:none;border-right:none">
                                                            <th>EARNINGS</th>
                                                            <th class="text-right">AMOUNT</th>
                                                        </thead>
                                                        <tr>
                                                            <td>Basic</td>
                                                            <th class="text-right">₹{{ $basicSalary }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>House Rent Allowance</td>
                                                            <th class="text-right">
                                                                ₹{{ $salary_slip_details['house_rent_allow'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="px-3 mt-auto" style="background-color: #f8f8fb">
                                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                                    <tfoot>
                                                        <tr>
                                                            <th>Gross Earnings</th>
                                                            <th class="text-right">₹{{ numberformat($grossEarnings, ',') }}
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="p-3 pb-0">
                                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                                    <tbody>
                                                        <thead
                                                            style="border: 2px dashed #dee2e6;border-top:none;border-left:none;border-right:none">
                                                            <th>DEDUCTIONS</th>
                                                            <th class="text-right">AMOUNT</th>
                                                        </thead>
                                                        <tr>
                                                            <td>Income Tax</td>
                                                            <th class="text-right">
                                                                ₹{{ $salary_slip_details['income_tax'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Provident Fund</td>
                                                            <th class="text-right">₹{{ $salary_slip_details['pf'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Professional Tax</td>
                                                            <th class="text-right">₹{{ $salary_slip_details['pt'] }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Loss of pay</td>

                                                            <th class="text-right">₹{{ number_format($lop, 2) }}
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="px-3" style="background-color: #f8f8fb">
                                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total Deductions</th>
                                                            <th class="text-right">
                                                                ₹{{ numberformat($totalDeductions, ',') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border rounded-4 overflow-hidden mb-4"
                                    style="border-radius:10px">
                                    <div class="flex-grow-1 py-2 px-3">
                                        <h6>Total Net Payble</h6>
                                        <p class="text-muted mb-0">Gross Earnings - Total Deductions</p>
                                    </div>
                                    <div style="background-color: #edfcf1">
                                        <h6 class="d-flex align-items-center h-100 mb-0 px-4">
                                            ₹{{ numberformat($totalNetPayble, ',') }}</h6>
                                    </div>
                                </div>

                                <h6 class="text-end mb-4 text-right">
                                    <span class="text-muted">Amount In Words</span>
                                    : {{ AmountInWords(numberformat($totalNetPayble)) }}
                                </h6>
                                <hr class="mb-4 ">
                                <p class="text-center">
                                    -- This is a system generated payslip, hence the signature is not required. --
                                </p>
                            </div>
                        </div>

                    </div>
                    <!--end::Card-->
                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
