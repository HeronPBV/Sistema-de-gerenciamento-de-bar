@extends('layouts.main')

@section('title', 'Dashboard')

@section('head-imports')
    
    <link rel="stylesheet" type="text/css" href="/css/index.css">
@endsection


@section('content')

    <div id="bem-vindo">
        <h1>Seja bem vindo, </h1>
        <p>{{Auth::user()->name}}</p>
    </div>

    <div id="abrir-caixa-container">
        <a href="/dashboard"> Abrir caixa </a>
        <p id="dataHojeIndex"> XX/08/2022 </p>
    </div>

@endsection

@section('body-end-imports')
    <script type="text/javascript" src="/js/index.js"></script>
@endsection