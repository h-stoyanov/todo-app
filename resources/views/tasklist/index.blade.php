@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Task Lists</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="new-list-name" placeholder="New List">
                                    <span class="input-group-btn">
                                    <button class="btn btn-success" type="button" id="add-list"><span
                                                class="glyphicon glyphicon-plus"></span> Add List</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
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
                                                                       {{$task->completed ? 'checked' : ''}} data-task-id="{{$task->id}}">
                                                            </td>
                                                            <td>{{$task->name}}</td>
                                                            <td>
                                                                <button class="btn btn-danger btn-xs delete-task"
                                                                        data-task-id="{{$task->id}}"><span
                                                                            class="glyphicon glyphicon-remove"
                                                                            aria-hidden="true"></span></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12" data-list-id="{{$list->id}}">
                                                        <button class="btn btn-primary pull-right export-list"><span class="glyphicon glyphicon-export"></span> Export</button>
                                                        <button class="btn btn-danger pull-right delete-list"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                                        <button class="btn btn-warning pull-right archive-list"><span class="glyphicon glyphicon-save"></span> Archive</button>
                                                        <button class="btn btn-success pull-right add-task"><span class="glyphicon glyphicon-plus"></span> Add Task</button>
                                                    </div>
                                                </div>
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
    <script>
        $(document).ready(function () {
            $('input[type=checkbox]').change(function () {
                let checked = $(this).is(':checked');
                $.ajax({
                    url: '/tasks/' + $(this).attr('data-task-id'),
                    method: 'put',
                    data: {
                        completed: checked,
                    }
                });
            });

            $('button.delete-task').on('click', function () {
                let that = $(this);
                bootbox.confirm('Do you want to delete this task?', function (result) {
                    if (result) {
                        $.ajax({
                            url: '/tasks/' + that.attr('data-task-id'),
                            method: 'delete',
                            data: {
                            },
                            success: function () {
                                that.parent().parent().remove();
                            }
                        })
                    }
                })
            });

            $('button#add-list').on('click', function (e) {
                e.preventDefault();
                console.log($('input#new-list-name').val());
            })
        })
    </script>
@endsection