<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    } 
    
    public function index()
    {
        if (\Gate::allows('isAdmin')) {
            return User::all();
        }      

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $date = Carbon::now()->format('Y-m-d'); 

        $this->validate($request,[
            'name' => 'required|string|max:20',
            'apellido' => 'required|string|max:20',
            'telefono' => 'required|string|max:11',
            'direccion' => 'required|string|max:30',
            'ci' => 'required|string|max:8',
            'tipo' => 'required|string|',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',        
            'foto' => 'required'            
        ]);

       
        
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/profile/').$name);
            $request->merge(['foto' => $name]);
            
        
        return User::create([
            "name" => $request["name"],
            "apellido" => $request["apellido"],
            "telefono" => $request["telefono"],            
            "direccion" => $request["direccion"],
            "ci" => $request["ci"],            
            "tipo" => $request["tipo"],
            "foto" => $request["foto"],
            "email" => $request["email"],
            'password' => Hash::make($request['password']),    
            "fecha" => $date,        
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();


        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);


        $currentPhoto = $user->foto;


        if($request->foto != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/profile/').$name);
            $request->merge(['foto' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        }


        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        $user->update($request->all());
        return ['message' => "Success"];
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($data)
    {           
        $date = Carbon::now()->format('Y-m-d');        
        //dd($data);
        if($data == "hoy"){
            $user = DB::table('users')
            ->where('fecha','=',$date)
            ->get();
        }
        else{
            $user = DB::table('users')
            ->where('fecha','=',$date)
            ->count();
        }        
        
        return response()->json($user);
    }

    public function profile()
    {
        return auth('api')->user();

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */    

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:20',
            'apellido' => 'required|string|max:20',
            'telefono' => 'required|string|max:11',
            'direccion' => 'required|string|max:30',
            'ci' => 'required|string|max:8',
            'tipo' => 'required|string|',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'            
        ]);

        $currentPhoto = $user->foto;


        if($request->foto != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/profile/').$name);
            $request->merge(['foto' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        }


        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        $user->update($request->all());
        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
