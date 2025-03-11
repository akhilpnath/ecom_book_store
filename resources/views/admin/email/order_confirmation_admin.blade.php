<!-- resources/views/admin/email/order_confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Notification</title>
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
            background-color: #2c3e50;
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
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
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
        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }
        .status-completed {
            color: #27ae60;
            font-weight: bold;
        }
        .status-cancelled {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order Notification</h1>
        </div>
        
        <div class="content">
            <div class="alert">
                A new order has been placed and requires your attention.
            </div>
            
            <div class="order-details">
                <h3>Order Information</h3>
                <table>
                    <tr>
                        <th>Order ID:</th>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td>{{ $order->placed_on->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Customer:</th>
                        <td>{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{{ $order->number }}</td>
                    </tr>
                    <tr>
                        <th>User ID:</th>
                        <td>{{ $order->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Payment Method:</th>
                        <td>{{ ucfirst($order->method) }}</td>
                    </tr>
                    <tr>
                        <th>Payment Status:</th>
                        <td class="status-pending">{{ ucfirst($order->payment_status) }}</td>
                    </tr>
                    <tr>
                        <th>Total Amount:</th>
                        <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                    </tr>
                </table>
                
                <h4>Shipping Address:</h4>
                <p>{{ $order->address }}</p>
                
                <h4>Products Ordered:</h4>
                <p>{{ $order->total_products }}</p>
            </div>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="#" class="btn">View Order Details in Admin Panel</a>
            </p>
            
            <p>Please process this order according to standard procedures. If there are any issues with this order, please contact the customer directly.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the BookStore system.</p>
            <p>&copy; {{ date('Y') }} BookStore Admin System</p>
        </div>
    </div>
</body>
</html>