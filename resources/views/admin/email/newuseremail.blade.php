<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration - Admin Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            padding: 15px 0;
            background-color: #2c3e50;
            color: white;
            border-radius: 6px 6px 0 0;
            margin-bottom: 20px;
        }

        .user-details {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 12px;
        }

        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
            padding: 8px 16px;
            font-weight: bold;
            margin: 15px 0;
            display: inline-block;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New User Registration</h2>
            <p>Admin Notification</p>
        </div>

        <div class="content">
            <p>A new user has registered on the BookStore platform. Below are the complete user details:</p>

            <div class="user-details">
                <div class="detail-item">
                    <span class="label">User ID:</span>
                    <span>{{ $user->id }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Name:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">User Type:</span>
                    <span>{{ $user->user_type }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Registration Date:</span>
                    <span>{{ date_format($user->created_at, 'Y-M-d h:i') }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">IP Address:</span>
                    <span>{{ request()->ip() }}</span>
                </div>
                @if($user->image)
                    <div class="detail-item">
                        <span class="label">Profile Image:</span>
                        <span>{{ $user->image }}</span>
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('admin.users.index', $user->id) }}" class="btn-primary">View User Profile</a>
            </div>

            <p class="mt-4">This is an automated notification. Please do not reply to this email.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} BookStore Admin System</p>
            <p>This is a system-generated email for administrative purposes only.</p>
        </div>
    </div>
</body>

</html>