@extends('layouts.portal')

@section('content')
<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2> Show Article</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('portal.articles.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Author:</strong>
                {{ $article->author->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Publisher:</strong>
                {{ $article->approver ? $article->approver->name : '' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $article->title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Brief:</strong>
                {{ $article->brief }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                {!! $article->content !!}
            </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Image:</strong>
                <img src="{!! $article->file ? $article->image : '' !!}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status:</strong>
                {!! $article->status_html !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Created At:</strong>
                {{ $article->created_at->format('d M Y') }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Published At:</strong>
                {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
            </div>
        </div>
        @can('articles_publish')
            @if($article->status === 'PENDING_APPROVAL')
                <div class="col-xs-12 col-sm-12 col-md-6 offset-md-6">
                    <div class="form-group">
                    {!! Form::open(['method' => 'POST','route' => ['portal.articles.publish', $article->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Publish', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                    </div>
                </div>
            @endif
        @endcan
    </div>
</div>
@endsection
