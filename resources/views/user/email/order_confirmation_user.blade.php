<!-- resources/views/user/email/order_confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #3498db;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        .order-details {
            margin: 20px 0;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Order!</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $order->name }},</p>
            
            <p>We're excited to let you know that your order has been received and is being processed. Here's a summary of your purchase:</p>
            
            <div class="order-details">
                <h3>Order Summary</h3>
                <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->placed_on->format('F d, Y') }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->method) }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                
                <h4>Items Ordered:</h4>
                <p>{{ $order->total_products }}</p>
                
                <h4>Shipping Address:</h4>
                <p>{{ $order->address }}</p>
            </div>
            
            <p>You can track your order by visiting our website and logging into your account.</p>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="#" class="btn">Track Your Order</a>
            </p>
            
            <p>If you have any questions or need further assistance, please don't hesitate to contact our customer service at <a href="mailto:support@bookstore.com">support@bookstore.com</a>.</p>
            
            <p>Thank you for shopping with BookStore!</p>
            
            <p>Best regards,<br>The BookStore Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} BookStore. All rights reserved.</p>
            <p>123 Reading St., Bookville, BK 12345</p>
        </div>
    </div>
</body>
</html>