@extends('layouts.main')

@section('title', 'Caixa')

@section('head-imports')
    <link rel="stylesheet" type="text/css" href="/css/caixa.css">
@endsection


@section('content')     


<section id="caixa-container">

    <article id="nova-venda" class="caixa-container-bg-br">
    <h3>Nova venda</h3>

    <form autocomplete="off" method="POST" action="">
        <div class="form-group">
        <label for="nome-produto">Produto: </label>
        <div id="add-line">
            <input type="text" id="nome-produto" placeholder="Nome do produto">
            <a id="addButton">+</a>
        </div>
        </div>
        <ul class="list"></ul>
    </form>

    <ul class="venda-list">

    </ul>

    <section id="finalizar-venda">
        <article id="total">
            <p>Total (R$):</p>
            <p id="totalCompra">R$ 0,00</p>
        </article>
        <a id="btn-adicionar">Adicionar</a>
    </section>

    </article>

    <article id="estatisticas">

        <article id="estatisticas-dia" class="caixa-container-bg-br">
            <h3>Estatisticas do dia</h3>

            <p>Vendas do dia: <span class="dadoDestaque">{{$numVendasNoDia}}</span></p>
            <p>Produtos vendidos: <span class="dadoDestaque">{{$numProdutosVendidosNoDia}}</span></p>
            <p>Ticket médio: <span class="dadoDestaque">R$ {{$ticketMedio}}</span></p>
            <p>Faturamento bruto total: <span class="dadoDestaque">R$ {{$faturamentoBrutoTotal}},00</span></p>

        </article>

        <article id="container-ultima-venda">

            <article id="ultima-venda" class="caixa-container-bg-br">
                
            <h3>Última venda</h3>
            <!--
            <p>Coxinha com catupiry</p>
            <div class="flex-space-between">
                <p>+ 2 itens</p>
                <p>R$21,50</p>
            </div>
            -->
            </article>

            <a id="fechar-caixa" href="/relatorio"> Fechar caixa</a>
            

        </article>

    </article>

</section>



@endsection

@javascript('produtos', $produtos)
@javascript('_token', csrf_token())

@section('body-end-imports')
    <script type="text/javascript" src="/js/caixa.js"></script>
@endsection 