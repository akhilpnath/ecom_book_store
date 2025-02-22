@extends('layouts.admin')

@section('content')
<div class="dashboard">
    <h1 class="title">Dashboard</h1>
    <div style="padding: 30px;">
        <div class="box-container">
            <!-- Total Pendings -->
            <div class="box">
                <h3>${{ $totalPendings }}/-</h3>
                <p>Total Pendings</p>
                <a href="{{ route('admin.orders.index') }}" class="btn">See Orders</a>
            </div>

            <!-- Completed Orders -->
            <div class="box">
                <h3>${{ $totalCompleted }}/-</h3>
                <p>Completed Orders</p>
                <a href="{{ route('admin.orders.index') }}" class="btn">See Orders</a>
            </div>

            <!-- Orders Placed -->
            <div class="box">
                <h3>{{ $totalOrders }}</h3>
                <p>Orders Placed</p>
                <a href="{{ route('admin.orders.index') }}" class="btn">See Orders</a>
            </div>

            <!-- Products Added -->
            <div class="box">
                <h3>{{ $totalProducts }}</h3>
                <p>Products Added</p>
                <a href="{{ route('admin.products.index') }}" class="btn">See Products</a>
            </div>

            <!-- Total Users -->
            <div class="box">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
                <a href="{{ route('admin.users.index') }}" class="btn">See Accounts</a>
            </div>

            <!-- Total Admins -->
            <div class="box">
                <h3>{{ $totalAdmins }}</h3>
                <p>Total Admins</p>
                <a href="{{ route('admin.users.index') }}" class="btn">See Accounts</a>
            </div>

            <!-- Total Accounts -->
            <div class="box">
                <h3>{{ $totalAccounts }}</h3>
                <p>Total Accounts</p>
                <a href="{{ route('admin.users.index') }}" class="btn">See Accounts</a>
            </div>

            <!-- Total Messages -->
            <div class="box">
                <h3>{{ $totalMessages }}</h3>
                <p>Total Messages</p>
                <a href="{{ route('admin.messages.index') }}" class="btn">See Messages</a>
            </div>
        </div>
    </div>

</div>
@endsection