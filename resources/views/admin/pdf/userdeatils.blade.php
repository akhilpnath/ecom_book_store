<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Book Store</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .header-container {
            background-color: #2c3e50;
            color: white;
            padding: 20px 30px;
            width: 100%;
        }

        .logo-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .date {
            font-size: 12px;
            opacity: 0.8;
        }

        .page-title {
            text-align: center;
            margin: 30px 0 20px;
            font-size: 24px;
            font-weight: 300;
            color: #2c3e50;
        }

        .content {
            padding: 20px 30px;
        }

        .summary-box {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .summary-title {
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
        }

        .table-container {
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #3498db;
            color: white;
        }

        table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
        }

        table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #2ecc71;
            color: white;
        }

        .status-inactive {
            background-color: #e74c3c;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            padding: 10px 30px;
            font-size: 11px;
            color: #777;
            text-align: center;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-container">
        <div class="logo-section">
            <div class="logo">E-Commerce Book Store</div>
            <div class="date">Generated: {{ date('F d, Y - h:i A') }}</div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="page-title">User Management Report</h1>

        <div class="summary-box">
            <div class="summary-title">SUMMARY</div>
            <div>Total Users: <strong>{{ $users->count() }}</strong></div>
            <div>Active Users: <strong>{{ $users->where('status', '1')->count() }}</strong></div>
            <div>Inactive Users: <strong>{{ $users->where('status', '!=', '1')->count() }}</strong></div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>USER</th>
                        <th>EMAIL</th>
                        <th>STATUS</th>
                        <th>ROLE</th>
                        <th>JOINED</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->status == '1')
                                    <span class="status-badge status-active">Active</span>
                                @else
                                    <span class="status-badge status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($user->user_type) }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>CONFIDENTIAL - For Internal Use Only</div>
        <div>Page <span class="page-number"></span> | User Management System</div>
    </div>
</body>

</html>