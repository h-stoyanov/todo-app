@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Task Lists</div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion" role="tablist">
                            @foreach($lists as $list)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#{{$list->id}}">
                                                {{$list->name}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{$list->id}}" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body">
                                            @if($list->tasks()->count())
                                                <table class="table table-striped table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-md-2 col-sm-2">Completed</th>
                                                        <th class="col-md-8 col-sm-8">Name</th>
                                                        <th class="col-md-2 col-sm-2">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list->tasks()->get() as $task)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox"
                                                                       {{$task->completed ? 'checked' : ''}} data-task-id="{{$task->id}}" disabled>
                                                            </td>
                                                            <td>{{$task->name}}</td>
                                                            <td>
                                                                <button class="btn btn-danger btn-xs delete-task"
                                                                        data-task-id="{{$task->id}}" disabled><span
                                                                            class="glyphicon glyphicon-remove"
                                                                            aria-hidden="true"></span></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection