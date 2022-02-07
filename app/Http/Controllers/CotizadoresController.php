<?php

namespace App\Http\Controllers;

use App\Models\Cotizadores;
use App\Models\User;
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
            $cotizadores=\DB::table('cotizadores')
            ->join('users','users.id','=','cotizadores.id_usuario')
            ->select('cotizadores.*','users.name AS username')->get();
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

        /*$message =[
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
        }*/
        //echo $request->cotizador."-".$request->rut."---".$request->correo."--".$request->telefono."--".$request->username;
        $buscar=Cotizadores::where('cotizador',$request->cotizador)->where('correo',$request->correo)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El cotizador ya ha sido registrado con ese correo",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $buscar2=User::where('name',$request->username)->count();
            if ($buscar2 > 0) {
              return response()->json(['message'=>"El Nombre de Usuario ya ha sido registrado",'icono'=>'warning','titulo'=>'Alerta']);  
            } else {
                
                $user = new User();
                $user->name=$request->username;
                $user->email=$request->correo;
                
                $a=date('Y');
                $n=ucfirst(trim($request->username));
                $clave=$n.''.$a.'.';
                $user->password=bcrypt($clave);
                $user->user_type='Cotizador';
                $user->save();

                $cotizador= new Cotizadores();
                $cotizador->cotizador=$request->cotizador;
                $cotizador->rut=$request->rut;
                $cotizador->telefono=$request->telefono;
                $cotizador->correo=$request->correo;
                $cotizador->id_usuario=$user->id;
                $cotizador->save();


               return response()->json(['message' => "Cotizador ".$request->cotizador." registrado con éxito: Nombre de Usuario:".$request->username.' y CLAVE: '.$clave."",'icono' => 'success', 'titulo' => 'Éxito']);
            }
            
            
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
        //$cotizador=Cotizadores::where('id',$id)->first();
         $cotizador=\DB::table('cotizadores')
            ->join('users','users.id','=','cotizadores.id_usuario')
            ->where('cotizadores.id',$id)
            ->select('cotizadores.*','users.name')->first();

        /*$cotizador=\DB::table('cotizadores')
        ->join('users','users.id','=','cotizadores.id_usuario')
        ->where('cotizadores.id',$id)
        ->select('cotizadores.*','user.name')->first();*/

        return Response()->json($cotizador);
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
        /*$message =[
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
        }*/

        $buscar=Cotizadores::where('cotizador',$request->cotizador)->where('correo',$request->correo_edit)->where('id','<>',$request->id_cotizador)->count();
        if($buscar > 0){
            return response()->json(['message' => 'El cotizador ya ha sido registrado con el correo ingresado','icono' => 'warning','titulo' => 'Alerta']);
        }else{
            $cot= Cotizadores::find($request->id_cotizador);
            $buscar=User::where('name',$request->username)->where('id','<>',$cot->id_usuario)->count();
            if ($buscar > 0) {
              return response()->json(['message'=>"El Nombre de Usuario ya ha sido registrado",'icono'=>'warning','titulo'=>'Alerta']);  
            } else {
                
                $cotizador= Cotizadores::find($request->id_cotizador);
                $cotizador->cotizador=$request->cotizador;
                $cotizador->rut=$request->rut;
                $cotizador->telefono=$request->telefono;
                $cotizador->correo=$request->correo;
                $cotizador->save();

                $user = User::where('id',$cotizador->id_usuario)->first();
                $user->name=$request->username;
                $user->email=$request->correo;
                $mensaje="";
                if(!is_null($request->reset_clave)){
                    $a=date('Y');
                    $n=ucfirst(trim($request->username));
                    $clave=$n.''.$a.'.';
                    $user->password=bcrypt($clave);
                    $mensaje=" CLAVE MODIFICADA: ".$clave;
                }
                $user->save();
                
                return response()->json(['message' => 'El cotizador actualizado con éxito.'.$mensaje."(".$request->reset_clave.")", 'icono' => 'success', 'titulo' => 'Éxito']);
            }
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
            $user=User::where('id',$cotizador->id_usuario)->first();
            if($cotizador->delete()){
                $user->delete();
              return response()->json(['message' => 'El cotizador fue eliminado con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'El cotizador no pudo ser eliminado','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        
    }
}
