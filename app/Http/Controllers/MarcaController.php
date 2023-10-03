<?php

namespace App\Http\Controllers;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marca = $this->marca->all();
        return response()->json($marca,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $request->validate($this->marca->rules(), $this->marca->feedback());
        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $marca = $this->marca->find($id);
        if($marca){
            return response()->json($marca,200);
        } else {
            return response()->json(['erro'=> "O recurso solicitado para visualização não existe."], 404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if($marca){

            if($request->method() === 'PATCH'){
                $regrasDinamicas = array();
                foreach($marca->rules() as $key => $regra){
                    if(array_key_exists($key,$request->all())){
                        $regrasDinamicas[$key] = $regra;
                    }
                }
                //dd($regrasDinamicas);
                $request->validate($regrasDinamicas, $marca->feedback());
            } else{
                $request->validate($marca->rules(),$marca->feedback());
                
            }
            $marca->update($request->all());
            return response()->json($marca,200);
       
        } else {
            return response()->json(['erro'=> "O recurso solicitado para auteração não existe."], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca){
            $marca->delete();
            return ["msg" => "O registro foi removido com sucesso!"];
        } else {
            return response()->json(['erro'=> "O recurso solicitado para exclusão não existe."], 404);
        }
    }
    
}
