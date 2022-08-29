@extends('layouts.main')

@section('title', 'Produtos')

@section('head-imports')
    <link rel="stylesheet" type="text/css" href="/css/produtos.css">
@endsection


@section('content')

<section class="align-center product-container">
    <h1>Adicionar produto</h1>

    <form id="product-form" method="POST" action="/produtos">
    @csrf
      <div class="">
        <label for="nome">Nome: </label>
        <input type="text" id="nome" name="nome" placeholder="Nome do produto">
      </div>
      <article class="form-line">
        <div class="form-group">
          <label for="precoCusto">Preço de custo: </label>
          <input type="number" id="precoCusto" name="precoCusto" placeholder="Valor de custo">
        </div>
        <div class="form-group">
          <label for="precoVenda">Preço de venda: </label>
          <input type="number" id="precoVenda" name="precoVenda" placeholder="Valor de venda">
        </div>
        <div class="form-group">
          <label for="estoque">Estoque inicial: </label>
          <input type="number" id="estoque" name="estoque" placeholder="Estoque">
        </div>
      </article>
      <input type="submit" value="Adicionar">

    </form>

  </section>


  <section class="align-center product-container ">
    <h1>Produtos</h1>

    <table id="products-table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Valor custo</th>
          <th>Valor venda</th>
          <th>Estoque</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        @foreach($produtos as $produto)
        <tr>
          <td>{{$produto->nome}}</td>
          <td>R${{$produto->precoCusto}},00</td>
          <td>R${{$produto->precoVenda}},00</td>
          <td>{{$produto->estoque}}</td>

          <td>
            <form action="/produto/{{ $produto->id }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit">Deletar</button>
            </form> 
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>

  </section>
<br>
@endsection
 