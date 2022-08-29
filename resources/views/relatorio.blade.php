@extends('layouts.main')

@section('title', 'Dashboard')

@section('head-imports')
    <link rel="stylesheet" type="text/css" href="/css/relatorio.css">
@endsection


@php
    $arrayProdutosMaisVendidosNoPeriodo = json_decode($ProdutosMaisVendidos);
    $arrayProdutosMenosVendidosNoPeriodo = json_decode($ProdutosMenosVendidos);
@endphp

@section('content')

<main>

    <h1 id="relatorioText">Relatório de vendas</h1>

    <select id="intervaloRelatorioSelect" onChange="atualizouSelect()">
      <option value="hoje">Hoje</option>
      <option value="semana">Nessa semana</option>
      <option value="mes">Nesse mês</option>
      <option value="ano">Nesse ano</option>
      <option value="geral">Geral</option>
    </select>

    <section id="relatorioFaturamentoContainer">

      <article id="relatorioFaturamentoTextContainer">
        <div class="relatorioFaturamento">
          <p>Faturamento bruto total: </p>
          <p>R$ {{$faturamentoBrutoTotalDoPeriodo}},00</p>
        </div>
        <div class="relatorioFaturamento">
          <p>Gastos totais:</p>
          <p>R$ {{$gastosTotaisDoPeriodo}},00</p>
        </div>
        <div class="relatorioFaturamento">
          <p>Faturamento líquido:</p>
          <p>R$ {{$faturamentoLiquidoDoPeriodo}},00</p>
        </div>
      </article>

      <article id="graficoContainer">
        <canvas id='faturamentoChart'></canvas>
      </article>

    </section>

    <section id="estatisticasRelatorio">

      <article class="estatisticasCard">
        <p class="estatisticasCardTitle">Produtos mais vendidos</p>
        <div class="estatisticasCardData">
          <div>
            <p><b>Nome</b></p>
            <p><b>Qtd</b></p>
          </div>
          @foreach($arrayProdutosMaisVendidosNoPeriodo as $nomeProduto => $numVenda)
          <div>
            <p>{{$nomeProduto}}</p>
            <p>{{$numVenda}}</p>
          </div>
          @endforeach
        </div>
      </article>



      <article class="estatisticasCard">
        <p class="estatisticasCardTitle">Produtos menos vendidos</p>
        <div class="estatisticasCardData">
          <div>
            <p><b>Nome</b></p>
            <p><b>Qtd</b></p>
          </div>
          @foreach($arrayProdutosMenosVendidosNoPeriodo as $nomeProduto => $numVenda)
          <div>
            <p>{{$nomeProduto}}</p>
            <p>{{$numVenda}}</p>
          </div>
          @endforeach
        </div>
      </article>



      <article class="estatisticasCard">
        <p class="estatisticasCardTitle">Estatísticas Vendas</p>
        <div class="estatisticasCardData">
          <div>
            <p>Total de vendas</p>
            <p>{{$numVendasNoPeriodo}}</p>
          </div>
          <div>
            <p>Produtos vendidos</p>
            <p>{{$numProdutosVendidosNoPeriodo}}</p>
          </div>
          <div>
            <p>Ticket médio</p>
            <p>R$ {{$ticketMedio}}</p>
          </div>
        </div>
      </article>

      <article class="estatisticasCard">
        <p class="estatisticasCardTitle">Estatísticas Produtos</p>
        <div class="estatisticasCardData">
          <div>
            <p><b>Produtos com mais lucro</b></p>
            <p><b>Valor</b></p>
          </div>
          <!--
          <div>
            <p>Café com leite</p>
            <p>R$ 34,00</p>
          </div>
          <div>
            <p>Coxinha de frango</p>
            <p>R$ 28,00</p>
          </div>
          <div>
            <p>Suco de maracuja</p>
            <p>R$ 22,50</p>
          </div>
          <div>
            <p>Suco de uva</p>
            <p>R$ 19,00</p>
          </div>
        -->
        </div>
      </article>

    </section>


    <section id="faturamentoBarChartContainer">
      <h3>Faturamento por período</h3>
      <canvas id="faturamentoBarChart"></canvas>
      <button class="infoBtn" onclick="addData()">Adicionar Período</button>
      <button class="infoBtn" onclick="removeData()">Remover Período</button>
    </section>



  </main>

@endsection

@section('body-end-imports')
<script type="text/javascript" src="/js/chart.js"></script>
<script type="text/javascript" src="/js/relatorio.js"></script>
@endsection

@javascript('selectIndex', $selectIndex)
@javascript('faturamentoBrutoTotalDoPeriodo', $faturamentoBrutoTotalDoPeriodo)
@javascript('gastosTotaisDoPeriodo', $gastosTotaisDoPeriodo)
@javascript('faturamentoLiquidoDoPeriodo', $faturamentoLiquidoDoPeriodo)
@javascript('dataForGraph', json_decode($dataForGraph))
