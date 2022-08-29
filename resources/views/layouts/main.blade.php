<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" sizes="512x512" href="/images/logo.png">

  <title>@yield('title')</title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  
  @yield('head-imports')
</head>

<body>

  <header id="header">
    <a id="logo" href="/relatorio">Relatório</a>
    <nav id="nav">
      <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu" aria-expanded="false">Menu
        <span id="hamburger"></span>
      </button>
      <ul id="menu" role="menu">
        <li><a href="/dashboard">Caixa</a></li>
        <li><a href="#">Estoque</a></li>
        <li><a href="/produtos">Produtos</a></li>
      </ul>
    </nav>
  </header>
  @if(session('msg'))
    <p class="msg">{{ session('msg') }}</p>
  @endif



  @yield('content')




  <footer>

    <form action="/logout" method="POST">
      @csrf
      <a href="/logout" 
        class="nav-link" 
        onclick="event.preventDefault();
        this.closest('form').submit();">
        Sair
      </a>
    </form>
    <div>
      <a id="dataHoje"> XX/08/2022 </a>
      <a id="horarioAgora"> XX:XX </a>
    </div>
    <a> {{Auth::user()->name}} </a>

  </footer>

  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  
  <script type="text/javascript" src="/js/script.js"></script>
  
  @yield('body-end-imports')
</body>

</html>