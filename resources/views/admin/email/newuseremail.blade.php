<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration - Admin Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/useradminemail.css') }}">
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