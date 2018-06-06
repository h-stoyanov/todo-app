@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Users</div>
                    <div class="panel-body">
                        <div class="list-group">
                            @foreach($users as $user)
                                <a href="{{route('admin.users.show', ['user' => $user->id])}}" class="list-group-item">{{$user->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection