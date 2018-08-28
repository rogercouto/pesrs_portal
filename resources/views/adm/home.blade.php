@extends('layouts.adm')
@section('content')
    Bem vindo {{ Auth::user()->name }}!
@endsection