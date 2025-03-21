<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه‌ای یافت نشد</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

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
            padding: 100px;
            margin: 50px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            font-size: 100px;
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
            padding: 10px 20px;
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
        <h1>404</h1>
        <p>متأسفیم! صفحه‌ای که به دنبال آن هستید یافت نشد.</p>
        <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>
    </div>
</body>
</html>
