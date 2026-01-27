<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportEvents</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }

        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem;
        }

        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo { font-size: 1.5rem; font-weight: bold; }

        .nav-links { display: flex; gap: 1.5rem; list-style: none; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { opacity: 0.8; }

        .auth-buttons { display: flex; gap: 0.5rem; }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-primary {
            background: #ff6b6b;
            color: white;
            border: none;
        }

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }

        .footer {
            background: #333;
            color: white;
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
@include('layouts.header')

<main class="container">
    @yield('content')
</main>

@include('layouts.footer')
</body>
</html>
