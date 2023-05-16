@extends('welcome')

@section('content')

@if(Auth::user()->role == 1)
    @include('components.calender')
@else
    @include('components.activities')
@endif

@endsection