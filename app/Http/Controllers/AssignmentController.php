<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all the assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::all();

        return view('assignments.list')->with('assignments', $assignments);
    }

    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'due' => 'required|date',
        ]);
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Assignment::create($input);

        return Redirect::to('programs');
    }

    /**
     * Show an assignment.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $assignment = Assignment::find($id);

        if(Auth::user()->permissions != 0) {
            $assignment->load('upload');
            return view('assignments.show')->with('assignment', $assignment);
        } else {
            $assignment->load('uploads');
            return view('assignments.admin-show')->with('assignment', $assignment);
        }
    }

    /**
     * Upload an assignment.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $input = $request->all();
        $user = Auth::user();

        $validator = Validator::make($input, [
            'file' => 'required|file',//|mimes:java',
        ]);
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $file = $request->file('file');
        $path = $file->storeAs('assignments', $id.'_'.$user->id.'.'.$file->getClientOriginalExtension());
        
        if ($path) {
            $upload = Upload::where('assignment_id', '=', $id)->where('user_id', '=', $user->id)->first();
            if($upload) {
                $upload->name = $file->getClientOriginalName();
                $upload->file = $path;
                $upload->save();
            } else {
                Upload::create([
                    'assignment_id' => $id,
                    'user_id' => $user->id,
                    'name' => $file->getClientOriginalName(),
                    'file' => $path,
                ]);
            }

            $request->session()->flash('alert-success', 'Successfully uploaded your assignment');
        } else {
            $request->session()->flash('alert-error', 'Could not upload your assignment at this time');
        }

        return Redirect::to('programs/'.$id);
    }
}
