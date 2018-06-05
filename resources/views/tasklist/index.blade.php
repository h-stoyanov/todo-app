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

            $(document).on('click', 'button.add-task', function (e) {
                e.preventDefault();
                const button = $(this);
                const listId = button.parent().attr('data-list-id');
                bootbox.prompt('Enter the new task name', function (name) {
                    if (name){
                        $.ajax({
                            url: '/tasks',
                            method: 'post',
                            data: {
                                list_id: listId,
                                name: name
                            },
                            success: function (response) {
                                $('div#' + listId).find('tbody').append(buildTask(response.id, name))
                            }
                        });
                    }
                })
            });

            $(document).on('click', 'button.delete-task', function (e) {
                e.preventDefault();
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

            $(document).on('click', 'button#add-list', function (e) {
                e.preventDefault();
                const newListInput = $('input#new-list-name');
                const newListName = newListInput.val();
                $.ajax({
                    url: '/lists',
                    method: 'post',
                    data: {
                        name: newListName
                    },
                    success: function (response) {
                        $('div#accordion').append(buildListPanel(response.id, newListName));
                        newListInput.val('');
                    }
                })
            });

            function buildListPanel(listId, listName) {
                return '<div class="panel panel-default">\n' +
                    '       <div class="panel-heading" role="tab">\n' +
                    '           <h4 class="panel-title">\n' +
                    '               <a role="button" data-toggle="collapse" data-parent="#accordion"\n' +
                    '                  href="#' + listId + '">\n' +
                    '                   '+ listName + '\n' +
                    '               </a>\n' +
                    '           </h4>\n' +
                    '       </div>\n' +
                    '       <div id="' + listId + '" class="panel-collapse collapse" role="tabpanel">\n' +
                    '           <div class="panel-body">\n' +
                    '                   <div class="row">\n' +
                    '                       <div class="col-md-12 col-sm-12" data-list-id="'+listId +'">\n' +
                    '                           <button class="btn btn-primary pull-right export-list"><span class="glyphicon glyphicon-export"></span> Export</button>\n' +
                    '                           <button class="btn btn-danger pull-right delete-list"><span class="glyphicon glyphicon-remove"></span> Delete</button>\n' +
                    '                           <button class="btn btn-warning pull-right archive-list"><span class="glyphicon glyphicon-save"></span> Archive</button>\n' +
                    '                           <button class="btn btn-success pull-right add-task"><span class="glyphicon glyphicon-plus"></span> Add Task</button>\n' +
                    '                       </div>\n' +
                    '                   </div>\n' +
                    '          </div>\n' +
                    '       </div>\n' +
                    '   </div>'
            }

            function buildTask(taskId, taskName) {
                return '<tr>\n' +
                    '      <td>\n' +
                    '          <input type="checkbox" data-task-id="'+ taskId +'">\n' +
                    '      </td>\n' +
                    '      <td>' + taskName +'</td>\n' +
                    '      <td>\n' +
                    '          <button class="btn btn-danger btn-xs delete-task"\n' +
                    '                  data-task-id="'+ taskId +'"><span\n' +
                    '                      class="glyphicon glyphicon-remove"\n' +
                    '                      aria-hidden="true"></span></button>\n' +
                    '      </td>\n' +
                    '  </tr>'
            }
        })
    </script>
@endsection