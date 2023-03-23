@extends('layouts.public')



@section('content')
<div class="container text-center" style="margin-top: 25px;">
    <img src="{{asset('images/radio.png')}}" alt="Amateur Radio/HAM" class="img-thumbnail">
    <h1>Amateur Radio</h1>
    <a href="{{route('public.questions.random')}}" class="btn btn-primary">Practice</a>
</div>
@endsection