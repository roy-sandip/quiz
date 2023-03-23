@extends('adminlte::page')
@section('content_header')
    <h1 class="m-0 text-dark">Questions</h1>
@stop
@section('content')

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body table-responsive">
                 <x-message/>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                
                                <th>Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->question}}</td>
                                <td>{{$item->getAnswer()}}</td>
                                <td>
                                    <a href="{{route('admin.questions.edit', $item->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                   {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>




@endsection