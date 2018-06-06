@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Archived Task Lists</div>
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
                                                        <th class="col-md-8 col-sm-10">Name</th>
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
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12" data-list-id="{{$list->id}}">
                                                    <button class="btn btn-primary pull-right export-list"><span class="glyphicon glyphicon-floppy-save"></span> Export</button>
                                                    <button class="btn btn-danger pull-right delete-list"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                                    <button class="btn btn-info pull-right restore-list"><span class="glyphicon glyphicon-export"></span> Restore</button>
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
            $(document).on('click', 'button.delete-list', function (e) {
                e.preventDefault();
                const listId = $(this).parent().attr('data-list-id');
                $.ajax({
                    url: '/lists/' + listId,
                    method: 'put',
                    data: {delete_list: 1},
                    success: function () {
                        $('div#' + listId).parent().remove();
                        let msg = 'Your delete request was send to administrator!';
                        bootbox.alert(msg);
                    },
                    error: function () {
                        let msg = 'Cannot delete the list';
                        bootbox.alert(msg);
                    }
                })
            });

            $(document).on('click', 'button.restore-list', function (e) {
                e.preventDefault();
                const listId = $(this).parent().attr('data-list-id');
                $.ajax({
                    url: '/lists/' + listId,
                    method: 'put',
                    data: {archive: 0},
                    success: function () {
                        $('div#' + listId).parent().remove();
                        let msg = 'Successfully restored the list';
                        bootbox.alert(msg);
                    },
                    error: function () {
                        let msg = 'Cannot restore the list';
                        bootbox.alert(msg);
                    }
                })
            });
        })
    </script>
@endsection