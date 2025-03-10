@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">
                    <i class="fas fa-user-circle text-primary me-2"></i>User Profile
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Users
                </a>
            </div>
        </div>

        <div class="row">
            <!-- User Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center position-relative">
                        <div class="position-absolute top-0 end-0 p-3">
                            <span class="badge bg-{{ $user->active_status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                                {{ ucfirst($user->active_status) }}
                            </span>
                        </div>

                        <div class="mt-4 mb-3">
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                    class="rounded-circle img-thumbnail"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <span
                                    class="position-absolute bottom-0 end-0 p-1 bg-{{ $user->active_status == 'active' ? 'success' : 'secondary' }} rounded-circle"
                                    style="width: 20px; height: 20px; border: 3px solid white;"></span>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                        <span class="badge bg-{{ $user->user_type === 'admin' ? 'warning' : 'info' }} text-dark mb-3">
                            {{ ucfirst($user->user_type) }}
                        </span>

                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-3 border-end">
                                <h4 class="mb-0">{{ $orderCount }}</h4>
                                <small class="text-muted">Orders</small>
                            </div>
                            <div class="px-3 border-end">
                                <h4 class="mb-0">${{ number_format($totalSpent, 2) }}</h4>
                                <small class="text-muted">Spent</small>
                            </div>
                            <div class="px-3">
                                <h4 class="mb-0">{{ $user->reviews()->count() }}</h4>
                                <small class="text-muted">Reviews</small>
                            </div>
                        </div>

                        <hr>

                        <div class="text-start">
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-primary me-3" style="width: 16px;"></i>
                                <span>{{ $user->email }}</span>
                            </p>
                            @if($user->phone)
                                <p class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-primary me-3" style="width: 16px;"></i>
                                    <span>{{ $user->phone }}</span>
                                </p>
                            @endif
                            @if($user->address)
                                <p class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-3" style="width: 16px;"></i>
                                    <span>
                                        {{ $user->address }}<br>
                                        @if($user->city || $user->state || $user->zip_code)
                                            <span class="ms-4">
                                                {{ $user->city }}{{ $user->city && ($user->state || $user->zip_code) ? ',' : '' }}
                                                {{ $user->state }} {{ $user->zip_code }}
                                            </span>
                                        @endif
                                    </span>
                                </p>
                            @endif
                            <p class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt text-primary me-3" style="width: 16px;"></i>
                                <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                            </p>
                            <p class="d-flex align-items-center mb-0">
                                <i class="fas fa-clock text-primary me-3" style="width: 16px;"></i>
                                <span>Last active {{ now()->subHours(rand(1, 72))->diffForHumans() }}</span>
                            </p>
                        </div>
                    </div>

                    @if($user->id !== auth()->id())
                        <div class="card-footer bg-light d-flex">
                            <button
                                class="btn btn-outline-{{ $user->active_status == 'active' ? 'warning' : 'success' }} w-50 me-1 toggle-status-btn"
                                data-user-id="{{ $user->id }}" data-current-status="{{ $user->active_status }}">
                                <i class="fas fa-{{ $user->active_status == 'active' ? 'ban' : 'check' }} me-1"></i>
                                {{ $user->active_status == 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                            <button class="btn btn-outline-danger w-50 ms-1" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Activity and Analytics -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Order History -->
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5>
                            </div>
                            <div class="card-body p-0">
                                @if($recentOrders->isNotEmpty())
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Order ID</th>
                                                                    <th>Date</th>
                                                                    <th>Items</th>
                                                                    <th>Total</th>
                                                                    <th>Status</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($recentOrders as $order)
                                                                                                <tr>
                                                                                                    <td>#{{ $order->id }}</td>
                                                                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                                                                    <td>{{ $order->orderItems->count() }}</td>
                                                                                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                                                                                    <td>
                                                                                                        <span class="badge bg-{{ 
                                                                                                            $order->status === 'completed' ? 'success' :
                                                                    ($order->status === 'processing' ? 'info' :
                                                                        ($order->status === 'pending' ? 'warning' : 'secondary')) 
                                                                                                        }}">
                                                                                                            {{ ucfirst($order->status) }}
                                                                                                        </span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                                                            class="btn btn-sm btn-outline-primary">
                                                                                                            <i class="fas fa-eye"></i>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-shopping-cart text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-3">No orders found for this user</p>
                                    </div>
                                @endif
                            </div>
                            @if($orderCount > 5)
                                <div class="card-footer text-center">
                                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}"
                                        class="text-decoration-none">
                                        View all {{ $orderCount }} orders <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Analytics -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Reading Preferences</h5>
                            </div>
                            <div class="card-body">
                                @if($favoriteGenres->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-book text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-3">No genre data available yet</p>
                                    </div>
                                @else
                                    <div id="genreChart" style="min-height: 250px;"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Activity Timeline</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @if($recentOrders->isEmpty())
                                        <div class="text-center py-4">
                                            <i class="fas fa-calendar-alt text-muted" style="font-size: 3rem;"></i>
                                            <p class="mt-3">No recent activity</p>
                                        </div>
                                    @else
                                        <div class="p-3 border-start border-4 border-info ms-3">
                                            <div class="d-flex">
                                                <div class="bg-info rounded-circle p-2 me-3" style="height: fit-content;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">Account Created</h6>
                                                    <p class="text-muted small mb-0">
                                                        {{ $user->created_at->format('M d, Y - g:i A') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($recentOrders->take(3) as $order)
                                            <div class="p-3 border-start border-4 border-primary ms-3">
                                                <div class="d-flex">
                                                    <div class="bg-primary rounded-circle p-2 me-3" style="height: fit-content;">
                                                        <i class="fas fa-shopping-cart text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Placed order #{{ $order->id }}</h6>
                                                        <p class="mb-1">{{ $order->orderItems->count() }} items -
                                                            ${{ number_format($order->total_amount, 2) }}</p>
                                                        <p class="text-muted small mb-0">
                                                            {{ $order->created_at->format('M d, Y - g:i A') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach($user->reviews()->latest()->take(2)->get() as $review)
                                            <div class="p-3 border-start border-4 border-warning ms-3">
                                                <div class="d-flex">
                                                    <div class="bg-warning rounded-circle p-2 me-3" style="height: fit-content;">
                                                        <i class="fas fa-star text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Left a {{ $review->rating }}-star review</h6>
                                                        <p class="mb-1">{{ Str::limit($review->comment, 50) }}</p>
                                                        <p class="text-muted small mb-0">
                                                            {{ $review->created_at->format('M d, Y - g:i A') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>?</p>
                    <p class="text-danger small">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        This action cannot be undone. All user data including orders, reviews, and profile information will
                        be permanently removed.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Toggle user status
            $(".toggle-status-btn").on("click", function () {
                var userId = $(this).data('user-id');
                var currentStatus = $(this).data('current-status');
                var newStatus = currentStatus === 'active' ? 'inactive' : 'active';

                if (confirm('Are you sure you want to change this user status to ' + newStatus + '?')) {
                    $.ajax({
                        url: '/admin/users/' + userId + '/toggle-status',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus
                        },
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                }
            });

            @if(!$favoriteGenres->isEmpty())
                // Initialize the genre chart
                var options = {
                    series: [{
                        data: [
                            @foreach($favoriteGenres as $genre => $count)
                                {{ $count }},
                            @endforeach
                        ]
                    }],
                    chart: {
                        type: 'bar',
                        height: 250,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                            distributed: true,
                            dataLabels: {
                                position: 'top'
                            },
                        }
                    },
                    colors: ['#4361ee', '#3f37c9', '#4895ef', '#4cc9f0', '#560bad'],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val;
                        },
                        offsetX: 20,
                        style: {
                            fontSize: '12px',
                            colors: ['#000']
                        }
                    },
                    xaxis: {
                        categories: [
                            @foreach($favoriteGenres as $genre => $count)
                                "{{ $genre }}",
                            @endforeach
                        ],
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    legend: {
                        show: false
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };

                var chart = new ApexCharts(document.querySelector("#genreChart"), options);
                chart.render();
            @endif
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Timeline styling */
        .list-group-flush div:last-child {
            border-bottom: none !important;
        }

        /* Status badge styling */
        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }
    </style>
@endpush