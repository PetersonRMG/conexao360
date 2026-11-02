<?php



namespace App\Http\Controllers\Api\V1;



use App\Http\Controllers\Controller;

use App\Models\Usuarios;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Services\CodigoEmailService;



class AuthController extends Controller

{

    // =============================================================

    // LOGIN

    // =============================================================



    public function login(

        Request $request

    ): JsonResponse {



        $request->validate([

            'email' => [

                'required',

                'email',

            ],



            'senha' => [

                'required',

                'string',

            ],



            'device_name' => [

                'required',

                'string',

            ],

        ]);





        // =====================================

        // BUSCAR USUÁRIO

        // =====================================



        $usuario =

            Usuarios::where(

                'email_usuario',

                $request->email

            )

                ->first();





        // =====================================

        // VALIDAR USUÁRIO

        // =====================================



        if (!$usuario) {



            return response()->json([

                'success' => false,



                'message' =>

                    'E-mail ou senha inválidos.',

            ], 401);

        }





        // =====================================

        // VALIDAR SENHA

        // =====================================



        if (

            !Hash::check(

                $request->senha,

                $usuario->senha_usuario

            )

        ) {



            return response()->json([

                'success' => false,



                'message' =>

                    'E-mail ou senha inválidos.',

            ], 401);

        }





        // =====================================

        // VALIDAR STATUS

        // =====================================



        if (

            $usuario->status_usuario !==

            'ATIVO'

        ) {



            return response()->json([

                'success' => false,



                'message' =>

                    'Usuário inativo.',

            ], 403);

        }





        // =====================================

        // GERAR TOKEN

        // =====================================



        $token =

            $usuario

                ->createToken(

                    $request->device_name

                )

                ->plainTextToken;





        // =====================================

        // RESPOSTA

        // =====================================



        return response()->json([

            'success' => true,



            'message' =>

                'Login realizado com sucesso.',



            'data' => [

                'token' =>

                    $token,



                'usuario' => [

                    'id_usuario' =>

                        $usuario->id_usuario,



                    'nome_usuario' =>

                        $usuario->nome_usuario,



                    'foto_usuario' =>

                        $usuario->foto_usuario,



                    'email_usuario' =>

                        $usuario->email_usuario,



                    'area_atuacao_usuario' =>

                        $usuario

                            ->area_atuacao_usuario,



                    'estado_usuario' =>

                        $usuario->estado_usuario,



                    'sobre_usuario' =>

                        $usuario->sobre_usuario,



                    'perfil_usuario' =>

                        $usuario->perfil_usuario,

                ],

            ],

        ]);

    }





    // =============================================================

    // CADASTRO

    // =============================================================



    public function register(

        Request $request

    ): JsonResponse {



        // =====================================

        // VALIDAÇÃO

        // =====================================



        $request->validate(

            [

                'nome' => [

                    'required',

                    'string',

                    'max:100',

                ],



                'email' => [

                    'required',

                    'email:rfc,dns',

                    'max:80',

                    'unique:tbl_usuarios,email_usuario',

                ],



                'area_atuacao' => [

                    'required',

                    'string',

                    'max:150',

                ],



                'estado' => [

                    'required',

                    'string',

                    'size:2',

                ],



                'sobre' => [

                    'nullable',

                    'string',

                    'max:200',

                ],



                'senha' => [

                    'required',

                    'string',

                    'min:8',

                    'max:255',

                    'confirmed',

                ],



                'codigo' => [
                    'required',
                    'digits:6',
                ],

                'termos' => [

                    'required',

                    'accepted',

                ],



                'device_name' => [

                    'nullable',

                    'string',

                    'max:100',

                ],

            ],

            [

                'nome.required' =>

                    'Informe seu nome.',



                'nome.max' =>

                    'O nome não pode ultrapassar 100 caracteres.',



                'email.required' =>

                    'Informe seu e-mail.',



                'email.email' =>

                    'Informe um e-mail válido.',



                'email.max' =>

                    'O e-mail não pode ultrapassar 80 caracteres.',



                'email.unique' =>

                    'Já existe uma conta cadastrada com este e-mail.',



                'area_atuacao.required' =>

                    'Informe sua área de atuação.',



                'area_atuacao.max' =>

                    'A área de atuação não pode ultrapassar 150 caracteres.',



                'estado.required' =>

                    'Informe seu estado.',



                'estado.size' =>

                    'Informe a sigla do estado com 2 caracteres.',



                'sobre.max' =>

                    'O campo sobre não pode ultrapassar 200 caracteres.',



                'senha.required' =>

                    'Informe uma senha.',



                'senha.min' =>

                    'A senha deve possuir pelo menos 8 caracteres.',



                'senha.confirmed' =>

                    'A confirmação da senha não corresponde.',



                'termos.required' =>

                    'É necessário aceitar os termos.',



                'termos.accepted' =>

                    'É necessário aceitar os termos.',

            ]

        );





        // =====================================

        // NORMALIZAR DADOS

        // =====================================



        $nome =

            trim(

                $request->nome

            );



        $email =

            strtolower(

                trim(

                    $request->email

                )

            );



        $areaAtuacao =

            trim(

                $request->area_atuacao

            );



        $estado =

            strtoupper(

                trim(

                    $request->estado

                )

            );



        $sobre =

            trim(

                $request->sobre ??

                ''

            );





        // =====================================

        // CRIAR USUÁRIO

        // =====================================

        //

        // IMPORTANTE:

        //

        // perfil_usuario não vem do frontend.

        // Todo cadastro realizado pelo aplicativo

        // nasce obrigatoriamente como "usuario".

        //

        // status_usuario também é definido

        // exclusivamente pelo backend.

        // =====================================



        $usuario = app(CodigoEmailService::class)->consumir(
            $email,
            CodigoEmailService::CADASTRO,
            (string) $request->codigo,
            function () use ($email, $nome, $areaAtuacao, $estado, $sobre, $request) {
                if (Usuarios::where('email_usuario', $email)->exists()) {
                    throw ValidationException::withMessages([
                        'email' => 'Já existe uma conta cadastrada com este e-mail.',
                    ]);
                }

                return Usuarios::create([

                'nome_usuario' =>

                    $nome,



                'foto_usuario' =>

                    '',



                'email_usuario' =>

                    $email,



                'area_atuacao_usuario' =>

                    $areaAtuacao,



                'senha_usuario' =>

                    Hash::make(

                        $request->senha

                    ),



                'termos_usuario' =>

                    true,



                'perfil_usuario' =>

                    'usuario',



                'estado_usuario' =>

                    $estado,



                'sobre_usuario' =>

                    $sobre,



                'status_usuario' =>

                    'ATIVO',

            ]);
            }
        );

        if (!$usuario) {
            throw ValidationException::withMessages([
                'codigo' => 'Código inválido, expirado ou com tentativas esgotadas.',
            ]);
        }


        // =====================================

        // GERAR TOKEN

        // =====================================

        //

        // Depois do cadastro o usuário

        // já entra autenticado no aplicativo.

        // =====================================



        $deviceName =

            $request->device_name

            ?: 'app-conexao360';





        $token =

            $usuario

                ->createToken(

                    $deviceName

                )

                ->plainTextToken;





        // =====================================

        // RESPOSTA

        // =====================================



        return response()->json([

            'success' => true,



            'message' =>

                'Conta criada com sucesso.',



            'data' => [

                'token' =>

                    $token,



                'usuario' => [

                    'id_usuario' =>

                        $usuario->id_usuario,



                    'nome_usuario' =>

                        $usuario->nome_usuario,



                    'foto_usuario' =>

                        $usuario->foto_usuario,



                    'email_usuario' =>

                        $usuario->email_usuario,



                    'area_atuacao_usuario' =>

                        $usuario

                            ->area_atuacao_usuario,



                    'estado_usuario' =>

                        $usuario->estado_usuario,



                    'sobre_usuario' =>

                        $usuario->sobre_usuario,



                    'perfil_usuario' =>

                        $usuario->perfil_usuario,

                ],

            ],

        ], 201);

    }





    // =============================================================

    // LOGOUT

    // =============================================================



    public function logout(

        Request $request

    ): JsonResponse {



        $tokenAtual =

            $request

                ->user()

                ->currentAccessToken();





        if ($tokenAtual) {



            $tokenAtual->delete();

        }





        return response()->json([

            'success' => true,



            'message' =>

                'Logout realizado com sucesso.',

        ]);

    }

}