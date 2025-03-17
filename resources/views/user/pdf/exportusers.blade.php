<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15px;
        }

        .container {
            width: 100%;
        }

        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            font-weight: 600;
        }

        .header {
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }

        .header h1 {
            font-size: 18px;
            color: #007bff;
            margin: 0;
        }

        .header p {
            font-size: 11px;
            color: #6c757d;
            margin: 5px 0 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 8px 10px;
            margin-bottom: 10px;
            border-left: 3px solid #007bff;
        }

        .section-header h2 {
            margin: 0;
            font-size: 14px;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th {
            text-align: left;
            background-color: #f8f9fa;
            padding: 6px 8px;
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
            color: #495057;
        }

        table td {
            padding: 6px 8px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: top;
        }

        .compact-table td,
        .compact-table th {
            padding: 4px 6px;
            font-size: 11px;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 3px;
            text-align: center;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-info {
            background-color: #17a2b8;
            color: #fff;
        }

        .user-info-box {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 10px;
            color: #6c757d;
            text-align: center;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
            padding-right: 10px;
            padding-left: 10px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 10px;
            padding-left: 10px;
        }

        /* Bootstrap-style total row */
        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Bootstrap-style card for order details */
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .card-header {
            padding: 8px 12px;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-body {
            flex: 1 1 auto;
            padding: 10px;
        }

        @page {
            margin: 15px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="header">
            <h1>USER DETAILS REPORT</h1>
            <p>Generated on: {{ date('F d, Y - h:i A') }}</p>
        </div>

        <!-- User Profile -->
        @if(count($users) > 0)
                <div class="section">
                    <div class="section-header">
                        <h2>ACCOUNT INFORMATION</h2>
                    </div>

                    <div class="user-info-box">
                        <div class="row">
                            <div class="col-6">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <th width="35%">Name</th>
                                            <td>{{ $users[0]['Name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $users[0]['Email'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if(strtolower($users[0]['Status']) == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="compact-table">
                                    <tbody>
                                        <tr>
                                            <th width="35%">Last Login IP</th>
                                            <td>{{ $users[0]['Last Login IP'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Login Time</th>
                                            <td>{{ $users[0]['Last Login Time'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="section">
                    <div class="section-header">
                        <h2>ADDRESS INFORMATION</h2>
                    </div>

                    <table>
                        <tbody>
                            <tr>
                                <th width="20%">Address Line 1</th>
                                <td>{{ $users[0]['Address Line 1'] }}</td>
                                <th width="20%">Address Line 2</th>
                                <td>{{ $users[0]['Address Line 2'] }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $users[0]['City'] }}</td>
                                <th>State</th>
                                <td>{{ $users[0]['State'] }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $users[0]['Country'] }}</td>
                                <th>Pincode</th>
                                <td>{{ $users[0]['Pincode'] }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td colspan="3">{{ $users[0]['Phone Number'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Order History -->
                <div class="section">
                    <div class="section-header">
                        <h2>ORDER HISTORY</h2>
                    </div>

                    @php
                        $hasOrders = false;
                        $totalAmount = 0;
                    @endphp

                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Products</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                        @if($user['Order Number'] != 'N/A')
                                                    @php
                                                        $hasOrders = true;
                                                        // Add to totals, handling potential currency symbols
                                                        $price = preg_replace('/[^0-9.]/', '', $user['Total Price']);
                                                        $totalAmount += floatval($price);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $user['Order Number'] }}</td>
                                                        <td>{{ $user['Order Name'] }}</td>
                                                        <td>{{ $user['Order Email'] }}</td>
                                                        <td>{{ $user['Placed On'] }}</td>
                                                        <td>{{ $user['Total Products'] }}</td>
                                                        <td>{{ $user['Total Price'] }}</td>
                                                        <td>
                                                            @if(strtolower($user['Payment Status']) == 'paid')
                                                                <span class="badge badge-success">Paid</span>
                                                            @elseif(strtolower($user['Payment Status']) == 'pending')
                                                                <span class="badge badge-warning">Pending</span>
                                                            @else
                                                                <span class="badge badge-info">{{ $user['Payment Status'] }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                        @endif
                            @endforeach

                            @if(!$hasOrders)
                                <tr>
                                    <td colspan="7" style="text-align: center; font-style: italic;">No order history available</td>
                                </tr>
                            @else
                                <tr class="total-row" style="text-align: right;">
                                    <td colspan="5"><strong>TOTAL AMOUNT:</strong></td>
                                    <td><strong>{{ $totalAmount }}</strong></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    @if($hasOrders)
                            @php
                                // Get unique order details to avoid duplication
                                $uniqueOrders = [];
                                foreach ($users as $user) {
                                    if ($user['Order Number'] != 'N/A') {
                                        $orderKey = $user['Order Number'];
                                        if (!isset($uniqueOrders[$orderKey])) {
                                            $uniqueOrders[$orderKey] = $user;
                                        }
                                    }
                                }
                            @endphp

                            <div class="section">
                                <div class="section-header">
                                    <h2>ORDER DETAILS</h2>
                                </div>

                                <div class="row">
                                    @foreach($uniqueOrders as $order)
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <strong>Order #{{ $order['Order Number'] }}</strong>
                                                </div>
                                                <div class="card-body">
                                                    <table class="compact-table">
                                                        <tbody>
                                                            <tr>
                                                                <th width="40%">Payment Method</th>
                                                                <td>{{ $order['Order Method'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Shipping Address</th>
                                                                <td>{{ $order['Order Address'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    @endif
                </div>
        @else
            <div style="text-align: center; padding: 30px; color: #6c757d;">
                <p>No user data available</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This is a system-generated report. For any queries, please contact support.</p>
            <p>© {{ date('Y') }} E-Commerce Book Store. All rights reserved.</p>
        </div>
    </div>
</body>

</html>