@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold"><i class="fas fa-users text-primary me-2"></i>User Management</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </button>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users</h5>
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" class="form-control" id="userSearch" name="search" placeholder="Search users..."
                            value="{{ request('search') }}">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">User</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Activity</th>
                                <th scope="col" class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->id !== auth()->id())
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                                        class="rounded-circle me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #e0e0e0;">
                                                    <span
                                                        class="position-absolute bottom-0 end-0 p-1 bg-{{ $user->status == '1' ? 'success' : 'secondary' }} rounded-circle"
                                                        style="width: 12px; height: 12px; border: 2px solid white;"></span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                                    <p class="text-muted small mb-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $user->user_type === 'admin' ? 'warning' : 'info' }} text-dark">
                                                {{ ucfirst($user->user_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $user->status == '1' ? 'success-subtle text-success' : 'danger-subtle text-danger' }} px-3 py-2">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                {{ $user->status == '1' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small text-muted">
                                                Last login: {{ now()->subHours(rand(1, 72))->format('M d, g:i A') }}
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button
                                                    class="btn btn-outline-{{ $user->status == '1' ? 'warning' : 'success' }} btn-sm toggle-status-btn"
                                                    data-user-id="{{ $user->id }}" data-current-status="{{ $user->status }}">
                                                    <i class="fas fa-{{ $user->status == '1' ? 'ban' : 'check' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUser{{ $user->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if($users->where('id', '!=', auth()->id())->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="py-5">
                                            <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                                            <h5 class="mt-3">No other user accounts found</h5>
                                            <p class="text-muted">Start by adding new users to your bookstore</p>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addUserModal">
                                                <i class="fas fa-user-plus me-2"></i>Add New User
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary-subtle text-primary mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary p-3 me-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h2 class="mb-0">{{ $users->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success-subtle text-success mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success p-3 me-3">
                                <i class="fas fa-user-check text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Users</h6>
                                <h2 class="mb-0">{{ $activeUsersCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger-subtle text-danger mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger p-3 me-3">
                                <i class="fas fa-user-times text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Inactive Users</h6>
                                <h2 class="mb-0">{{ $inactiveUsersCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning-subtle text-warning mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 me-3">
                                <i class="fas fa-user-shield text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Admin Users</h6>
                                <h2 class="mb-0">{{ $adminUsersCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.updateOrCreateUsers') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_type" class="form-label">User Role</label>
                            <select class="form-select" id="user_type" name="user_type" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        @if ($user->id !== auth()->id())
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.users.updateOrCreateUsers') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Leave blank to keep current password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                                <div class="mb-3">
                                    <label for="user_type" class="form-label">User Role</label>
                                    <select class="form-select" id="user_type" name="user_type" required>
                                        <option value="user" {{ $user->user_type === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @if ($user->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" {{ $user->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $user->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
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
                                This action cannot be undone. All user data will be permanently removed.
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
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(".toggle-status-btn").on("click", function () {
                var userId = $(this).data('user-id');
                var currentStatus = $(this).data('current-status');
                var newStatus = currentStatus == '1' ? '0' : '1';

                if (confirm('Are you sure you want to change this user status to ' + (newStatus == '1' ? 'Active' : 'Inactive') + '?')) {
                    $.ajax({
                        url: '/admin/users/' + userId + '/toggle-status',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush

