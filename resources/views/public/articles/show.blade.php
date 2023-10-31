@extends('layouts.portal')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="float-start">
                        <h2>{{ $article->title }}</h2>
                    </div>
                    <div class="float-end">
                        {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                    </div>
                    <br>
                    <img class="img-fluid" src="{{ $article->image }}">
                    <p>
                        {!! $article->content !!}
                    </p>
                    <hr />
                    <h4>Display Comments</h4>

                    @include('partials.commentsDisplay', ['comments' => $article->comments, 'article_id' => $article->id])

                    @auth
                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('dashboard.comments.store') }}">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body"></textarea>
                            <input type="hidden" name="article_id" value="{{ $article->id }}" />
                        </div>
                        <div class="form-group pt-3">
                            <input type="submit" class="btn btn-success" value="Add Comment" />
                        </div>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
