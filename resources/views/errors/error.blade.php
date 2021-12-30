<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style type="text/css">body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #000000;
            background: #E8E8E8;
        }

        .container {
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content;
            max-width: 100%;
            margin: 0 auto;
            padding: 15px;
        }

        .container-inner {
            background: #FFFFFF;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            width: 100%;
            height: 165px;
            background: #F3F3F3;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
        }

        .error-description {
            padding: 35px 42px;
            font-size: 14px;
            font-weight: 500;
            color: #232323;
        }

        .error-description .error-title {
            line-height: 17px;
            margin-bottom: 4px;
        }

        .error-description .error-code {
            font-weight: bold;
            font-size: 32px;
            line-height: 39px;
            margin-bottom: 4px;
        }

        .error-description .hostname {
            line-height: 20px;
            margin-bottom: 2px;
        }

        .error-description .date {
            line-height: 17px;
            color: #727272;
        }

        .main {
            padding: 42px;
        }

        .troubleshooting {
            display: flex;
            flex-direction: row;
        }

        .troubleshooting .title {
            font-weight: bold;
            font-size: 18px;
            line-height: 22px;
            margin-bottom: 17px;
        }

        .troubleshooting .content {
            flex-basis: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
        }

        .troubleshooting .content .description {
            line-height: 18px;
            margin-bottom: 35px;
        }

        .troubleshooting .parentheses-text {
            color: #727272;
        }

        .info-container .info {
            line-height: 15px;
        }

        .info-container .info:not(:last-child) {
            margin-bottom: 8px;
        }

        .info-container .info .value {
            color: #285AE6;
        }

        .powered-by {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .powered-by .copyrights {
            color: #000000;
            text-decoration: none;
            font-size: 0;
        }

        .powered-by .copyrights::before {
            display: inline-block;

            max-width: 1rem;
        }

        .powered-by .text {
            font-weight: 300;
            font-size: 11px;
            font-style: italic;
            line-height: 15px;
            margin-right: 10px;
        }

        @media (min-width: 768px) {
            .container {
                width: 817px;
                max-width: 100%;
                margin: 15vh auto;
            }
        }

        @media (max-width: 767px) {
            .container {
                width: 507px;
            }
        }

        @media (max-width: 400px) {
            .container {
                padding: 0;
            }

            .error-description .error-code {
                font-size: 26px;
            }
        }</style>
</head>
<body>
<div class="container">
    <div class="container-inner">
        <div class="header">
            <div class="error-description">
                <div class="error-title">@yield('title')</div>
                <div class="error-code">Error @yield('code')</div>
                <div class="hostname">{{request()->ip()}}</div>
                <div class="date">{{now()}}</div>
            </div>
        </div>
        <div class="main">
            <div class="troubleshooting">
                <div class="content">
                    <div class="title">{{__('error.question')}}</div>
                    <div class="description">@yield('message')</div>
                    <div class="info-container">
                        <div class="info">
                            <span class="label">Your IP:</span>
                            <span class="value">{{request()->ip()}}</span>
                        </div>
                        <div class="info">
                            <span class="parentheses-text"> (ID UUID)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
