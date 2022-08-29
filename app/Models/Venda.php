<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Venda extends Model
{
    use HasFactory;

    public function produtos(){
        return $this->belongsToMany('App\Models\Produto')->withTimestamps();
    }

    public function faturamentoBrutoDaVenda(){

        $produtos = $this->produtos()->get();
        $faturamentoBruto = 0;
        foreach ($produtos as $i => $produto) {
            $faturamentoBruto += $produto->precoVenda;
        }
        return $faturamentoBruto;
    }

    public function gastoDaVenda(){
        $produtos = $this->produtos()->get();
        $gastoTotal = 0;
        foreach ($produtos as $i => $produto) {
            $gastoTotal += $produto->precoCusto;
        }
        return $gastoTotal;
    }

    public static function faturamentoBrutoDoDia($start, $end){

        $vendasNoPeriodo = Venda::whereDate('created_at','<=', $end)->whereDate('created_at','>=',$start)->get();
        $faturamentoTotal = 0;

        foreach ($vendasNoPeriodo as $i => $venda) {
            $faturamentoTotal += $venda->faturamentoBrutoDaVenda();
        }

        return $faturamentoTotal;

    }







}
