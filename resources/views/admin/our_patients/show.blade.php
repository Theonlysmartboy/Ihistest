@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.our-patients.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.huduma-no')</th>
                            <td field-key='huduma_no'>{{ $our_patient->huduma_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.f-no')</th>
                            <td field-key='f_no'>{{ $our_patient->f_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.m-no')</th>
                            <td field-key='m_no'>{{ $our_patient->m_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.l-name')</th>
                            <td field-key='l_name'>{{ $our_patient->l_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.dob')</th>
                            <td field-key='dob'>{{ $our_patient->dob }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.email')</th>
                            <td field-key='email'>{{ $our_patient->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.photo')</th>
                            <td field-key='photo'>@if($our_patient->photo)<a href="{{ asset(env('UPLOAD_PATH').'/' . $our_patient->photo) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $our_patient->photo) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.telephone')</th>
                            <td field-key='telephone'>{{ $our_patient->telephone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.address')</th>
                            <td field-key='address'>{{ $our_patient->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.diagnostic')</th>
                            <td field-key='diagnostic'>{!! $our_patient->diagnostic !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.our-patients.fields.prescription')</th>
                            <td field-key='prescription'>{!! $our_patient->prescription !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.our_patients.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.datetime').datetimepicker({
                format: "{{ config('app.datetime_format_moment') }}",
                locale: "{{ App::getLocale() }}",
                sideBySide: true,
            });
            
        });
    </script>
            
@stop
