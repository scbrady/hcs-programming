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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(Auth::user()->permissions != 0) {
            $assignments = Assignment::where('lockout', '=', 0)->get();

            return view('assignments.list')->with('assignments', $assignments);
        } else {
            $assignments = Assignment::all();

            return view('assignments.list')->with('assignments', $assignments);
        }
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
            $assignment->load('uploads.user');
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
        $user = Auth::user();

        $this->validate($request, [
            'file' => 'required|file',//|mimes:java',
        ]);
        
        $file = $request->file('file');
        $path = $file->storeAs('public/assignments', $id.'_'.$user->id.'.'.$file->getClientOriginalExtension());
        
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

            return response()->json(null, 201);
        } else {
            return response()->json(['file' => ['Could not upload assignment']], 404);
        }
    }

    public function lockout(Request $request, $id)
    {
        if(Auth::user()->permissions == 0) {
            $assignment = Assignment::find($id);
            $assignment->lockout = 1;
            $assignment->save();
            return response()->json(null, 201);
        } else {
            return response()->json(['error' => ['Unauthenticated']], 404);
        }
    }
}
