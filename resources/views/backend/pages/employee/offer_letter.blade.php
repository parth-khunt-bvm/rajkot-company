<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Offer Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="mt-5">
        <div class="m-4">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                <img fetchpriority="high" width="130" height="80" src="https://bvminfotech.com/wp-content/uploads/2021/11/48388161_341641513233735_3100381932857327616_n-removebg-preview-1.png" class="attachment-full entered lazyloaded" alt="" data-lazy-src="https://bvminfotech.com/wp-content/uploads/2021/11/48388161_341641513233735_3100381932857327616_n-removebg-preview-1.png" data-ll-status="loaded">
                </div>

                <h1 class="text-center mt-2">Offer Letter</h1>
                <p class="text-center"> <b>To Whom It May Concern</b></p>
                <address class="text-end">
                    BVM Infotech<br>
                    Address: 1051, Silver Business Point<br>
                    VIP Circle, Uttran, Surat, Gujarat<br>
                    Email: info@bvminfotech.com<br>
                    Mobile Number: +91 70694 59872<br><br>
                    Date: {{ $created_at }}
                </address>
            </div>
            <div class="col-md-12">
                <p class="text-star ">Dear Mr. {{ $employee_name }},</p>
                <p>We are pleased to offer you the full-time position of {{ $designation }} at BVM InfoTech with a start date of {{ $date_of_joining }}. We believe that your abilities and experience will be the perfect fit for our company.</p>
                <p>We are starting with a probationary period of two months starting from the date of your joining. However, this period can be cut short or extended based on the individual’s performance and at the discretion of the management.</p>
                <p>After successfully completing the probation period, you'll be a regular team member of BVM InfoTech, and you will get paid    {{$salary}}/- on a monthly basis by direct deposit.</p>
                <p>We look forward to having you on our team! If you have any questions, please feel free to reach out at
                    your earliest convenience.</p>
                <p>To accept our offer, please sign and date this full-time offer letter as indicated below and email it back to us by {{ $date }}.</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div>Sincerely,<span style="padding-left: 400px;">Date:</span></div>
                {{-- <img src="{{ asset('employee/signature/sign.png') }}" width="200" height="80"> --}}
                <img src="{{ public_path('employee/signature/sign.png') }}" width="150" height="50">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div><span style="padding-left: 465px;">Sign:__________</span></div>
            </div>
        </div>
        </div>
    </div>
</body>
</html>

