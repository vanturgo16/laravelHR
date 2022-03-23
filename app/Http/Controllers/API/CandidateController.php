<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Candidate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CandidateController extends BaseController
{
    public function Create(Request $request)
    {
        //dd('hai');
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'education' => 'required',
            'birthday' => 'required',
            'experience' => 'required',
            'last_position' => 'required',
            'applied_position' => 'required',
            'skill' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'doc' => 'required|mimes:pdf|max:10048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());       
        }

        $candidate = Candidate::create([
            'candidate_name' => $request->name, 
            'candidate_edu' => $request->education, 
            'candidate_birthday' => $request->birthday, 
            'candidate_exp' => $request->experience, 
            'candidate_lastposition' => $request->last_position, 
            'candidate_appliedposition' => $request->applied_position, 
            'candidate_skills' => $request->skill, 
            'candidate_email' => $request->email, 
            'candidate_phone' => $request->phone,
        ]);

        $id=$candidate->id;

        if($request->file('doc')){
            $extension = $request->file('doc')->getClientOriginalExtension();
            $doc_name = $id.'_a.'.$extension;
            $store = $request->file('doc')->storeAs('resume', $doc_name);
        }
        else{
            $doc_name="";
        }

        $insert_filename=Candidate::where('id',$id)
            ->update([
            'candidate_attachment' => $doc_name,
        ]);

        $response = [
            'success' => true,
            'candidate' => $candidate->candidate_name,
            'message' => 'Success Add Candidate',
        ];

        return response()->json($response, 200);
    }

    public function Read()
    {
        $candidates=Candidate::orderBy('id','desc')
        ->get();

        $response = [
            'success' => true,
            'data' => $candidates,
            'message' => 'Success Read All Candidates',
        ];

        return response()->json($response, 200);
    }

    public function Update(Request $request,$id)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'education' => 'required',
            'birthday' => 'required',
            'experience' => 'required',
            'last_position' => 'required',
            'applied_position' => 'required',
            'skill' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'doc' => 'required|mimes:pdf|max:10048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());       
        }

        $candidate = Candidate::where('id',$id)
        ->update([
            'candidate_name' => $request->name, 
            'candidate_edu' => $request->education, 
            'candidate_birthday' => $request->birthday, 
            'candidate_exp' => $request->experience, 
            'candidate_lastposition' => $request->last_position, 
            'candidate_appliedposition' => $request->applied_position, 
            'candidate_skills' => $request->skill, 
            'candidate_email' => $request->email, 
            'candidate_phone' => $request->phone,
        ]);

        $id=$id;

        if($request->file('doc')){
            $extension = $request->file('doc')->getClientOriginalExtension();
            $doc_name = $id.'_a.'.$extension;

            Storage::delete('resume/'.$doc_name);
            $store = $request->file('doc')->storeAs('resume', $doc_name);
        }
        else{
            $doc_name="";
        }

        $insert_filename=Candidate::where('id',$id)
            ->update([
            'candidate_attachment' => $doc_name,
        ]);

        $response = [
            'success' => true,
            'id updated' => $id,
            'message' => 'Success Update Candidate',
        ];

        return response()->json($response, 200);
    }

    public function Delete($id)
    {
        $delete=Candidate::where('id',$id)->delete();

        $doc_name = $id.'_a.pdf';

        Storage::delete('resume/'.$doc_name);

        $response = [
            'success' => true,
            'id deleted' => $id,
            'message' => 'Success Delete Candidate',
        ];
        

        return response()->json($response, 200);
    }
}
