@extends('layouts.portal')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        @can('manage_own_articles')
                            <div class="col-lg-12 margin-tb">
                                <div class="float-start">
                                    <h2>My Articles</h2>
                                </div>
                                <div class="float-end">
                                    <a class="btn btn-success" href="{{ route('dashboard.articles.create') }}"> Create New
                                        Article</a>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Thumb</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Published At</th>
                                    <th width="280px">Action</th>
                                </tr>
                                @foreach ($data as $key => $article)
                                    <tr>
                                        <td>{{ $article->author->name }}</td>
                                        <td><img src="{{ $article->file ? $article->image_thumb : '' }}"></td>
                                        <td>{{ $article->title }}</td>
                                        <td>{!! $article->status_html !!}</td>
                                        <td>{{ $article->created_at->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</td>
                                        <td>
                                            <a class="btn btn-info"
                                                href="{{ route('dashboard.articles.show', $article->id) }}">Show</a>
                                            <a class="btn btn-primary"
                                                href="{{ route('dashboard.articles.edit', $article->id) }}">Edit</a>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['dashboard.articles.destroy', $article->id],
                                                'style' => 'display:inline',
                                            ]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $data->render() !!}
                        @else
                            {{ __('You are logged in!') }}
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
