<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\RoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class RoleController extends Controller
{

    /**
     * @var service
     */
    private $roleService;

    /**
     * Instantiate a new RoleController instance.
     * @param RoleRepository $roleRepositoryInterface
     */
    public function __construct(RoleRepository $roleRepositoryInterface)
    {
        $this->middleware(['auth:api']);
        $this->roleService = $roleRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        try {
            
            $roles = $this->roleService->all();

            return response()->json(['status' => 'success', 'message' => null, 'data' => $roles], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allWithTrashed()
    {
        
        try {
            
            $roles = $this->roleService->allWithTrashed();

            return response()->json(['status' => 'success', 'message' => null, 'data' => $roles], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            
            $role = $this->roleService->create(Arr::only($request->all(),'name'));

            $role->permissions()->sync($request->permisssions,true);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été crée", 'data' => $role], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            
            $role = $this->roleService->find($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été crée", 'data' => $role], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            
            //$role = $this->roleService->update($request->all(), $id);

            $role =  $this->roleService->update(Arr::only($request->all(),'name'),$id);

            $role->permissions()->sync($request->permisssions,false);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été modifié", 'data' => $role], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            
            $role = $this->roleService->delete($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été supprimé", 'data' => $role], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        try {
            
            $role = $this->roleService->destroy($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a totalement été supprimé de la base", 'data' => $role], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
