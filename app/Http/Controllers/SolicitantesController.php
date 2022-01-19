<?php

namespace App\Http\Controllers;

use App\Models\Solicitantes;
use Illuminate\Http\Request;
use App\Models\Empresas;
use Alert;
use Datatables;

class SolicitantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $solicitantes=\DB::table('solicitantes')
            ->join('empresas','empresas.id','=','solicitantes.id_empresa')
            ->select('solicitantes.*','empresas.nombre')
            ->get();
            return datatables()->of($solicitantes)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editSolicitante"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteSolicitante('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('solicitantes.index');
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
            'nombres.required' => 'El campo nombres es obligatorio',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'celular.required' => 'El campo celular es obligatorio',
            'direccion.required' => 'El campo dirección es obligatorio',
            'localidad.required' => 'El campo localidad es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Solicitantes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->count();

        if($buscar > 0){
            return response()->json(['message'=>"Los Nombres, Apellidos y Celular del solicitante ya han sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $solicitante= new Solicitantes();
                $solicitante->nombres=$request->nombres;
                $solicitante->apellidos=$request->apellidos;
                $solicitante->celular=$request->celular;
                $solicitante->direccion=$request->direccion;
                $solicitante->localidad=$request->localidad;

                $solicitante->save();

                 return response()->json(['message'=>"Solicitante ".$request->nombres." ".$request->nombres." con celular: ".$request->celular." registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitantes  $solicitantes
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitantes $solicitantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Solicitantes  $solicitantes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitantes=Solicitantes::where('id',$id)->first();
        return Response()->json($solicitantes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Solicitantes  $solicitantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_solicitante)
    {
        $message =[
            'nombres.required' => 'El campo nombres es obligatorio',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'celular.required' => 'El campo celular es obligatorio',
            'direccion.required' => 'El campo dirección es obligatorio',
            'localidad.required' => 'El campo localidad es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Solicitantes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->where('id','<>',$request->id_solicitante)->count();

        if($buscar > 0){
            return response()->json(['message'=>"Los Nombres, Apellidos y Celular del solicitante ya han sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $solicitante= Solicitantes::find($request->id_solicitante);
                $solicitante->nombres=$request->nombres;
                $solicitante->apellidos=$request->apellidos;
                $solicitante->celular=$request->celular;
                $solicitante->direccion=$request->direccion;
                $solicitante->localidad=$request->localidad;
                $solicitante->save();

                return response()->json(['message'=>"Solicitante ".$request->nombres." ".$request->nombres." con celular: ".$request->celular." actualizado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solicitantes  $solicitantes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Pedidos::where('id_solicitante',$id)->count();
        if($buscar > 0){
            
            return response()->json(['message'=>"El Solicitante que intenta eliminar se encuentra relacionado con algún pedido",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $solicitante=Solicitantes::find($id);
            if($solicitante->delete()){
              return response()->json(['message'=>"El solicitante fue eliminado con éxito",'icono'=>'success','titulo'=>'Éxito']); 
            }else{
                return response()->json(['message'=>"El solicitante no pudo ser eliminado",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        return redirect()->back();
    }

    public function buscar_solicitantes()
    {
        $solicitantes=Solicitantes::orderby('id','DESC')->get();

        return response()->json($solicitantes);
    }

    public function buscar_por_empresa(Request $request)
    {
        $buscar=Empresas::where('nombre',$request->nombre)->first();
        $buscar2=Solicitantes::where('id_empresa',$buscar->id)->get();

        return response()->json($buscar2);

    }

    public function buscar_solicitante($id_solicitante)
    {
        return $buscar=Solicitantes::where('id',$id_solicitante)->get();
    }
}
