<?php

namespace App\Http\Controllers;

use App\Models\Tasas;
use Illuminate\Http\Request;
use Alert;
use Datatables;

class TasasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $tasas=Tasas::all();
            return datatables()->of($tasas)
                ->addColumn('action', function ($row) {
                    /*$edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCategoria"><i class="fa fa-pencil-alt"></i></a>';*/
                    $delete = ' <a href="javascript:void(0);" id="delete-tasas" onClick="deleteTasas('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('tasas.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message =[
            'tasa.required' => 'El campo Tasa es obligatorio',
            'fecha.required' => 'El campo Fecha es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'tasa' => 'required',
            'fecha' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Tasas::where('status','Activa')->where('moneda',$request->moneda)->first();
        if (!is_null($buscar)) {
            $buscar->status="Inactiva";
            $buscar->save();
        }
        
            
        $tasa= new Tasas();
        $tasa->tasa=$request->tasa;
        $tasa->moneda=$request->moneda;
        $tasa->fecha=$request->fecha;
        $tasa->save();
        $tasas=Tasas::all();
       return response()->json(['message' => "Tasa registrada con éxito",'icono' => 'success', 'titulo' => 'Éxito','tasas' => $tasas]);
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasas  $tasas
     * @return \Illuminate\Http\Response
     */
    public function show(Tasas $tasas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasas  $tasas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasas $tasas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasas  $tasas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasas $tasas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasas  $tasas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar1=Tasas::find($request->id);
        if ($buscar1->status=="Activa") {
            $buscar=Tasas::where('id','<>',$request->id)->where('moneda',$buscar1->moneda)->orderBy('id','DESC')->first();
            if(!is_null($buscar)){
                $buscar->status="Activa";
                $buscar->save();
            }
            
        }

        if ($buscar1->delete()) {
             return response()->json(['message' => "Tasa eliminada con éxito",'icono' => 'success', 'titulo' => 'Éxito']);
        } else {
             return response()->json(['message' => "Tasa no eliminada",'icono' => 'danger', 'titulo' => 'Éxito']);
        }
        
        
        

    }
}
