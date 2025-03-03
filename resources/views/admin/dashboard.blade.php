@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Dashboard</h1>
    </div>

    <div class="row g-3">
        @php
         $cards = [
            ['title' => 'Total Pendings', 'value' => $totalPendings, 'color' => 'danger', 'icon' => 'clock', 'route' => 'admin.orders.index'],
            ['title' => 'Completed Orders', 'value' => $totalCompleted, 'color' => 'success', 'icon' => 'check-circle', 'route' => 'admin.orders.index'],
            ['title' => 'Orders Placed', 'value' => $totalOrders, 'color' => 'primary', 'icon' => 'shopping-cart', 'route' => 'admin.orders.index'],
            ['title' => 'Total Products', 'value' => $totalProducts, 'color' => 'warning', 'icon' => 'box', 'route' => 'admin.products.index'],
            ['title' => 'Total Users', 'value' => $totalUsers, 'color' => 'info', 'icon' => 'users', 'route' => 'admin.users.index'],
            ['title' => 'Total Admins', 'value' => $totalAdmins, 'color' => 'dark', 'icon' => 'user-shield', 'route' => 'admin.users.index'],
            ['title' => 'Total Accounts', 'value' => $totalAccounts, 'color' => 'secondary', 'icon' => 'users-cog', 'route' => 'admin.users.index'],
            ['title' => 'Total Messages', 'value' => $totalMessages, 'color' => 'primary', 'icon' => 'envelope', 'route' => 'admin.messages.index']
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-{{ $card['icon'] }} fa-2x text-{{ $card['color'] }}"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="h2 mb-0 text-{{ $card['color'] }}">{{ number_format($card['value']) }}</h3>
                            <p class="text-muted mb-0">{{ $card['title'] }}</p>
                        </div>
                        <a href="{{ route($card['route']) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Orders Overview</h5>
                    <div id="ordersChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users Growth</h5>
                    <div id="usersChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var ordersChart = new ApexCharts(document.querySelector("#ordersChart"), {
        chart: { 
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#4f46e5'],
        series: [{ 
            name: "Orders",
            data: @json($ordersData)
        }],
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            labels: {
                style: {
                    colors: '#6b7280'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#6b7280'
                }
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4
        }
    });
    ordersChart.render();

    var usersChart = new ApexCharts(document.querySelector("#usersChart"), {
        chart: { 
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            }
        },
        colors: ['#818cf8'],
        series: [{
            name: "Users",
            data: @json($usersData)
        }],
        plotOptions: {
            bar: {
                borderRadius: 4
            }
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            labels: {
                style: {
                    colors: '#6b7280'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#6b7280'
                }
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4
        }
    });
    usersChart.render();
</script>
@endpush