@extends('layouts.portal')

@section('content')
<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Articles Management</h2>
            </div>
            <div class="float-end">
                @can('articles_create')
                <a class="btn btn-success" href="{{ route('portal.articles.create') }}"> Create New Article</a>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="card-body">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form method="GET">
        <div class="input-group mb-3">
          <input
            type="text"
            name="search"
            value="{{ request()->get('search') }}"
            class="form-control"
            placeholder="Search..."
            aria-label="Search"
            aria-describedby="button-addon2">
          <button class="btn btn-success" type="submit" id="button-addon2">Search</button>
        </div>
    </form>
    <table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Author</th>
        <th>Approver</th>
        <th>Thumb</th>
        <th>Title</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Published At</th>
        <th width="280px">Action</th>
    </tr>
        @foreach ($data as $key => $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>{{ $article->author->name }}</td>
            <td>{{ $article->approver ? $article->approver->name : '' }}</td>
            <td><img src="{{ $article->file ? $article->image_thumb : '' }}"></td>
            <td>{{ $article->title }}</td>
            <td>{!! $article->status_html !!}</td>
            <td>{{ $article->created_at->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('portal.articles.show',$article->id) }}">Show</a>
                @can('articles_edit')
                    <a class="btn btn-primary" href="{{ route('portal.articles.edit',$article->id) }}">Edit</a>
                @endcan
                @can('articles_delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['portal.articles.destroy', $article->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
                @can('articles_publish')
                @if($article->status === 'PENDING_APPROVAL')
                    {!! Form::open(['method' => 'POST','route' => ['portal.articles.publish', $article->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Publish', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                @endif
                @endcan
            </td>
        </tr>
        @endforeach
    </table>

    {!! $data->render() !!}
</div>
@endsection
