@extends('layouts.app')

@section('title')
Courier
@endsection

@section('content')
<my-header :user="{{ json_encode($auth_user) }}" :logo="{{ json_encode($company_logo) }}" ></my-header>
<transition name="fade">
<router-view :user="{{ json_encode($auth_user) }}" :logo="{{ json_encode($company_logo) }}"></router-view>
</transition>
<my-footer></my-footer>
@endsection