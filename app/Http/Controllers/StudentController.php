<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;

class StudentController extends Controller
{
    
    
    public function index(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Student::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteStudent">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('student');
    }
       
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Student::updateOrCreate([
                    'id' => $request->Student_id
                ],
                [
                    'name' => $request->name, 
                    'code' => $request->code,
                    'adress' => $request->adress,
                ]);        
     
        return response()->json(['success'=>'Student saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Student = Student::find($id);
        return response()->json($Student);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $Student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
      
        return response()->json(['success'=>'Student deleted successfully.']);
    }
}
