<?php
/**
 * @OA\Info(title=APP_NAME, version=APP_VERSION)
 * @OA\Server(url=APP_HOST)
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\User\SaveRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      tags={"users"},
     *      description="Retrieve data from existent user",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="User Model",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function get($id)
    {
        $user = $this->userService->getById($id);
        return response()->json($user->toArray());
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"users"},
     *      description="Find by criteria and retrieve data from existent user",
     *      @OA\Parameter(
     *          name="nome",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="cpf",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="User Model",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function find(Request $request)
    {
        $params = [
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf')
        ];
        $user = $this->userService->find($params);
        return response()->json($user->toArray());
    }

    /**
     * @OA\POST(
     *      path="/users",
     *      tags={"users"},
     *      description="Create new user",
     *      @OA\Parameter(
     *          name="nome",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="cpf",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="datanascimento",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="User Model",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    /**
     * @OA\PUT(
     *      path="/users/{id}",
     *      tags={"users"},
     *      description="Update data from existent user",
     *      @OA\Parameter(
     *          name="nome",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="cpf",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="datanascimento",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="User Model",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function save(SaveRequest $request, $id = 0)
    {
        $user = $this->userService->save($request->getRequest(), $id);
        return response()->json($user->toArray(), $id > 0 ? 200 : 201);
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return response(null, 204);
    }
}
