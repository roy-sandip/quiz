@extends('layouts.public')

@section('css')
<style>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');


.container{
    background-color: #ddd;
    color: #000;
    border-radius: 10px;
    padding: 20px;
    font-family: 'Montserrat', sans-serif;
    max-width: 700px;
}
.container > p{
    font-size: 32px;
}
.question{
    width: 75%;
}
.options{
    position: relative;
    padding-left: 40px;
}
#options label{
    display: block;
    margin-bottom: 15px;
    font-size: 14px;
    cursor: pointer;
}
.options input{
    opacity: 0;
}
.checkmark {
    position: absolute;
    top: -1px;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #555;
    border: 1px solid #ddd;
    border-radius: 50%;
}
.options input:checked ~ .checkmark:after {
    display: block;
}
.options .checkmark:after{
    content: "";
	width: 10px;
    height: 10px;
    display: block;
	background: white;
    position: absolute;
    top: 50%;
	left: 50%;
    border-radius: 50%;
    transform: translate(-50%,-50%) scale(0);
    transition: 300ms ease-in-out 0s;
}
.options input[type="radio"]:checked ~ .checkmark{
    background: #21bf73;
    transition: 300ms ease-in-out 0s;
}
.options input[type="radio"]:checked ~ .checkmark:after{
    transform: translate(-50%,-50%) scale(1);
}
.options.active {
	background-color: #d39e00;
}
.btn-primary{
    background-color: #555;
    color: #ddd;
    border: 1px solid #ddd;
}
.btn-primary:hover{
    background-color: #21bf73;
    border: 1px solid #21bf73;
}
.btn-success{
    padding: 5px 25px;
    background-color: #21bf73;
}
@media(max-width:576px){
    .question{
        width: 100%;
        word-spacing: 2px;
    } 
}
</style>
@endsection

@section('content')
<div class="container mt-sm-5 my-1">
	<form action="{{route('public.questions.check-answer')}}" method="post" id="quizQuestion">
		@csrf
		<input type="hidden" name="id" id="id" value="{{$question->id}}">
    <div class="question ml-sm-5 pl-sm-5 pt-2">
        <div class="py-2 h5"><b>Q<span id="id_label">{{$question->id}}</span>. <span id="question">{{$question->question}}</span></b></div>
        <hr>
        <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
        		@foreach($question->getOptions(true) as $key => $value)
		            <label class="options {{$key}}">{{$value}}
		                <input type="radio" name="answer" value="{{$key}}">
		                <span class="checkmark"></span>
		            </label>
        		@endforeach
        	

        </div>
    </div>
    <div class="error text-center" style="color:red"></div>
    <div class="success text-center" style="color:green;font-weight: bold;"></div>
    <div class="d-flex align-items-center pt-3">
        <div id="prev">
            <a href="{{route('public.questions.random')}}" class="btn btn-primary">Skip</a>
        </div>
        <div class="ml-auto mr-sm-5">
            <button type="submit" class="btn btn-success submit">Check</button>
            <button type="button" class="btn btn-success nextQ" onclick="loadQuestion()" style="display:none;">Next Question</button>
        </div>
    </div>
	</form>

</div>
@endsection

@section('js')
<script>
	
	let Question;

	$("#quizQuestion").on('submit', function(event){
		event.preventDefault();
		var data = new FormData(this);
		var submitBtn  = $(this).find('.submit');
		var nextQ  = $(this).find('.nextQ');
		$.ajax({
			url: "{{route('public.questions.check-answer')}}",
			type: 'POST',
			dataType: 'JSON',
			data: data,
			contentType: false,
			processData: false,
			beforeSend: function(){
				$(submitBtn).attr('disabled', true).html('Wait...');
    		},
    		complete: function(){
    			$(submitBtn).attr('disabled', false);
    		},
    		success: function(response){
    			$(submitBtn).hide().html('Check');
    			$('.options input').attr('disabled', true);
    			$(nextQ).show();
    			Question = response.newQuestion;

    			if(response.result == false)
    			{
    				$('.error').html('Wrong answer!');
    			}else{
    				$('.success').html('Correct!');
    			}
    			$('.options.'+response.question.answer).addClass('active');
    		},
    		error: function(error){
    			var message = error.responseJSON.message;
    			$('.error').html(message);
    			$(submitBtn).attr('disabled', false).html('Check');
    		}
    		
		});
	});


	function loadQuestion()
	{
		//console.log(Question);
		$("#id").val(Question.id);
		$("#id_label").html(Question.id);
		$("#question").html(Question.question);
		var options = '';
		if(Question.type == 'boolean')
		{
			options += option('True 1', 'true');
			options += option('False 0', 'false');
		}else{
			for(const key in Question.options)
			{
				options += option(Question.options[key], key);
			}
		}
		$("#options").html(options);
		$(".error").html('');
		$(".success").html('');
		$('.nextQ').hide();
		$('.submit').show();
		
	}

	function option(label, value)
	{
		return '<label class="options '+value+'">'+label+'<input type="radio" name="answer" value="'+value+'"><span class="checkmark"></span></label>';
	}
</script>
@endsection