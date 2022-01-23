<?php

namespace App\Http\Controllers;

use App\Models\TasaIva;
use Illuminate\Http\Request;
use Alert;
use Datatables;
class TasaIvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(request()->ajax()) {
            $tasaiva=TasaIva::all();
            return datatables()->of($tasaiva)
                ->addColumn('action', function ($row) {
                    /*$edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCategoria"><i class="fa fa-pencil-alt"></i></a>';*/
                    $delete = ' <a href="javascript:void(0);" id="delete-tasaiva" onClick="deleteTasaIVA('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('tasaiva.index');
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
            'tasa_i.required' => 'El campo Tasa es obligatorio',
            'fecha_i.required' => 'El campo Fecha es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'tasa_i' => 'required',
            'fecha_i' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=TasaIva::where('status_i','Activa')->first();
        if (!is_null($buscar)) {
            $buscar->status_i="Inactiva";
            $buscar->save();
        }
        
            
        $tasaiva= new TasaIva();
        $tasaiva->tasa_i=$request->tasa_i;
        $tasaiva->fecha_i=$request->fecha_i;
        $tasaiva->save();
        $tasasiva=TasaIva::all();
       return response()->json(['message' => "Tasa del IVA registrada con éxito",'icono' => 'success', 'titulo' => 'Éxito','tasasiva' => $tasasiva]);
            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TasaIva  $tasaIva
     * @return \Illuminate\Http\Response
     */
    public function show(TasaIva $tasaIva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TasaIva  $tasaIva
     * @return \Illuminate\Http\Response
     */
    public function edit(TasaIva $tasaIva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TasaIva  $tasaIva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TasaIva $tasaIva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TasaIva  $tasaIva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar1=TasaIva::find($request->id);
        if ($buscar1->status_i=="Activa") {
            $buscar=TasaIva::where('id','<>',$request->id)->orderBy('id','DESC')->first();
            
            if(!is_null($buscar)){
                $buscar->status_i="Inactiva";
                $buscar->save();
            }
        }
        $buscar1=TasaIva::find($request->id);
        if ($buscar1->delete()) {
             return response()->json(['message' => "Tasa del IVA eliminada con éxito",'icono' => 'success', 'titulo' => 'Éxito']);
        } else {
             return response()->json(['message' => "Tasa del IVA no eli",'icono' => 'danger', 'titulo' => 'Éxito']);
        }

    }
}
