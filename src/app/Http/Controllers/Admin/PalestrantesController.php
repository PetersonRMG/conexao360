<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PalestrantesController extends Controller
{
    //
    public function index(){
        return view('palestrante.dashPalestrante.dashboard');
    }

    public function palestrante(){

        $palestrante = Usuarios::where('perfil_usuario', 'palestrante')
        ->get();

        return view('admin.cadastro.palestrante', compact('palestrante'));
    }
    public function createPalestrante(Request $request){
        //dd($request->all());

    $request->validate([
        'nome_usuario'         => 'required|string|max:100',
        'foto_usuario'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'email_usuario'        => 'required|email|max:80|unique:tbl_usuarios,email_usuario',
        'area_atuacao_usuario' => 'required|string|max:150',
        'senha_usuario'        => 'required|string|min:8|max:255',
        'termos_usuario'       => 'required|integer',
        'perfil_usuario'       => 'required|string|max:45',
        'estado_usuario'       => 'required|string|size:2',
        'sobre_usuario'        => 'required|string|max:200',
        'status_usuario'       => 'required|string|max:15',
    ]);

    // Lógica de Upload da Foto
    $fotoUsuario = $request->file('foto_usuario');
    $nomeFoto = time() . '.' . $fotoUsuario->getClientOriginalExtension();
    $fotoUsuario->move(public_path('dash/assets/img/usuario'), $nomeFoto);
    $caminhoFoto = 'usuario/' . $nomeFoto;

    // Criação do Registro
    Usuarios::create([
        'nome_usuario'         => $request->nome_usuario,
        'foto_usuario'         => $caminhoFoto,
        'email_usuario'        => $request->email_usuario,
        'area_atuacao_usuario' => $request->area_atuacao_usuario,
        'senha_usuario'        => bcrypt($request->senha_usuario), // Criptografando a senha
        'termos_usuario'       => $request->termos_usuario,
        'perfil_usuario'       => $request->perfil_usuario,
        'estado_usuario'       => strtoupper($request->estado_usuario), // Garante que o estado fique em maiúsculo (ex: SP)
        'sobre_usuario'        => $request->sobre_usuario,
        'status_usuario'       => $request->status_usuario,
    ]);
        return redirect()
        ->route('admin.cadastro.palestrante')
        ->with('success', 'Usuario criado com sucesso!');
    }

    public function updatePalestrante(Request $request , $id){
        //dd($request->all());

    $request->validate([
        'nome_usuario'         => 'required|string|max:100',
       
       'email_usuario' => [
            'required',
            'email',
            'max:80',
            Rule::unique('tbl_usuarios', 'email_usuario')
                ->ignore($id, 'id_usuario'),
        ],

         
    ]);

    $palestrante = Usuarios::findOrFail($id);

            if ($request->hasFile('foto_usuario')) {
            $imagem = $request->file('foto_usuario');
            $nomeImagem = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('dash/assets/img/usuario'), $nomeImagem);
            $caminhoFoto = 'usuario/' . $nomeImagem;
        } 



    // Criação do Registro
    $palestrante->update([
        'nome_usuario'         => $request->nome_usuario,
        
        'email_usuario'        => $request->email_usuario,
        

    ]);
        return redirect()
        ->route('admin.cadastro.palestrante')
        ->with('success', 'Palestrante editado com sucesso!');
    }

    public function desativar($id){
        $palestrante = Usuarios::findOrFail($id);
        //dd($categoria);

        $palestrante->update([
            'status_usuario' => 'INATIVO',

        ]);

        return redirect()
        ->route('admin.cadastro.palestrante')
        ->with('success','Palestrante desativada com sucesso!');
    }

    public function ativar($id){
        $palestrante = Usuarios::findOrFail($id);
        //dd($categoria);

        $palestrante->update([
            'status_usuario' => 'ATIVO',

        ]);

        return redirect()
        ->route('admin.cadastro.palestrante')
        ->with('success','Palestrante ativada com sucesso!');
    }
}
