<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ public_path('css/app.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/dist/img/favicon-32x32.png')}}">
    <style>
        body {
            font-size: 12px;
        }

        #header h1 {
            font-size: 18px;
            text-transform: uppercase;
            margin: 0;
        }

        #header h2 {
            font-size: 16px;
        }

        h3#title-header {
            margin: 5px 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        th span {
            display: block;
            padding: 0 5px;
            background: #eee;
        }

        th {
            vertical-align: top !important;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: #000;
            text-align: center;
        }

        .application-id {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .application-id span {
            font-size: 20px;
            font-weight: bold;
        }

        .noBorder {
            border: none !important;
        }
    </style>
    <title>CRMS-Report</title>
</head>

<body>
    <center>
        <table class="table float-end text-end noBorder">
            <tr>
                <td width="60%">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/dist/img/letter_head.png'))) }}" height="60">
                </td>
                <td style="text-align: right;">{!! nl2br(e(session('CompanyAddress'))) !!}</td>
            </tr>
        </table>
        
    </center>

    <hr>
    <div class="mt-1 text-center mb-4">
        <h5>@yield('title')</h5>
    </div>
    <div class="content mt-3">
        @yield('content')
    </div>
    <div class="footer">
        @yield('footer')
        <div class="mt-7 font-italic text-center">
            <small>This is system generated document. No signature(s) required. Document generated on {{ date('d F Y') }}.</small>
        </div>
    </div>
</body>

</html>