<?php

namespace App\Http\Controllers;

use App\Models\Cotizadores;
use Illuminate\Http\Request;
use Alert;
use Datatables;

class CotizadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(request()->ajax()) {
            $cotizadores=\DB::table('cotizadores')->get();
            return datatables()->of($cotizadores)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCotizador"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-cotizador" onClick="deleteCotizador('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('cotizadores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('cotizadores.create');
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
            'cotizador.required' => 'El campo cotizador es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'correo.required' => 'El campo correo es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'cotizador' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email|unique:cotizadores',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Cotizadores::where('cotizador',$request->cotizador)->where('correo',$request->correo)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El cotizador ya ha sido registrado con ese correo",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $cotizador= new Cotizadores();
                $cotizador->cotizador=$request->cotizador;
                $cotizador->telefono=$request->telefono;
                $cotizador->correo=$request->correo;
                $cotizador->save();

               return response()->json(['message' => "Cotizador ".$request->cotizador." registrado con éxito",'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cotizadores  $cotizadores
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizadores $cotizadores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cotizadores  $cotizadores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$cotizadores=Cotizadores::where('id',$id)->first();
        $cotizadores=\DB::table('cotizadores')
        ->where('cotizadores.id',$id)->first();

        return Response()->json($cotizadores);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cotizadores  $cotizadores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_cotizador)
    {
        $message =[
            'cotizador.required' => 'El campo cotizador es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'correo.required' => 'El campo correo es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'cotizador' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Cotizadores::where('cotizador',$request->cotizador)->where('correo',$request->correo_edit)->where('id','<>',$request->id_cotizador)->count();
        if($buscar > 0){
            return response()->json(['message' => 'El cotizador ya ha sido registrado con el correo ingresado','icono' => 'warning','titulo' => 'Alerta']);
        }else{
            
                $cotizador= Cotizadores::find($request->id_cotizador);
                $cotizador->cotizador=$request->cotizador;
                $cotizador->telefono=$request->telefono;
                $cotizador->correo=$request->correo;
                $cotizador->save();

                return response()->json(['message' => 'El cotizador actualizado con éxito', 'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cotizadores  $cotizadores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $cotizador=Cotizadores::find($id);
            if($cotizador->delete()){
              return response()->json(['message' => 'El cotizador fue eliminado con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'El cotizador no pudo ser eliminado','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        
    }
}
