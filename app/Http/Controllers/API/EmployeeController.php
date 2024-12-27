<?php

namespace App\Http\Controllers\API;

use App\Enums\Employee\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Http\Resources\Employee as ResourcesEmployee;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $employee = Employee::with(['company', 'user']);

        if (role(Employee::ROLE_MANAGER)->check()) {
            $employee->whereCompany($user->userable->company_id);
        } else {
            $employee->whereCompany($user->userable->company_id)->whereNotManager();
        }

        $employee->sortable();

        $employee->searchable();

        $employee = $employee->paginate();

        /** @var AbstractPaginator $employee */
        $employee->getCollection()->transform(function ($value) {
            return new ResourcesEmployee($value);
        });

        return response()->json([
            'data' => $employee,
            'message' => 'Employees retrieved successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $employee = Employee::create(array_merge($request->validated(), ['company_id' => $user->userable->company_id, 'role' => Role::EMPLOYEE->value]));

        return response()->json([
            'data' => new ResourcesEmployee($employee),
            'message' => 'Employee created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        Gate::authorize('view', $employee);

        /** @var User $user */
        $user = Auth::user();

        if ($user->userable->role->value === Role::EMPLOYEE->value && $employee->role->value === Role::MANAGER->value) {
            abort(403, 'This action is unauthorized.');
        }

        $employee->load(['company', 'user']);

        return response()->json([
            'data' => new ResourcesEmployee($employee),
            'message' => 'Employee retrieved successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Employee $employee)
    {
        Gate::authorize('update', $employee);

        $employee->update($request->validated());

        return response()->json([
            'data' => new ResourcesEmployee($employee),
            'message' => 'Employee updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        Gate::authorize('delete', $employee);

        $employee->delete();

        return response()->json([
            'data' => new ResourcesEmployee($employee),
            'message' => 'Employee deleted successfully',
        ]);
    }
}
