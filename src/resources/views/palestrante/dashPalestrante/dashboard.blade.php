@extends('layout.palestrante')

@section('title', 'Visão Geral')
@section('pg-titulo', 'Visão Geral')
@section('link-topo', 'Início')

@section('content')

   @include('palestrante.dashPalestrante.controle')

@endsection