<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffCreateRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\LogStaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected LogStaffService $logStaffService;

    public function __construct(LogStaffService $logStaffService)
    {
        $this->logStaffService = $logStaffService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.staff.index', [
            'title' => 'Staff',
            'staffs' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.staff.create', [
            'title' => 'Staff',
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffCreateRequest $request)
    {
        User::create($request->safe()->except(['password_confirmation']));

        $this->logStaffService->insert(new Request($request->all()), 'insert');

        return redirect()->route('staffs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(User $staff)
    {
        return view('pages.admin.staff.show', [
            'title' => 'Staff',
            'staff' => $staff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(User $staff)
    {
        return view('pages.admin.staff.edit', [
            'title' => 'Staff',
            'staff' => $staff,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StaffRequest  $request
     * @param  \App\Models\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffUpdateRequest $request, User $staff)
    {
        $staff->update($request->safe()->except(['password_confirmation', 'password']));

        $this->logStaffService->insert(new Request($request->all()), 'update');

        return redirect()->route('staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $staff)
    {
        // set role name for logging
        $staff->role_name = $staff->role->name;

        $staff->delete();

        $this->logStaffService->insert(new Request($staff->toArray()), 'delete');

        return redirect()->route('staffs.index');
    }
}
