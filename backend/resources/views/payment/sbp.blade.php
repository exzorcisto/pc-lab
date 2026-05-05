<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата СБП | PC Labs</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #0d0d0d;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
        }
        .payment-card {
            background: #1a1a1a;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            text-align: center;
            max-width: 400px;
            width: 100%;
            border: 1px solid #333;
        }
        .sbp-logo {
            width: 120px;
            margin-bottom: 20px;
        }
        .amount {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
            color: #00a86b; /* Твой зеленый из макета */
        }
        .order-info {
            color: #888;
            margin-bottom: 30px;
        }
        .qr-placeholder {
            background: #fff;
            padding: 15px;
            display: inline-block;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .btn-pay {
            background: #00a86b;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
            text-decoration: none;
            display: block;
        }
        .btn-pay:hover {
            background: #008f5a;
        }
    </style>
</head>
<body>
    <div class="payment-card">
        <img src="{{ asset('img/icon sbp.svg') }}" alt="СБП" class="sbp-logo">
        <div class="order-info">Заказ №{{ $order->id }}</div>
        <div class="amount">{{ number_format($amount, 0, '.', ' ') }} ₽</div>
        
        <div class="qr-placeholder">
            <!-- Генерируем QR со ссылкой на твой гитхаб или сайт проекта -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://github.com/Artem" alt="QR Code">
        </div>

        <p style="font-size: 14px; color: #666; margin-bottom: 30px;">
            Отсканируйте QR-код в приложении любого банка для оплаты
        </p>

        <!-- Кнопка имитирует успешный ответ от банка -->
        <form action="{{ url('/api/orders/' . $order->id . '/pay') }}" method="POST">
            @csrf
            <button type="submit" class="btn-pay">Подтвердить оплату</button>
        </form>
    </div>
</body>
</html>