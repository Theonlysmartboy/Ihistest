<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OurPatient;

class SearchPatientController extends Controller
{
   public function index(Request $request){
       if($request->isMethod('post')){
           $data = $request->all();
           $patient = OurPatient::where('huduma_no', '=', $data['huduma_no'])->first();
           if($patient === null){
               return view('admin.our_patients.create')->with(compact('patient'));}
           else{
               return view('admin.our_patients.create')->with(compact('patient'));
              
           }
           
       }
       return view('searchpatient');
   }
}
