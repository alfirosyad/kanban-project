<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
{{--    <title>Home</title>--}}
</head>

@extends('layouts.master')

@section('pageTitle', 'Home')  {{-- Ditambahkan --}}

@section('main')
  <div class="container">
    <div class="main">
      <div class="task-summary-container">
{{--        @if (Auth::check())--}}
{{--          <h1 class="task-summary-greeting">--}}
{{--            Hi, {{ Auth::user()->name }} !--}}
{{--          </h1>--}}
{{--        @else--}}
{{--          <h1 class="task-summary-greeting">Hi, Guest!</h1>--}}
{{--        @endif--}}
        <h1 class="task-summary-greeting">Hi, {{ Auth::user()->name }} !</h1>
        <h1 class="task-summary-heading">Summary of Your Tasks</h1>

        <div  class="task-summary-list">
          <span class="material-icons">check_circle</span>
          <h2>You have completed {{ $completed_count }} task</h2>
        </div>

        <div class="task-summary-list">
          <span class="material-icons">list</span>
          <h2>You still have {{ $uncompleted_count }} tasks left</h2>
        </div>
      </div>
    </div>
@endsection

</html>
