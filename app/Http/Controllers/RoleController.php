<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\LogRoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected LogRoleService $logRoleService;

    public function __construct(LogRoleService $logRoleService)
    {
        $this->logRoleService = $logRoleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.roles.index', [
            'title' => 'Roles',
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.roles.create', [
            'title' => 'Create Role'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create(
            $request->validate([
                'name' => 'required'
            ])
        );

        $this->logRoleService->insert($request, 'insert');

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('pages.admin.roles.edit', [
            'title' => 'Edit Roles',
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update(
            $request->validate([
                'name' => 'required'
            ])
        );

        $this->logRoleService->insert($request, 'update');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $this->logRoleService->insert(new Request($role->toArray()), 'delete');

        return redirect()->route('roles.index');
    }
}
