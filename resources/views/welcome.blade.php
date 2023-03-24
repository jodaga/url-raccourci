@extends('template.base')

@section('content')
        <h1> URL SHORTENER  </h1>

        

        <form action="" method="POST">
             {{ csrf_field()}}
            <input type="text" name="url" value="{{ old('url') }}" placeholder="ENTER your original URL HERE" >
             {!! $errors->first('url' , '<p class="errors-msg">:message</p>') !!} 
        </form>
@endsection