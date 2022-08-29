<?php

namespace App\Http\Controllers;

use App\Models\ProdutoVenda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function dashboard(){
        $produtos = Produto::All();

        $start = Carbon::today();
        $end = Carbon::tomorrow();
        $vendasDoDia = Venda::whereDate('created_at','<=',$end)->whereDate('created_at','>=',$start)->get();

        $numVendasNoDia = count($vendasDoDia);

        $numProdutosVendidosNoDia = 0;
        $faturamentoBrutoTotal = 0;

        foreach ($vendasDoDia as $i => $venda) {
            $faturamentoBrutoTotal += $venda->faturamentoBrutoDaVenda();
        }

        foreach ($vendasDoDia as $i => $venda) {
            $produtosDaVenda = $venda->produtos()->get();
            $numProdutosVendidosNoDia += count($produtosDaVenda);
        }

        $ticketMedio = 0;
        if($numVendasNoDia != 0){
            $ticketMedio = str_replace('.',',',round($faturamentoBrutoTotal/$numVendasNoDia, 2));
        }

        return view('dashboard',
        [
            'produtos' => $produtos,
            'numVendasNoDia' => $numVendasNoDia,
            'numProdutosVendidosNoDia' => $numProdutosVendidosNoDia,
            'faturamentoBrutoTotal' => $faturamentoBrutoTotal,
            'ticketMedio' => $ticketMedio
        ]);
    }

    public function store(Request $request) {

        $venda = new venda();
        $venda->save();

        $produtosString = $request->produtos;
        $produtos = explode(' ',$produtosString);

        foreach($produtos as $indice => $produto){
            $venda->produtos()->attach($produto);
        }
    }


    public function getRelatorio($selectIndex = 0){

        $now = Carbon::now();
        $start;
        $end;

        switch ($selectIndex) {
            case 0:
                $start = Carbon::today();
                $end = Carbon::tomorrow();
                break;
            case 1:
                $start = $now->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i:s');
                $end = $now->endOfWeek()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d H:i:s');
                break;
            case 2:
                $start = $now->firstOfMonth()->format('Y-m-d H:i:s');
                $end = $now->endOfMonth()->format('Y-m-d H:i:s');
                break;
            case 3:
                $start = $now->startOfYear()->format('Y-m-d H:i:s');
                $end = $now->endOfYear()->format('Y-m-d H:i:s');
                break;
            case 4  :
                $start = Carbon::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00');
                $end = Carbon::createFromFormat('Y-m-d H:i:s', '2999-01-01 00:00:00');
                break;
        }

        $vendasDoPeriodo = Venda::whereDate('created_at','<=',$end)->whereDate('created_at','>=',$start)->get();

        $faturamentoBrutoTotalDoPeriodo = 0;
        $gastosTotaisDoPeriodo = 0;

        foreach ($vendasDoPeriodo as $i => $venda) {
            $faturamentoBrutoTotalDoPeriodo += $venda->faturamentoBrutoDaVenda();
            $gastosTotaisDoPeriodo += $venda->gastoDaVenda();
        }

        $faturamentoLiquidoDoPeriodo = $faturamentoBrutoTotalDoPeriodo - $gastosTotaisDoPeriodo;


        $idsMaisVendidos = ProdutoVenda::select('produto_id', DB::raw('count(*) as total'))
        ->whereDate('created_at','<=',$end)
        ->whereDate('created_at','>=',$start)
        ->groupBy('produto_id')
        ->orderByRaw('count(*) DESC')
        ->limit(4)
        ->pluck('produto_id');

        $ProdutosMaisVendidos = [];
        foreach ($idsMaisVendidos as $i => $idMaisVendido) {
            $nomeProduto = Produto::findOrFail($idMaisVendido)->nome;
            $numVendas = count(ProdutoVenda::select('*')->where('produto_id', $idMaisVendido)->whereDate('created_at','<=',$end)
            ->whereDate('created_at','>=',$start)->get());
            $ProdutosMaisVendidos[$nomeProduto] = $numVendas;
        }


        $RelacoesVendaProdutoDoPeriodo = ProdutoVenda::whereDate('created_at','<=',$end)->whereDate('created_at','>=',$start)->get();
        $idsVendidosNoPeriodo = [];
        foreach($RelacoesVendaProdutoDoPeriodo as $i => $relacao){
            if(!in_array($relacao['produto_id'], $idsVendidosNoPeriodo)){
                $idsVendidosNoPeriodo[] = $relacao['produto_id'];                
            }
        }

        $produtosSemVenda = Produto::select('*')
        ->whereNotIn('id', $idsVendidosNoPeriodo)
        ->limit(4)
        ->get();


        $numResultadosDesejados = 4;
        $ProdutosMenosVendidos = [];
        
        foreach ($produtosSemVenda as $i => $produtoSemVenda) {
            $ProdutosMenosVendidos[$produtoSemVenda->nome] = 0;
        }

        if(count($produtosSemVenda) < 4){
            $numResultadosDesejados = 4 - count($produtosSemVenda);
        
            $idsMenosVendidos = ProdutoVenda::select('produto_id', DB::raw('count(*) as total'))
            ->whereDate('created_at','<=',$end)
            ->whereDate('created_at','>=',$start)
            ->groupBy('produto_id')
            ->orderByRaw('count(*) ASC')
            ->limit($numResultadosDesejados)
            ->pluck('produto_id');

            
            foreach ($idsMenosVendidos as $i => $idMenosVendidos) {
                $nomeProduto = Produto::findOrFail($idMenosVendidos)->nome;
                $numVendas = count(ProdutoVenda::where('produto_id', $idMenosVendidos)->get());
                $ProdutosMenosVendidos[$nomeProduto] = $numVendas;
            }
        }


        $numProdutosVendidosNoPeriodo = count($RelacoesVendaProdutoDoPeriodo);

        $numVendasNoPeriodo = count($vendasDoPeriodo);

        $ticketMedio = 0;
        if($numVendasNoPeriodo != 0){
            $ticketMedio = str_replace('.',',',round($faturamentoBrutoTotalDoPeriodo/$numVendasNoPeriodo, 2));
        }

        
        switch ($selectIndex) {
            case 0:
                $dataForGraph = [];
                break;
            case 1:
                $startDayWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);

                $totalFaturamentoVendasTerca = 0;

                $inicioDoDomingo = $startDayWeek->format('Y-m-d H:i:s'); 
                $fimDoDomingo = $startDayWeek->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasDomingo = Venda::faturamentoBrutoDoDia($inicioDoDomingo, $fimDoDomingo);

                $inicioDaSegunda = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDaSegunda = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasSegunda = Venda::faturamentoBrutoDoDia($inicioDaSegunda, $fimDaSegunda);

                $inicioDaTerca = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDaTerca = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasTerca = Venda::faturamentoBrutoDoDia($inicioDaTerca, $fimDaTerca);

                $inicioDaQuarta = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDaQuarta = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasQuarta = Venda::faturamentoBrutoDoDia($inicioDaQuarta, $fimDaQuarta);

                $inicioDaQuinta = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDaQuinta = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasQuinta = Venda::faturamentoBrutoDoDia($inicioDaQuinta, $fimDaQuinta);

                $inicioDaSexta = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDaSexta = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasSexta = Venda::faturamentoBrutoDoDia($inicioDaSexta, $fimDaSexta);

                $inicioDoSabado = $startDayWeek->addDays(0)->format('Y-m-d H:i:s'); 
                $fimDoSabado = $startDayWeek->addDays(0)->addHours(23)->addMinutes(59)->addSeconds(59)->format('Y-m-d H:i:s');
                $totalFaturamentoVendasSabado = Venda::faturamentoBrutoDoDia($inicioDoSabado, $fimDoSabado);

                $dataForGraph = [
                    'Domingo' => $totalFaturamentoVendasDomingo,
                    'Segunda' => $totalFaturamentoVendasSegunda,
                    'Terca' => $totalFaturamentoVendasTerca,
                    'Quarta' => $totalFaturamentoVendasQuarta,
                    'Quinta' => $totalFaturamentoVendasQuinta,
                    'Sexta' => $totalFaturamentoVendasSexta,
                    'Sabado' => $totalFaturamentoVendasSabado
                ];
                break;
            case 2:
                $dataForGraph = [];
                break;
            case 3:
                $dataForGraph = [];
                break;
            case 4  :
                $dataForGraph = [];
                break;
        }

        

        return view('relatorio',
        [
            'selectIndex' => $selectIndex,
            'dataForGraph' => json_encode($dataForGraph),
            'ProdutosMaisVendidos' => json_encode($ProdutosMaisVendidos),
            'ProdutosMenosVendidos' => json_encode($ProdutosMenosVendidos),
            'faturamentoBrutoTotalDoPeriodo' => $faturamentoBrutoTotalDoPeriodo,
            'gastosTotaisDoPeriodo' => $gastosTotaisDoPeriodo,
            'faturamentoLiquidoDoPeriodo' => $faturamentoLiquidoDoPeriodo,
            'numProdutosVendidosNoPeriodo' => $numProdutosVendidosNoPeriodo,
            'numVendasNoPeriodo' => $numVendasNoPeriodo,
            'ticketMedio' => $ticketMedio
        ]);
    }
}
