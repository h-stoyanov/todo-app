@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Task Lists</div>
                    <div class="panel-body">
                        <ul class="list-group" id="accordion" role="tablist">
                            @foreach($lists as $list)
                                <li class="list-group-item" data-list-id="{{$list->id}}">
                                    {{$list->name}}
                                    <button class="btn btn-danger btn-sm delete-list"><span
                                                class="glyphicon glyphicon-remove"></span> Delete
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(document).on('click', 'button.delete-list', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/admin/destroy/' + $(this).parent().attr('data-list-id'),
                    method: 'post',
                    success: function (response) {
                        bootbox.alert(response.message)
                    },
                    error: function (jqXHR) {
                        bootbox.alert(jqXHR.responseJSON.message);
                    }
                })
            })
        });
    </script>
@endsection