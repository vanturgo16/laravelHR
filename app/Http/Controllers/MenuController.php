<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function indexCandidate()
    {
        $candidates=Candidate::get();
        
        return view('candidate.index',compact('candidates'));
    }

    public function storeCandidate(Request $request)
    {
        //dd($request->doc);
        
        $request->validate([
            'cd_name' => 'required',
            'cd_edu' => 'required',
            'cd_birth' => 'required',
            'cd_exp' => 'required',
            'cd_lp' => 'required',
            'cd_ap' => 'required',
            'cd_skill' => 'required',
            'cd_email' => 'required|email',
            'cd_phone' => 'required',
            'doc' => 'mimes:pdf|max:10048',
        ]);

        $candidate = Candidate::create([
            'candidate_name' => $request->cd_name, 
            'candidate_edu' => $request->cd_edu, 
            'candidate_birthday' => $request->cd_birth, 
            'candidate_exp' => $request->cd_exp, 
            'candidate_lastposition' => $request->cd_lp, 
            'candidate_appliedposition' => $request->cd_ap, 
            'candidate_skills' => $request->cd_skill, 
            'candidate_email' => $request->cd_email, 
            'candidate_phone' => $request->cd_phone,
            'candidate_attachment' => ''
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
        
        return redirect('/candidates')->with('status','Success Add Candidate');
    }

    public function updateCandidate(Request $request)
    {
        //dd($request->cd_id);
        $request->validate([
            'cd_name' => 'required',
            'cd_edu' => 'required',
            'cd_birth' => 'required',
            'cd_exp' => 'required',
            'cd_lp' => 'required',
            'cd_ap' => 'required',
            'cd_skill' => 'required',
            'cd_email' => 'required|email',
            'cd_phone' => 'required',
            'doc' => 'mimes:pdf|max:10048',
        ]);

        $candidate = Candidate::where('id',$request->cd_id)
        ->update([
            'candidate_name' => $request->cd_name, 
            'candidate_edu' => $request->cd_edu, 
            'candidate_birthday' => $request->cd_birth, 
            'candidate_exp' => $request->cd_exp, 
            'candidate_lastposition' => $request->cd_lp, 
            'candidate_appliedposition' => $request->cd_ap, 
            'candidate_skills' => $request->cd_skill, 
            'candidate_email' => $request->cd_email, 
            'candidate_phone' => $request->cd_phone,
        ]);

        $id=$request->cd_id;

        if($request->file('doc')){
            $extension = $request->file('doc')->getClientOriginalExtension();
            $doc_name = $id.'_a.'.$extension;

            if(Storage::exists('resume/'.$doc_name)){
                Storage::delete('resume/'.$doc_name);
                $store = $request->file('doc')->storeAs('resume', $doc_name);
            }else{
                //$store = $request->file('doc')->storeAs('resume', $doc_name);
                return redirect('/candidates')->with('status','Failed Update File to Storage Candidate');
            }
        }
        else{
            $doc_name="";
        }

        $insert_filename=Candidate::where('id',$id)
            ->update([
            'candidate_attachment' => $doc_name,
        ]);

        return redirect('/candidates')->with('status','Success Update Candidate');
    }

    public function deleteCandidate($id)
    {
        $delete=Candidate::where('id',$id)->delete();

        $doc_name = $id.'_a.pdf';

        if(Storage::exists('resume/'.$doc_name)){
            Storage::delete('resume/'.$doc_name);
        }else{
            //$store = $request->file('doc')->storeAs('resume', $doc_name);
            return redirect('/candidates')->with('status','Failed Delete File from Storage Candidate');
        }

        return redirect('/candidates')->with('status','Success Delete Candidate');
    }
}
