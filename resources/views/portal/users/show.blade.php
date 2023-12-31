@extends('layouts.portal')


@section('content')
<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2> Show User</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('portal.users.index') }}"> Back</a>
            </div>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Roles:</strong>
                @if($user->getRoleNames()->isNotEmpty())
                    @foreach($user->getRoleNames() as $v)
                        {{ $v }}
                    @endforeach
                @else
                    {{ __('Registered User') }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
