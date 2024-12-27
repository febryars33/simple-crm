<?php

namespace App\Http\Controllers\API;

use App\Enums\Employee\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Requests\Company\UpdateRequest;
use App\Http\Resources\Company as ResourcesCompany;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = Company::query();

        $company->sortable();

        $company->searchable();

        $company = $company->paginate();

        /** @var AbstractPaginator $company */
        $company->getCollection()->transform(function ($value) {
            return new ResourcesCompany($value);
        });

        return response()->json([
            'data' => $company,
            'message' => 'Companies retrieved successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $company = Company::create($request->validated());

            $employee = $company->employees()->create([
                'name' => $request->input('employee.name'),
                'nik' => $request->input('employee.nik'),
                'phone' => $request->input('employee.phone'),
                'birth_place' => $request->input('employee.birth_place'),
                'birth_date' => $request->input('employee.birth_date'),
                'address' => $request->input('employee.address'),
                'role' => Role::MANAGER->value,
            ]);

            $user = User::create([
                'name' => $request->input('employee.name'),
                'email' => $request->input('employee.email'),
                'password' => Hash::make($request->input('employee.password')),
            ]);

            $user->userable()->associate($employee)->save();

            DB::commit();

            return response()->json([
                'message' => 'Company created successfully',
                'data' => $company,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage(),
                'data' => null,
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json([
            'data' => new ResourcesCompany($company),
            'message' => 'Company retrieved successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Company $company)
    {
        $company->update($request->validated());

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => new ResourcesCompany($company),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully',
            'data' => new ResourcesCompany($company),
        ]);
    }
}
