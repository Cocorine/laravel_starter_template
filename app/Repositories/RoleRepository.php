<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Abstract class RoleRepository
 * @package App\Repositories
 */
class RoleRepository extends BaseRepository
{

    /**
     * Role class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change variable $model or $this->role
     * @property Role|mixed $model;
     */
    protected $role;

    /**
     * RoleRepository constructor.
     * 
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

}
