@extends('layouts.app')

@section('page-title')
    SMArt tops
@endsection

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header text-light bg-dark">
            Most productive users:
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Images</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($imageCountTop as $topUser)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><a href="{{ route('users.show', $topUser->user) }}">{{ $topUser->username }}</a></td>
                        <td>{{ $topUser->image_count }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
    <div class="card mb-3">
        <div class="card-header text-light bg-dark">
            Top viewed users:
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Views</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($topViewedUsers as $topUser)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><a href="{{ route('users.show', $topUser->user) }}">{{ $topUser->username }}</a></td>
                        <td>{{ $topUser->views_count }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
    <div class="card">
        <div class="card-header text-light bg-dark">
            Top rated users:
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Rating</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($topRatedUsers as $topUser)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><a href="{{ route('users.show', $topUser->user) }}">{{ $topUser->username }}</a></td>
                        <td>{{ $topUser->rating_count }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
</div>
@endsection
