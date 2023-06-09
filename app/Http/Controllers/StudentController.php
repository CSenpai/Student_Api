<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Helpers\APiFormatter;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $student = Student::all();
        $search = $request->search_nama;
        $limit = $request->limit;
        $student = Studen::where('nama', 'LIKE', '%'.search.'%')->limit($limit)->get();

        if ($student) {
            return ApiFormatter::createApi(200, 'success', $students);
        } else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $student = $student::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $getDataSaved = Student::where('id', $student->id)->first();

            if ($getDatasaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Expection $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $studentDetail = Student::where('id', $id)->first();

            if ($studentDetail) {
                return ApiFormatter::createApi(200, 'success', $studentDetail);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, $error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $student = Student::where('id', $student->id)->first();

            $student->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $updateStudent = Student::where('id', $student->id)->first();

            if ($updateStudent) {
                return ApiFormatter::createApi(200, 'success', $updateStudent);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } 
        
        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student = Student::findOrFall($id);
            $proses = $student->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data!');
            } else {
                return ApiFormatter::createApi(400, 'failed', $error);
            }
        } 

        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    public function trash()
    {
        try {
            $student = Student::onlyTrashed()->get();
            if ($student) {
                return ApiFormatter::createApi(200, 'success', $students);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }

        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $student = Student::onlyTrashed()->where('id', $id);
            $student->restore();
            $dataRestore = Student::where('id', $id)->first();
            if ($dataRestore) {
                return ApiFormatter::createApi(200, 'success', $dataRestore);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }

        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            $student = Student::onlyTrashed()->where('id', $id);
            $proses = $student->forceDelete();
            if ($proses) {
                return ApiFormatter::createApi(200, 'success', 'Data dihapus permanen!');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        }

        catch (Exception $error) {
            return ApiFormatter::createApi(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }
}
