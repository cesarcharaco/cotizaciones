<?php

namespace App\Http\Controllers;

use App\Models\Vendedores;
use Illuminate\Http\Request;
use Alert;
use Datatables;

class VendedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(request()->ajax()) {
            $vendedores=\DB::table('vendedores')->get();
            return datatables()->of($vendedores)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editVendedor"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-vendedor" onClick="deleteVendedor('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('vendedores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('vendedores.create');
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
            'vendedor.required' => 'El campo vendedor es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'correo.required' => 'El campo correo es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'vendedor' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email|unique:vendedores',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Vendedores::where('vendedor',$request->vendedor)->where('correo',$request->correo)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El vendedor ya ha sido registrado con ese correo",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $vendedor= new Vendedores();
                $vendedor->vendedor=$request->vendedor;
                $vendedor->telefono=$request->telefono;
                $vendedor->correo=$request->correo;
                $vendedor->save();

               return response()->json(['message' => "Vendedor ".$request->vendedor." registrado con éxito",'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function show(Vendedores $vendedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$vendedores=Vendedores::where('id',$id)->first();
        $vendedores=\DB::table('vendedores')
        ->where('vendedores.id',$id)->first();

        return Response()->json($vendedores);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_vendedor)
    {
        $message =[
            'vendedor.required' => 'El campo vendedor es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'correo.required' => 'El campo correo es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'vendedor' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Vendedores::where('vendedor',$request->vendedor)->where('correo',$request->correo_edit)->where('id','<>',$request->id_vendedor)->count();
        if($buscar > 0){
            return response()->json(['message' => 'El vendedor ya ha sido registrado con el correo ingresado','icono' => 'warning','titulo' => 'Alerta']);
        }else{
            
                $vendedor= Vendedores::find($request->id_vendedor);
                $vendedor->vendedor=$request->vendedor;
                $vendedor->telefono=$request->telefono;
                $vendedor->correo=$request->correo;
                $vendedor->save();

                return response()->json(['message' => 'El vendedor actualizado con éxito', 'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $vendedor=Vendedores::find($id);
            if($vendedor->delete()){
              return response()->json(['message' => 'El vendedor fue eliminado con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'El vendedor no pudo ser eliminado','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        
    }
}
