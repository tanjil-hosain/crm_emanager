<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount([
            'products',
            'users',
            'sales'
        ])->latest()->paginate(10);

        return view('crm_emanager.backend.admin.branches.index', compact('branches'));
    }

    //create
    public function create()

    {
        return view('crm_emanager.backend.admin.branches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'required|string|max:100|unique:branches,branch_code',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ]);

        $validated['status'] = 'active';

        Branch::create($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }
    public function show(Branch $branch)
    {
        $branch->loadCount(['products', 'users', 'sales']);

        return view('crm_emanager.backend.admin.branches.show', compact('branch'));
    }

    //edit
    public function edit(Branch $branch)

    {
        return view('crm_emanager.backend.admin.branches.edit', compact('branch'));
    }

    //update
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('branches', 'branch_code')->ignore($branch->id),
            ],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }
}
