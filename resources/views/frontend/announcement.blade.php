<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A New Beginning - Zaylish Studio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
            padding: 20px 0;
        }

        /* Animated background pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.02) 35px, rgba(255,255,255,.02) 70px);
            animation: slide 20s linear infinite;
        }

        @keyframes slide {
            0% { transform: translateX(0); }
            100% { transform: translateX(70px); }
        }

        .container {
            max-width: 900px;
            padding: 40px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo {
            margin-bottom: 60px;
            animation: fadeInDown 1s ease-out;
        }

        .logo img {
            max-width: 200px;
            height: auto;
            filter: brightness(0) invert(1);
        }

        .content {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        h1 {
            font-size: 3rem;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 30px;
            line-height: 1.2;
            background: linear-gradient(135deg, #ffffff 0%, #cccccc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 40px;
            color: #e0e0e0;
            line-height: 1.8;
        }

        .date-box {
            display: inline-block;
            background: #ffffff;
            color: #000000;
            padding: 20px 40px;
            border-radius: 10px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        .date-box .day {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
            letter-spacing: 1px;
        }

        .date-box .month-year {
            font-size: 1.2rem;
            font-weight: 300;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        .message {
            font-size: 1.1rem;
            color: #cccccc;
            margin-top: 40px;
            font-style: italic;
            line-height: 1.6;
        }

        .divider {
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ffffff, transparent);
            margin: 40px auto;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
            }
        }

        /* Tablet devices */
        @media (max-width: 1024px) {
            .container {
                max-width: 700px;
                padding: 30px;
            }

            h1 {
                font-size: 2.5rem;
            }

            .subtitle {
                font-size: 1.2rem;
            }
        }

        /* Mobile devices */
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .logo {
                margin-bottom: 40px;
            }

            .logo img {
                max-width: 150px;
            }

            .content {
                padding: 40px 25px;
                border-radius: 15px;
            }

            h1 {
                font-size: 1.8rem;
                letter-spacing: 1px;
                margin-bottom: 20px;
            }

            .subtitle {
                font-size: 1rem;
                margin-bottom: 30px;
            }

            .date-box {
                padding: 15px 30px;
                margin: 20px 0;
            }

            .date-box .day {
                font-size: 1.8rem;
            }

            .date-box .month-year {
                font-size: 0.95rem;
            }

            .message {
                font-size: 1rem;
                margin-top: 30px;
            }

            .divider {
                width: 80px;
                margin: 30px auto;
            }
        }

        /* Small mobile devices */
        @media (max-width: 480px) {
            .container {
                padding: 15px 10px;
            }

            .logo {
                margin-bottom: 30px;
            }

            .logo img {
                max-width: 120px;
            }

            .content {
                padding: 30px 20px;
                border-radius: 12px;
            }

            h1 {
                font-size: 1.5rem;
                letter-spacing: 0.5px;
            }

            .subtitle {
                font-size: 0.9rem;
                line-height: 1.6;
            }

            .date-box {
                padding: 12px 25px;
            }

            .date-box .day {
                font-size: 1.5rem;
            }

            .date-box .month-year {
                font-size: 0.85rem;
                letter-spacing: 1px;
            }

            .message {
                font-size: 0.95rem;
            }

            .divider {
                width: 60px;
                margin: 25px auto;
            }
        }

        /* Extra small devices */
        @media (max-width: 360px) {
            h1 {
                font-size: 1.3rem;
            }

            .subtitle {
                font-size: 0.85rem;
            }

            .date-box .day {
                font-size: 1.3rem;
            }

            .date-box .month-year {
                font-size: 0.75rem;
            }

            .message {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('frontend/images/icons/zaylishlogo-1.png') }}" alt="Zaylish Studio">
        </div>

        <div class="content">
            <h1>A New Beginning,<br>Slightly Rescheduled</h1>

            <div class="divider"></div>

            <p class="subtitle">
                We apologize for the delay on Jan 23rd due to unforeseen technical circumstances.
            </p>

            <div class="date-box">
                <span class="day">Saturday</span>
                <span class="month-year">January 24th, 2026</span>
            </div>

            <p class="message">
                We are now ready to welcome you. See you soon!
            </p>
        </div>
    </div>
</body>
</html>
