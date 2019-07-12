@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.our-patients.title')</h3>
    @can('our_patient_create')
    <p>
        <a href="{{ route('admin.our_patients.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('our_patient_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.our_patients.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.our_patients.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
            <li><a href="{{url('search')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">Search IHIS database</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped ajaxTable @can('our_patient_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('our_patient_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.our-patients.fields.huduma-no')</th>
                        <th>@lang('quickadmin.our-patients.fields.f-no')</th>
                        <th>@lang('quickadmin.our-patients.fields.m-no')</th>
                        <th>@lang('quickadmin.our-patients.fields.l-name')</th>
                        <th>@lang('quickadmin.our-patients.fields.dob')</th>
                        <th>@lang('quickadmin.our-patients.fields.email')</th>
                        <th>@lang('quickadmin.our-patients.fields.photo')</th>
                        <th>@lang('quickadmin.our-patients.fields.telephone')</th>
                        <th>@lang('quickadmin.our-patients.fields.address')</th>
                        <th>@lang('quickadmin.our-patients.fields.diagnostic')</th>
                        <th>@lang('quickadmin.our-patients.fields.prescription')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('our_patient_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.our_patients.mass_destroy') }}'; @endif
        @endcan
        $(document).ready(function () {
            window.dtDefaultOptions.ajax = '{!! route('admin.our_patients.index') !!}?show_deleted={{ request('show_deleted') }}';
            window.dtDefaultOptions.columns = [@can('our_patient_delete')
                @if ( request('show_deleted') != 1 )
                    {data: 'massDelete', name: 'id', searchable: false, sortable: false},
                @endif
                @endcan{data: 'huduma_no', name: 'huduma_no'},
                {data: 'f_no', name: 'f_no'},
                {data: 'm_no', name: 'm_no'},
                {data: 'l_name', name: 'l_name'},
                {data: 'dob', name: 'dob'},
                {data: 'email', name: 'email'},
                {data: 'photo', name: 'photo'},
                {data: 'telephone', name: 'telephone'},
                {data: 'address', name: 'address'},
                {data: 'diagnostic', name: 'diagnostic'},
                {data: 'prescription', name: 'prescription'},
                
                {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ];
            processAjaxTables();
        });
    </script>
@endsection