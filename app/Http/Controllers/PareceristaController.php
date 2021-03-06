<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PareceristaRequest;
use App\Parecerista;

class PareceristaController extends Controller
{
    public function index(Request $request){
        $this->authorize('admin');

        if(isset($request->busca)){
            $pareceristas = Parecerista::where('numero_usp','LIKE',"%{$request->busca}%")->paginate(5);
        } else {
            $pareceristas = Parecerista::paginate(5);
        }

        return view('pareceristas.index')->with('pareceristas',$pareceristas);
    }

    public function show(Parecerista $parecerista){
        $this->authorize('admin');
        return view('pareceristas.show')->with('parecerista',$parecerista);
    }

    public function create(){
        $this->authorize('admin');
        return view('pareceristas.create')->with('parecerista',new Parecerista);
    }

    public function store(PareceristaRequest $request){
        $this->authorize('admin');
        $validated = $request->validated();
        Parecerista::create($validated);
        return redirect('/pareceristas/');
    }

    public function edit(Parecerista $parecerista) {
        $this->authorize('admin');
        return view('pareceristas.edit')->with('parecerista',$parecerista);
    }

    public function update(PareceristaRequest $request, Parecerista $parecerista){
        $this->authorize('admin');
        $validated = $request->validated();
        $parecerista->update($validated);
        return redirect("pareceristas/$parecerista->id");
    }

    public function destroy( Parecerista $parecerista){
        $this->authorize('admin');
        $parecerista->delete();
        return redirect('/pareceristas');
    }
}
