@extends('layouts.app')

@section('title')
Courier
@endsection

@section('content')
<my-header :user="{{ Auth::user() }}" ></my-header>
<transition name="fade">
<router-view :user="{{ Auth::user() }}"></router-view>
</transition>
@endsection