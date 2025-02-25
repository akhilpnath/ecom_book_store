@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Search Books</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.books.search.results') }}" method="get" class="d-flex gap-2">
                    <input type="text" name="query" class="form-control" placeholder="Search books...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

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
                                </div>

                                <div class="card-footer">
                                    <form action="{{ route('admin.books.import', $item['id']) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-download"></i> Import
                                        </button>
                                    </form>
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
                                <td>
                                    <form action="{{ route('admin.books.import', $item['id']) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-download"></i> Import
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">No results found.</div>
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
        });
    </script>
@endpush