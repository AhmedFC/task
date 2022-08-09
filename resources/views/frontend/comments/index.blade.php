@extends('layouts.app')
@section('posts')
    {{ __('Posts') }}
@endsection
@section('content')

    @livewire('comments')


@endsection
