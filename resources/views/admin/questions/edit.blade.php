@extends('adminlte::page')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Question # {{$question->id}}</h1>
@stop
@section('content')

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body table-responsive">
                 <x-message/>
                 <div class="row">
                     <div class="col-md-8 offset-md-2">
                       <form action="{{route('admin.questions.update', $question->id)}}" method="post">
                           @csrf
                           @method('put')
                           <div class="form-group">
                               <label for="">Question</label>
                               <input type="text" class="form-control" value="{{old('question', $question->question)}}" name="question" required>
                           </div>

                           @if($question->isMCQ())
                           <div class="form-group">
                               <label for="">Options</label>
                               <textarea name="options" id="" cols="30" rows="10" class="form-control" required>@foreach($question->options as $key => $value){{$key}}# {{$value.PHP_EOL}}@endforeach</textarea>

                           </div>
                           @endif

                           @if($question->isBoolean())
                           <div class="form-group">
                               <label for="">Options</label>
                               <textarea name="options" id="" cols="30" rows="10" class="form-control" required></textarea>
                           </div>
                           @endif
                       </form>
                     </div>
                 </div>
                </div>
                <div class="card-footer text-center">
                   
                </div>
            </div>
        </div>
    </div>




@endsection