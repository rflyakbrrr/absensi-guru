<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        // Fitur Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('position', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $teachers = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('admin.teachers.index', [
            'title' => 'Data Guru',
            'teachers' => $teachers
        ]);
    }

    public function create()
    {
        return view('admin.teachers.create', ['title' => 'Tambah Guru']);
    }

    public function store(StoreTeacherRequest $request)
    {
        Teacher::create($request->validated());
        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', [
            'title' => 'Edit Guru',
            'teacher' => $teacher
        ]);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy($id, Request $request)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->delete();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data guru berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil dihapus!');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data guru: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.teachers.index')->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }
}