<?php

namespace App\Http\Controllers;

use App\Models\UserRegister;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

    /**
     * @OA\Info(
     *    version="1.0.0",
     *    title="HUB"
     * )
     * @OA\PathItem(path="/User")
    */

class UserRegisterController extends BaseController
{
    /**
     * @OA\Get(
     *      tags={"/User"},
     *      path="/api/user?key=",
     *      summary="Returns all available users",
     *      @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="Return the all user",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="An array will be sent with all the found users",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="string",
     *                      description="User id, primary key"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="Name of the user"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="Email of the user registered"
     *                  ),
     *                  @OA\Property(
     *                      property="cpf",
     *                      type="string",
     *                      description="CPF of the user registered"
     *                  ),
     *                  @OA\Property(
     *                      property="address",
     *                      type="string",
     *                      description="Address of the user registered"
     *                  ),
     *                  @OA\Property(
     *                      property="cep",
     *                      type="string",
     *                      description="Cep of the user registered"
     *                  ),
     *                  @OA\Property(
     *                      property="date_birth",
     *                      type="string",
     *                      format="date",
     *                      description="Date of birth"
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      description="Status: Active 1 | 0 Deactive"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date the user was created"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date the user was updated"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Error fetching the user"
     *      )
     * )
     */


    public function index()
    {
        try {
            $data = UserRegister::whereNull('deleted_at')->get();

            if ($data->isEmpty()) {
                return $this->sendError('No user registred');
            }
            return $this->sendResponse('Operation success',$data);
        } 
        catch (\Exception $e) {
            return $this->sendError('Error has been occurred. Error details were displayed.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Post(
     *      tags={"/User"},
     *      path="/api/user",
     *      summary="Create User",
     *      description="Create a new user.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              required={"name","email","cpf","address","cellphone","cep","date_birth","password","password_confirmation"},
     *              @OA\Property(property="name",       type="string",                               example="John Doe", description="User's name"),
     *              @OA\Property(property="email",      type="string", format="email",               example="john@example.com", description="User's email"),
     *              @OA\Property(property="cpf",        type="string",                               example="123.456.789-00", description="User's CPF"),
     *              @OA\Property(property="address",    type="string",                               example="123 Main St, City", description="User's address"),
     *              @OA\Property(property="cellphone",  type="string",                               example="1234567890", description="User's cellphone number"),
     *              @OA\Property(property="cep",        type="string",                               example="12345-678", description="User's ZIP code"),
     *              @OA\Property(property="date_birth", type="string", format="date",                example="1990-01-01", description="User's date of birth"),
     *              @OA\Property(property="password",   type="string", format="password",            example="password123", description="User's password"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="password123", description="Confirmation of user's password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id",    type="string", description="User id, primary key"),
     *              @OA\Property(property="name",       type="string", description="Name of the user"),
     *              @OA\Property(property="email",      type="string", description="Email of the user registered"),
     *              @OA\Property(property="cpf",        type="string", description="CPF of the user registered"),
     *              @OA\Property(property="address",    type="string", description="Address of the user registered"),
     *              @OA\Property(property="cep",        type="string", description="Cep of the user registered"),
     *              @OA\Property(property="date_birth", type="string", format="date", description="Date of birth"),
     *              @OA\Property(property="status",     type="integer", description="Status: Active 1 | 0 Deactive"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="Date the user was created"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="Date the user was updated"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Validation error message"),
     *              @OA\Property(property="errors", type="object", description="Validation errors details"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Error message"),
     *          )
     *      )
     * )
     */

    public function store(Request $request) 
    {
        try {
            Log::info('Recebendo solicitação para registrar usuário', ['request' => $request->all()]);

            $rules = [
                'name'          => 'bail|required|string|max:225|min:1',
                'email'         => 'bail|required|string|email|max:225|min:1|unique:user_register',
                'cpf'           => 'bail|required|string|max:14|min:1|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'address'       => 'bail|required|string|max:225|min:1',
                'cellphone'     => 'bail|required|string|max:14|min:12|unique:user_register',
                'cep'           => 'bail|required|string|max:9|min:8',
                'date_birth'    => 'bail|required|date_format:Y-m-d',
                'password'      => [
                    'bail',
                    'required',
                    'confirmed',
                    'max:35',
                    'min:6',
                    Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                            ->uncompromised()
                ],
                'password_confirmation' => 'bail|required|same:password',
            ];

            Log::info('Iniciando a validação dos dados do usuário');

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::warning('Erro de validação', ['errors' => $validator->errors()]);
                return $this->sendError('Erro de validação.', $validator->errors(), 422);
            }

            Log::info('Dados do usuário validados com sucesso');

            $data = $request->all();
            $data['status'] = 1;
            $data['password'] = Hash::make($data['password']); 

            Log::info('Criando registro do usuário no banco de dados', ['data' => $data]);

            $user = UserRegister::create($data);

            if ($user) {
                return $this->sendResponse('Usuário registrado com sucesso.', $user, 200);
            } else {
                Log::error('Falha ao registrar o usuário');
                return $this->sendError('Falha ao registrar o usuário.', [], 500);
            }
        } catch (\Exception $e) {
            Log::error('Erro durante o registro do usuário: ' . $e->getMessage());
            return $this->sendError('Ocorreu um erro durante o registro. ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * @OA\Get(
     *      tags={"/User"},
     *      path="/api/user/{id}",
     *      summary="Get User by ID",
     *      description="Returns a single user by ID.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the user to retrieve",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User found",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="string", description="User id, primary key"),
     *              @OA\Property(property="name", type="string", description="Name of the user"),
     *              @OA\Property(property="email", type="string", description="Email of the user registered"),
     *              @OA\Property(property="cpf", type="string", description="CPF of the user registered"),
     *              @OA\Property(property="address", type="string", description="Address of the user registered"),
     *              @OA\Property(property="cep", type="string", description="Cep of the user registered"),
     *              @OA\Property(property="date_birth", type="string", format="date", description="Date of birth"),
     *              @OA\Property(property="status", type="integer", description="Status: Active 1 | 0 Deactive"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="Date the user was created"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="Date the user was updated"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="User not found message"),
     *          )
     *      )
     * )
     */


    public function show($id)
    {
        try {
            $user = UserRegister::find($id);

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            return $this->sendResponse('Operation success', $user);
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Put(
     *      tags={"/User"},
     *      path="/api/user/{id}",
     *      summary="Update User by ID",
     *      description="Update an existing user by ID.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the user to update",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              required={"name","email","cpf","address","cellphone","cep"},
     *              @OA\Property(property="name", type="string", example="John Doe", description="User's name"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email"),
     *              @OA\Property(property="cpf", type="string", example="123.456.789-00", description="User's CPF"),
     *              @OA\Property(property="address", type="string", example="123 Main St, City", description="User's address"),
     *              @OA\Property(property="cellphone", type="string", example="1234567890", description="User's cellphone number"),
     *              @OA\Property(property="cep", type="string", example="12345-678", description="User's ZIP code"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Success message"),
     *              @OA\Property(property="user_id", type="integer", description="Updated user's ID"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Validation error message"),
     *              @OA\Property(property="errors", type="object", description="Validation errors details"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="User not found message"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Error message"),
     *          )
     *      )
     * )
    */

    public function update(Request $request, $id)
    {
        try {
            $user = UserRegister::findOrFail($id);

            $rules = [
                'name'      => 'string|max:255',
                'email'     => 'string|email|max:255|unique:user_register,email,' . $id,
                'cpf'       => 'string|max:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'address'   => 'string|max:255',
                'cellphone' => 'string|max:14|min:12',
                'cep'       => 'string|max:9|min:8',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $user->fill($request->only(['name', 'email', 'address', 'cellphone', 'cep']));
            $user->cpf = preg_replace('/[^0-9]/', '', $request->input('cpf'));
            $user->save();

            return $this->sendResponse('User updated successfully', $user);
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Delete(
     *      tags={"/User"},
     *      path="/api/user/{id}",
     *      summary="Delete User by ID",
     *      description="Delete an existing user by ID (soft delete).",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the user to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Success message"),
     *              @OA\Property(property="user_id", type="integer", description="Deleted user's ID"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="User not found message"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Error message"),
     *          )
     *      )
     * )
     */

    public function destroy($id) 
    {
        try {
            $user = UserRegister::findOrFail($id);
            $user->status = 0; 
            $user->save();     

            $user->delete(); 

            return $this->sendResponse('User deleted successfully', $user);
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()]);
        }
    }
}
