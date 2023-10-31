@extends('layouts.portal')


@section('content')
<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Users Management</h2>
            </div>
            <div class="float-end">
                @can('users_create')
                <a class="btn btn-success" href="{{ route('portal.users.create') }}"> Create New User</a>
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


    <table class="table table-bordered">
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Roles</th>
    <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
        @if($user->getRoleNames()->isNotEmpty())
            @foreach($user->getRoleNames() as $v)
                {{ $v }}
            @endforeach
        @else
            {{ __('Registered User') }}
        @endif
        </td>
        <td>

        <a class="btn btn-info" href="{{ route('portal.users.show',$user->id) }}">Show</a>
            @can('users_edit')
            <a class ="btn btn-primary" href="{{ route('portal.users.edit',$user->id) }}">Edit</a>
            @endcan
            @can('users_delete')
            {!! Form::open(['method' => 'DELETE','route' => ['portal.users.destroy', $user->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
            @endcan

        </td>
    </tr>
    @endforeach
    </table>

    {!! $data->links() !!}
</div>
@endsection
