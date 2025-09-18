<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class Usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->privilege == 'admin') {
            # code...
        $users = User::all();

        return view('users.index')->with(compact(['users']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->privilege == 'admin') {
       
        return view('users.create');
        }else{
            "404 error";
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
         $request->validate([
        'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
       ]);



        $usrs = new User();
        $usrs->name = $request ->name;
        $usrs->email = $request ->email;
        $usrs->password = Hash::make($request ->password);
        $usrs->privilege = $request ->privilege;
        $usrs->status = $request ->status;
        $usrs->save();
        
        $users = User::paginate(10);
        return view('users.index')->with(compact(['users']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if((auth()->user()->privilege == "Admin") && (auth()->user()->status == "Active"))
        // {
        //     return view('home');
        // }elseif ((auth()->user()->privilege == "User") && (auth()->user()->status == "Active")) {
        //     return view('welcome');
        // }
        $user = User::find($id);
        return view('users.show')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $usrs = User::find($id);
       
        return view('users.edit')->with(
        compact(['usrs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
        
        'password' => ['required', 'string', 'min:8','max:12', 'confirmed'],
       ]);

         

        $usrs = User::find($request->id);
        $usrs->name = $request ->name;
        $usrs->email = $request ->email;
        $usrs->privilege = $request ->privilege;
        $usrs->password = Hash::make($request->password);
        $usrs->status = $request ->status;
       

        $usrs->save();

       

        return redirect('/users');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        User::find($id)->delete();
        
       return redirect('/users');
    }
    public function branch()
    {
        $branches = Branch::all();
        return view('users.create')->with(compact(['branches']));
    }
}
