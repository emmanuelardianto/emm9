@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">
                <span>Post</span>
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('admin.post.create') }}">New Post</a>
                </div>
            </h2>
            <div class="mb-3">
                <form method="GET" class="form-inline">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" name="search" class="form-control" value="{{ $search }}" />
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-dark" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @include('include.alert')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="data" class="table small text-nowrap table-hover table-dropdown-hover">
                            <thead>
                                <tr>
                                    <th class="py-2">Title</th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($posts as $item)
                                <tr>
                                    <td><a href="{{ route('admin.post.show', $item) }}">{{ $item->title }}</a></td>
                                </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex">
            {{ $posts->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection