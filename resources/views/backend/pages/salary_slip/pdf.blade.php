<!DOCTYPE html>
<html>
<head>
    <title>{{ $salary_slip_details['first_name']." ".$salary_slip_details['last_name'] }}</title>

    <style type="text/css">
        @media print {
            .invoice-box {
                padding: 0;
            }
        }

        @page {
            margin: 15px;
        }

        body {
            margin: 15px;
        }

    </style>
</head>
@php
   $month= ["","January","February","March","April","May","June","July","August","September","October","November","December"];
    $grossEarnings =  numberformat($salary_slip_details['basic_salary']) + numberformat($salary_slip_details['house_rent_allow']) ;
    $lop = 0;
    if($grossEarnings > 0 && $salary_slip_details['working_day'] > 0 && $salary_slip_details['loss_of_pay'] > 0){
        $lop = number_format(($grossEarnings / ($salary_slip_details['working_day'] * $salary_slip_details['loss_of_pay'])), 0, ',', ',');
    }

    $totalDeductions =  numberformat($salary_slip_details['income_tax']) + numberformat($salary_slip_details['pf']) + numberformat($salary_slip_details['pt']) + $lop;
    $totalNetPayble = numberformat($grossEarnings) - numberformat($totalDeductions) ;

    function AmountInWords(float $amount)

{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}

@endphp
<body>


<!--begin::Entry-->
<div class="container p-5">
    <table style="width: 100%">
        <tr>
            <td style="text-align: left!important">
                <img
                    src="data:image/png;base64,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"
                    class="card-logo card-logo-dark" alt="logo dark" height="72"/>
            </td>

            <td>
                <p style="font-family: 'Times New Roman', serif !important; font-size: 20px !important; margin-bottom: -10px;">
                    BVM Infotech</p>
                <p style="font-size: 14px!important; color:#5A5A5A">
                    1049-1051, Silver Business Point,near Uttran Surat - 394105 India
                </p>
            </td>

            <td style="text-align: right!important">
                <p style="margin-bottom: -10px;">Payslip For the Month</p>
                <p><b>
                        {{ $month[$salary_slip_details['month']] }} {{ $salary_slip_details['year'] }}
                    </b></p>
            </td>
        </tr>
    </table>

    <div style="border-bottom:1px solid #c4cbd4 !important"></div>

    <table style="width: 100% !important; margin-top: 15px!important">
        <tr>
            <td align="left" style="width: 100%!important;">
                <table>
                    <tr>
                        <td style="margin-bottom: 50px; font-size: 14px!important; font-style: bold">EMPLOYEE
                            SUMMARY
                        </td>
                    </tr>

                    <tr>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important; color:#5A5A5A">
                            Employee Name
                        </td>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important;">
                            : {{ $salary_slip_details['first_name']." ".$salary_slip_details['last_name'] }}</td>
                    </tr>

                    {{-- <tr>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important; color:#5A5A5A">
                            Employee ID
                        </td>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important;">
                            : {{ $salary_slip_details['emp_no']}}</td>
                    </tr> --}}

                    <tr>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important; color:#5A5A5A">
                            Pay Period
                        </td>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important;">
                            : {{ $month[$salary_slip_details['month']] }}
                            - {{ $salary_slip_details['year'] }}</td>
                    </tr>

                    <tr>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important; color:#5A5A5A">
                            Pay Date
                        </td>
                        <td style="margin-top: 10px !important;padding-top: 10px !important; font-size: 14px!important;">
                            : {{ date_formate($salary_slip_details['pay_salary_date']) }}</td>
                    </tr>

                </table>
            </td>
            <td style="float:right; text-align: right; ">
                <table
                    style="width: 80% !important;  margin: 0px 140px; margin-left: 50px; border: 1px solid #c4cbd4; border-radius: 10px !important">
                    <tr style="background-color: #edfcf1; text-align: left;">
                        <td colspan="2">
                            <p style="font-size: 20px!important; color:black;
                                    padding: 2px;
                                    margin: 15px 0 15px 15px;
                                    /*font-size: 18px;*/
                                    box-sizing: border-box;
                                    /*position: relative;*/
                                    border-left: 3px solid #17dc3f;
                                    padding-left: 15px;">
                                <span style="font-size: large; font-weight: bold"><span
                                        style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($totalNetPayble, ',') }}</span><br>
                                Employee Net Pay</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom:1px solid; border-bottom-style: dotted;">
                        </td>
                    </tr>
                    <tr style="">
                        <td style="padding-left: 25px!important; padding-top: 5px!important;font-size: 14px!important; color:#5A5A5A">
                            Paid Days
                        </td>
                        <td style="padding-left: 25px!important; padding-top: 5px!important;font-size: 14px!important; color:black">
                            : {{ $salary_slip_details['working_day'] }}</td>
                    </tr>

                    <tr>
                        <td style="padding-left: 25px!important; padding-bottom: 5px!important; padding-top: 5px!important; font-size: 14px!important; color:#5A5A5A">
                            LOP Days
                        </td>
                        <td style="padding-left: 25px!important; padding-bottom: 5px!important; padding-top: 5px!important; font-size: 14px!important; color:black">
                            : {{ $salary_slip_details['loss_of_pay'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table
        style="width: 100% !important; margin-top: 45px!important; border: 1px solid #c4cbd4 !important; border-radius: 10px; padding: -7   px !important">
        <tr>
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important; padding: 5px!important; font-weight: bold; font-size: 12px; ">
                            EARNINGS
                        </td>
                        <td style="text-align: right !important; padding: 5px!important; font-weight: bold; font-size: 12px;">
                            AMOUNT
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom:1px solid; border-bottom-style: dotted "></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-weight: bold; padding: 5px!important; font-size: 12px;">
                            DEDUCTIONS
                        </td>
                        <td style="text-align: right !important; font-weight: bold; padding: 5px!important; font-size: 12px;">
                            AMOUNT
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom:1px solid; border-bottom-style: dotted "></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">Basic</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($salary_slip_details['basic_salary'], 2)}}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">Income Tax</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($salary_slip_details['income_tax'], 2)}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">House Rent Allowance</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{numberformat($salary_slip_details['house_rent_allow'], 2) }}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">Provident Fund</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{numberformat ($salary_slip_details['pf'], 2)}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important"></td>
                        <td style="text-align: right !important"></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">Professional Tax</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{numberformat($salary_slip_details['pt'], 2)}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important"></td>
                        <td style="text-align: right !important"></td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-size: small">Loss of pay</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{numberformat($lop,2)}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr style="background-color: #f3f0f0; width: 100%!important; padding: 10px;!important;">
            <td style="text-align: left !important">
                <table style="width: 95% !important;">
                    <tr>
                        <td style="text-align: left !important; font-weight: bold; font-size: 12px;">Gross Earnings</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($grossEarnings, ',') }}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100% !important;">
                    <tr>
                        <td style="text-align: left !important; font-weight: bold; font-size: 12px;">Total Deductions</td>
                        <td style="text-align: right !important; font-weight: bold;"><span
                                style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($totalDeductions, ',') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table
        style="width: 100% !important; margin-top: 45px!important; border: 1px solid #c4cbd4 !important; border-radius: 10px;">
        <tr>
            <td style="text-align: left !important">
                <b style="font-weight: bold; font-family: 'Pacifico'; font-size: 15px;">TOTAL NET PAYABLE</b> <br>
                <span style="font-size: small"> Gross Earnings - Total Deductions</span>
            </td>
            <td style="text-align: right !important;font-weight: bold; width: 100px;
                padding: 10px;
                background-color: #edfcf1;
                box-sizing: border-box;box-sizing: content-box;box-sizing: padding-box;">
                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ numberformat($totalNetPayble, ',') }}
            </td>
        </tr>
    </table>

    <h6 style="float: right;font-size: small">
        <span class="text-muted">Amount In Words</span>
        : {{ AmountInWords(numberformat($totalNetPayble)) }}
    </h6>
    <div style="border-bottom:1px solid gray !important; margin-top: 70px;"></div>

    <p style="text-align: center; font-size: small; color: #3f3f3f">
        -- This is a system generated payslip, hence the signature is not required. --
    </p>
</div>


</body>
</html>
