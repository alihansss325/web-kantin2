<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::latest()->paginate(10);
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:50|unique:schools',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'principal_name' => 'required|string|max:100',
            'level' => ['required', Rule::in(['sd', 'smp', 'sma', 'smk'])],
            'student_count' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $school = School::create($validator->validated());

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    public function show(School $school)
    {
        $school->load(['users', 'transactions', 'topups']);
        return view('admin.schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'code' => ['required', 'string', 'max:50', Rule::unique('schools')->ignore($school->id)],
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'principal_name' => 'required|string|max:100',
            'level' => ['required', Rule::in(['sd', 'smp', 'sma', 'smk'])],
            'student_count' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $school->update($validator->validated());

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil diperbarui!');
    }

    public function destroy(School $school)
    {
        if ($school->users()->count() > 0) {
            return back()
                ->with('error', 'Tidak dapat menghapus sekolah yang memiliki siswa!');
        }

        $school->delete();

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil dihapus!');
    }

    public function toggleStatus(School $school)
    {
        $school->update(['is_active' => !$school->is_active]);
        
        $status = $school->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()
            ->with('success', "Sekolah berhasil {$status}!");
    }
}
