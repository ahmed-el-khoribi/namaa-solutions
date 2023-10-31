@extends('layouts.portal')

@section('content')
<div class="card-header">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Role Management</h2>
            </div>
            <div class="float-end">
            @can('roles_create')
                <a class="btn btn-success" href="{{ route('portal.roles.create') }}"> Create New Role</a>
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
        <th width="280px">Action</th>
    </tr>
        @foreach ($roles as $key => $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('portal.roles.show',$role->id) }}">Show</a>
                @can('roles_edit')
                    <a class="btn btn-primary" href="{{ route('portal.roles.edit',$role->id) }}">Edit</a>
                @endcan
                @can('roles_delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['portal.roles.destroy', $role->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @endforeach
    </table>

    {!! $roles->render() !!}
</div>
@endsection
