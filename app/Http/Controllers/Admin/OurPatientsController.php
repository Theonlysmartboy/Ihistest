<?php

namespace App\Http\Controllers\Admin;

use App\OurPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOurPatientsRequest;
use App\Http\Requests\Admin\UpdateOurPatientsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\DataTables;
use App\Patient;

class OurPatientsController extends Controller {

    use FileUploadTrait;

    /**
     * Display a listing of OurPatient.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Gate::allows('our_patient_access')) {
            return abort(401);
        }
        if (request()->ajax()) {
            $query = OurPatient::query();
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {

                if (!Gate::allows('our_patient_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'our_patients.id',
                'our_patients.huduma_no',
                'our_patients.f_no',
                'our_patients.m_no',
                'our_patients.l_name',
                'our_patients.dob',
                'our_patients.email',
                'our_patients.photo',
                'our_patients.telephone',
                'our_patients.address',
                'our_patients.diagnostic',
                'our_patients.prescription',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'our_patient_';
                $routeKey = 'admin.our_patients';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('f_no', function ($row) {
                return $row->f_no ? $row->f_no : '';
            });
            $table->editColumn('m_no', function ($row) {
                return $row->m_no ? $row->m_no : '';
            });
            $table->editColumn('l_name', function ($row) {
                return $row->l_name ? $row->l_name : '';
            });
            $table->editColumn('dob', function ($row) {
                return $row->dob ? $row->dob : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($row->photo) {
                    return '<a href="' . asset(env('UPLOAD_PATH') . '/' . $row->photo) . '" target="_blank"><img src="' . asset(env('UPLOAD_PATH') . '/thumb/' . $row->photo) . '"/>';
                };
            });
            $table->editColumn('telephone', function ($row) {
                return $row->telephone ? $row->telephone : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('diagnostic', function ($row) {
                return $row->diagnostic ? $row->diagnostic : '';
            });
            $table->editColumn('prescription', function ($row) {
                return $row->prescription ? $row->prescription : '';
            });

            $table->rawColumns(['actions', 'massDelete', 'photo']);

            return $table->make(true);
        }

        return view('admin.our_patients.index');
    }

    /**
     * Show the form for creating new OurPatient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Gate::allows('our_patient_create')) {
            return abort(401);
        }
        return view('admin.our_patients.create');
    }

    /**
     * Store a newly created OurPatient in storage.
     * 
     * add the patient to the main system if not exist
     *
     * @param  \App\Http\Requests\StoreOurPatientsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOurPatientsRequest $request) {
        if (!Gate::allows('our_patient_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $our_patient = OurPatient::create($request->all());
        $data = $request->all();
        $user = patient::where('huduma_no', '=', $data['huduma_no'])->first();
        if ($user === null) {
            $patient = new Patient;
            $patient->huduma_no = $data['huduma_no'];
            $patient->name = $data['f_no'] . " " . $data['m_no'] . " " . $data['l_name'];
            $patient->zone_id = 001;
            $patient->hospital_id = 001;
            $patient->save();
        }
        return redirect()->route('admin.our_patients.index');
    }

    /**
     * Show the form for editing OurPatient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (!Gate::allows('our_patient_edit')) {
            return abort(401);
        }
        $our_patient = OurPatient::findOrFail($id);

        return view('admin.our_patients.edit', compact('our_patient'));
    }

    /**
     * Update OurPatient in storage.
     *
     * @param  \App\Http\Requests\UpdateOurPatientsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOurPatientsRequest $request, $id) {
        if (!Gate::allows('our_patient_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $our_patient = OurPatient::findOrFail($id);
        $our_patient->update($request->all());



        return redirect()->route('admin.our_patients.index');
    }

    /**
     * Display OurPatient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if (!Gate::allows('our_patient_view')) {
            return abort(401);
        }
        $our_patient = OurPatient::findOrFail($id);

        return view('admin.our_patients.show', compact('our_patient'));
    }

    /**
     * Remove OurPatient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Gate::allows('our_patient_delete')) {
            return abort(401);
        }
        $our_patient = OurPatient::findOrFail($id);
        $our_patient->delete();

        return redirect()->route('admin.our_patients.index');
    }

    /**
     * Delete all selected OurPatient at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request) {
        if (!Gate::allows('our_patient_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = OurPatient::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore OurPatient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) {
        if (!Gate::allows('our_patient_delete')) {
            return abort(401);
        }
        $our_patient = OurPatient::onlyTrashed()->findOrFail($id);
        $our_patient->restore();

        return redirect()->route('admin.our_patients.index');
    }

    /**
     * Permanently delete OurPatient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id) {
        if (!Gate::allows('our_patient_delete')) {
            return abort(401);
        }
        $our_patient = OurPatient::onlyTrashed()->findOrFail($id);
        $our_patient->forceDelete();

        return redirect()->route('admin.our_patients.index');
    }

}
