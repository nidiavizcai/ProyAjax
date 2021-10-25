<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                                        // Le hagrega
        $data['students'] = Student::orderBy('id', 'desc')->paginate(10);
        return view('student.list', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = new Student([
            'first_name' => $request->post('txtFirstName'),
            'last_name' => $request->post('txtLastName'),
            'address' => $request->post('txtAddress')
        ]);
        $student->save();
        return Response()->json($student);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $id)
    {
        //
        $where = array('id' => $id->id);
        $student  = Student::where($where)->first();

        return Response()->json($student);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
        $student = Student::find($request->post('hdnStudentId'));
        $student->first_name = $request->post('txtFirstName');
        $student->last_name = $request->post('txtLastName');
        $student->address = $request->post('txtAddress');
        $student->update();
        return Response()->json($student);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $id)
    {
        //
        $student = Student::where('id', $id->id)->delete();
        return Response()->json($student);
    }
}
