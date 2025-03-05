@extends(Auth::user()->user_type === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('content')
    <div class="container py-4" style="padding-top: {{ Auth::user()->user_type === 'admin' ? '1em' : '6rem' }} !important;">

        <h1 class="mb-4 text-center">Update Profile</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="m-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}"
                        class="rounded-circle"
                        style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #ddd;">
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Picture</label>
                                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png"
                                    class="form-control">
                                <input type="hidden" name="old_image" value="{{ Auth::user()->image }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Old Password</label>
                                <input type="password" name="update_pass" class="form-control"
                                    placeholder="Enter previous password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass" class="form-control"
                                    placeholder="Enter new password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass" class="form-control"
                                    placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i> Update Profile
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Go Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection