@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.patients.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.patients.fields.huduma-no')</th>
                            <td field-key='huduma_no'>{{ $patient->huduma_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.f-no')</th>
                            <td field-key='f_no'>{{ $patient->f_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.m-no')</th>
                            <td field-key='m_no'>{{ $patient->m_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.l-name')</th>
                            <td field-key='l_name'>{{ $patient->l_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.dob')</th>
                            <td field-key='dob'>{{ $patient->dob }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.email')</th>
                            <td field-key='email'>{{ $patient->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.photo')</th>
                            <td field-key='photo'>@if($patient->photo)<a href="{{ asset(env('UPLOAD_PATH').'/' . $patient->photo) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $patient->photo) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.telephone')</th>
                            <td field-key='telephone'>{{ $patient->telephone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.address')</th>
                            <td field-key='address'>{{ $patient->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.diagnostic')</th>
                            <td field-key='diagnostic'>{!! $patient->diagnostic !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.prescription')</th>
                            <td field-key='prescription'>{!! $patient->prescription !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.patients.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
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
