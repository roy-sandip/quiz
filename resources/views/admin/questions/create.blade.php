@extends('adminlte::page')
@section('content_header')
    <h1 class="m-0 text-dark">Header</h1>
@stop
@section('content')

<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body table-responsive">
                 <x-message/>
                  <form action="#">
                      <div class="form-group">
                          <label for="">Question</label>
                          <textarea name="question" id="" cols="30" rows="10" class="form-control"></textarea>
                      </div>
                  </form>
                </div>
                <div class="card-footer text-center">
                   
                </div>
            </div>
        </div>
    </div>




@endsection