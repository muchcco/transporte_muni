<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuarios.index');
    }

    public function tb_index(Request $request)
    {
        $usuarios = User::get();

        return view('usuarios.tablas.tb_index', compact('usuarios'));
    }

    public function md_add_usuario(Request $request)
    {
        $view = view('usuarios.modals.md_add_usuario')->render();

        return response()->json(['html' => $view]);
    }

    public function store_usuario(Request $request)
    {
        
        $user = new User;
        $user->email = $request['email'];
        $user->name = $request['name'];
        $user->password = bcrypt($request['password']);
        $user->save();

        return $user;

    }

    public function md_edit_usuario(Request $request)
    {
        $edit = User::where('id', $request->id)->first();
        // dd($edit);

        $view = view('usuarios.modals.md_edit_usuario', compact('edit'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_usuario(Request $request)
    {
        
        $save = User::findOrFail($request->id);
        $save->email = $request['email'];
        $save->name = $request['name'];
        $save->save();

        return $save;

    }

    public function md_editpass_usuario(Request $request)
    {
        $edit = User::where('id', $request->id)->first();
        // dd($edit);

        $view = view('usuarios.modals.md_editpass_usuario', compact('edit'))->render();

        return response()->json(['html' => $view]);
    }

    public function update_password_usuario(Request $request)
    {        
        $save = User::findOrFail($request->id);
        $save->password = bcrypt($request->password);
        $save->save();

        return $save;

    }

    public function delete_usuario(Request $request)
    {
        $delete = DB::table('users')->where('id', $request->id)->delete();

        return $delete;
    }

}
