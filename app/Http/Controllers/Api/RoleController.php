<?php

namespace App\Http\Controllers\Api;

use App\Helppers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {

        $role = Role::all();

        $data = $role->map(function ($r) {
            return [
                'id' => $r->id,
                'name' => $r->name,
            ];
        });

        return ApiResponse::success('Berhasil Menampilkan Data', $data , 200);
    }
}
