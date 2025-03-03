@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Search Books</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.books.search.results') }}" method="get" class="d-flex gap-2">
                    <input type="text" name="query" class="form-control" placeholder="Search books..." value="{{ $query ?? '' }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <button id="toggleCardView" class="btn btn-outline-primary active">
                <i class="fas fa-th-large"></i> Card View
            </button>
            <button id="toggleTableView" class="btn btn-outline-secondary">
                <i class="fas fa-table"></i> Table View
            </button>
        </div>

        @if (isset($results['items']))
            <div id="cardView">
                <div class="row">
                    @foreach ($results['items'] as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if (isset($item['volumeInfo']['imageLinks']['thumbnail']))
                                    <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" class="card-img-top"
                                        alt="Book Cover">
                                @else
                                    <div class="text-center py-4 bg-light">
                                        <p class="text-muted">No Cover Available</p>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $item['volumeInfo']['title'] ?? 'No Title' }}</h5>
                                    <p class="card-text">
                                        <strong>Authors:</strong> {{ implode(', ', $item['volumeInfo']['authors'] ?? ['Unknown']) }}
                                    </p>
                                    
                                    @if(isset($item['volumeInfo']['publishedDate']))
                                    <p class="card-text"><strong>Published:</strong> {{ $item['volumeInfo']['publishedDate'] }}</p>
                                    @endif
                                    
                                    @if(isset($item['volumeInfo']['categories']))
                                    <p class="card-text"><strong>Categories:</strong> {{ implode(', ', $item['volumeInfo']['categories']) }}</p>
                                    @endif
                                    
                                    @if(isset($item['volumeInfo']['language']))
                                    <p class="card-text"><strong>Language:</strong> {{ strtoupper($item['volumeInfo']['language']) }}</p>
                                    @endif
                                    
                                    @if(isset($item['volumeInfo']['description']))
                                    <div class="card-text mt-3">
                                        <strong>Description:</strong>
                                        <p class="mt-1 description-text">{{ Str::limit($item['volumeInfo']['description'], 150) }}</p>
                                        @if(strlen($item['volumeInfo']['description']) > 150)
                                        <button class="btn btn-link p-0 show-more" data-bs-toggle="collapse" data-bs-target="#description-{{ $loop->index }}">
                                            Show more
                                        </button>
                                        <div class="collapse" id="description-{{ $loop->index }}">
                                            <p>{{ substr($item['volumeInfo']['description'], 150) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                                <div class="card-footer">
                                    @if(isset($item['exists']) && $item['exists'])
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-check"></i> Already Imported
                                        </button>
                                    @else
                                        <form action="{{ route('admin.books.import', $item['id']) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-download"></i> Import
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="tableView" class="d-none">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Authors</th>
                            <th>Published</th>
                            <th>Language</th>
                            <th>Categories</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results['items'] as $item)
                            <tr>
                                <td>
                                    @if (isset($item['volumeInfo']['imageLinks']['thumbnail']))
                                        <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="Cover"
                                            style="width: 50px;">
                                    @else
                                        <span class="text-muted">No Cover</span>
                                    @endif
                                </td>
                                <td>{{ $item['volumeInfo']['title'] ?? 'No Title' }}</td>
                                <td>{{ implode(', ', $item['volumeInfo']['authors'] ?? ['Unknown']) }}</td>
                                <td>{{ $item['volumeInfo']['publishedDate'] ?? '-' }}</td>
                                <td>{{ strtoupper($item['volumeInfo']['language'] ?? '-') }}</td>
                                <td>{{ implode(', ', $item['volumeInfo']['categories'] ?? []) }}</td>
                                <td>
                                    @if(isset($item['exists']) && $item['exists'])
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-check"></i> Already Imported
                                        </button>
                                    @else
                                        <form action="{{ route('admin.books.import', $item['id']) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i> Import
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif(isset($query) && !empty($query))
            <div class="alert alert-info">No results found for "{{ $query }}".</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Toggle between Card and Table View
            $('#toggleCardView').on('click', function () {
                $('#cardView').removeClass('d-none');
                $('#tableView').addClass('d-none');
                $('#toggleCardView').addClass('active').removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                $('#toggleTableView').removeClass('active').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
            });

            $('#toggleTableView').on('click', function () {
                $('#tableView').removeClass('d-none');
                $('#cardView').addClass('d-none');
                $('#toggleTableView').addClass('active').removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                $('#toggleCardView').removeClass('active').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
            });

            $('.show-more').on('click', function() {
                let text = $(this).text();
                $(this).text(text === 'Show more' ? 'Show less' : 'Show more');
            });
        });
    </script>
@endpush