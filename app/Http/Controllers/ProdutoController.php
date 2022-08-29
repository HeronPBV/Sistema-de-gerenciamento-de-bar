<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{

    public function create(){
        $produtos = Produto::All();
        return view('produtos', ['produtos' => $produtos]);
    }

    public function store(Request $request) {
        $produto = new Produto();

        $produto->nome = $request->nome;
        $produto->precoCusto = $request->precoCusto;
        $produto->precoVenda = $request->precoVenda;
        $produto->estoque = $request->estoque;

        $produto->save();

        return redirect('/produtos')->with('msg', 'Produto adicionado com sucesso!');
    }
    
    public function destroy($id) {

        Produto::findOrFail($id)->delete();
        return redirect('/produtos')->with('msg', 'Produto excluído com sucesso!');

        
    }

}
