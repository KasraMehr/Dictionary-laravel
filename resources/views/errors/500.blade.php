<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - خطای داخلی سرور</title>
    <style>
        body {
            background-color: #f3f3f3;
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            background: #fff;
            padding: 30px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            font-size: 80px;
            color: #ff4757;
            margin: 0;
        }
        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            padding: 10px 25px;
            font-size: 16px;
            background-color: #ff4757;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }
        a:hover {
            background-color: #e84118;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>500</h1>
        <p>خطای داخلی سرور رخ داده است. لطفاً بعداً دوباره تلاش کنید.</p>
        <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>
    </div>
</body>
</html>
