@extends('layouts.portal')

@section('content')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>tinymce.init({selector:'#content'});</script>

<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Create New Article</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('dashboard.articles.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('route' => 'dashboard.articles.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Brief:</strong>
                {!! Form::textarea('brief', null, array('placeholder' => 'Brief','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control', 'id' => 'content')) !!}
            </div>
        </div>
        <!-- Image Field -->
        <div class="col-xs-12 col-sm-12 col-md-12 pt-3">
            <div class="form-group">
                {!! Form::label('image', 'Image:') !!}
                {!! Form::file('image') !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center pt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection
