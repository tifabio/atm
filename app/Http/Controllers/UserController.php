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
     *      @OA\Response(
     *          response="200", 
     *          description="User Model",
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
