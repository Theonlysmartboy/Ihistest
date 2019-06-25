<?php

namespace App\Http\Controllers\Admin;

use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientsRequest;
use App\Http\Requests\Admin\UpdatePatientsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\DataTables;

class PatientsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('patient_access')) {
            return abort(401);
        }


        
        if (request()->ajax()) {
            $query = Patient::query();
            $template = 'actionsTemplate';
            if(request('show_deleted') == 1) {
                
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'patients.id',
                'patients.huduma_no',
                'patients.f_no',
                'patients.m_no',
                'patients.l_name',
                'patients.dob',
                'patients.email',
                'patients.photo',
                'patients.telephone',
                'patients.address',
                'patients.diagnostic',
                'patients.prescription',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'patient_';
                $routeKey = 'admin.patients';

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
                if($row->photo) { return '<a href="'. asset(env('UPLOAD_PATH').'/' . $row->photo) .'" target="_blank"><img src="'. asset(env('UPLOAD_PATH').'/thumb/' . $row->photo) .'"/>'; };
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

            $table->rawColumns(['actions','massDelete','photo']);

            return $table->make(true);
        }

        return view('admin.patients.index');
    }

    /**
     * Show the form for creating new Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }
        return view('admin.patients.create');
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param  \App\Http\Requests\StorePatientsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientsRequest $request)
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $patient = Patient::create($request->all());



        return redirect()->route('admin.patients.index');
    }


    /**
     * Show the form for editing Patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);

        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update Patient in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientsRequest $request, $id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());



        return redirect()->route('admin.patients.index');
    }


    /**
     * Display Patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('patient_view')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);

        return view('admin.patients.show', compact('patient'));
    }


    /**
     * Remove Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Delete all selected Patient at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Patient::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->restore();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Permanently delete Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->forceDelete();

        return redirect()->route('admin.patients.index');
    }
}
