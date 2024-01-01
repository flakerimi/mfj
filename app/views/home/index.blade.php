@extends('layout.default')

@section('content')
    <h1>Welcome to Our HOME</h1>
    <!-- Render data here -->
    Welcome, {{ $name }}!
    {{ config('app.name')}}
@endsection