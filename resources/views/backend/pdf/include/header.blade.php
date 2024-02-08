<head>
    <meta charset="utf-8">
    {{-- <title>{{ $pdf_title}}</title> --}}
    <style type="text/css">


      @font-face {
        font-family: sans-serif, DejaVu Sans;
        /* src: url(SourceSansPro-Regular.ttf); */
      }

      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      a {
        color: #0087C3;
        text-decoration: none;
      }

      body {
        /* max-width: 800px !important; */
        position: relative;
        /* width: 21cm; */
        /* height: 29.7cm; */
        margin: 0 auto;
        color: #555555;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-family: sans-serif, Arial;
      }

      header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #a373a4;
      }

      #logo {
        float: left;
        margin-top: 8px;
      }

      #logo img {
        height: 70px;
      }

      #company {
        /* float: right; */
        text-align: right;
      }


      #details {
        margin-bottom: 50px;
      }

      #client {
        padding-left: 6px;
        border-left: 6px solid #a373a4;
        float: left;
      }

      #client .to {
        color: #777777;
      }

      h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
        /* margin-bottom: 5px; */
      }
      .mb-5{
          margin-bottom: 5px !important;
      }

      #invoice {
        float: right;
        text-align: right;
      }

      #invoice h1 {
        color: #0087C3;
        font-size: 2.4em;
        line-height: 1em;
        font-weight: normal;
        margin: 0  0 10px 0;
      }

      #invoice .date {
        font-size: 1.1em;
        color: #777777;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
      }

      table tr:nth-child(2n-1) td {
        background: #F5F5F5;
      }

      table th,
      table td {
        text-align: left;
      }

      table td {
        font-weight: normal;
        font-size: 12px;
      }
      table th {
        padding: 5px 10px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;
        /* font-weight: 500; */
        font-weight: normal;
        color: #1f2236;
        font-size: 14px;
      }

      table .service,
      table .desc {
        text-align: left;
      }

      table td {
        padding: 10px;
        text-align: left;
      }

      table td.service,
      table td.desc {
        vertical-align: top;
      }

      table td.unit,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }

      table td.grand {
        border-top: 1px solid #5D6975;;
      }


      #thanks{
        font-size: 2em;
        margin-bottom: 50px;
      }

      #notices{
        padding-left: 6px;
        border-left: 6px solid #0087C3;
      }

      #notices .notice {
        font-size: 1.2em;
      }

      footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #a373a4;
        padding: 8px 0;
        text-align: center;
      }

      footer a{
        color: #555579;
      }
      .text-center{
        color: #a373a4;
        font-size: 18px;
        font-weight: bold;
        font-family: sans-serif, Arial;
        text-align: center !important;
        margin-bottom: 10px;
        padding: 5px;
      }
      .border-bottom{
        border-bottom: 2px solid #a373a4;
      }

      .text-right{
          text-align: right !important;
      }
      .text-center{
          text-align: center !important;
      }
      * { font-family: DejaVu Sans, sans-serif; }
        @page { margin: 10px; }

    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>
