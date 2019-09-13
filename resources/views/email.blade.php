@extends('layouts.email')

@section('title','Contácto')

@section('content')

<h1>Tienes un nuevo mensaje de: {{ $name }}</h1>

<h4>
Email: {{ $email }}
</h4>
<hr>
<h4>Mensaje:</h4>
<p>
{{ $user_message }}
</p>

@endsection