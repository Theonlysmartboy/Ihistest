@extends('layouts.app')

@section('content')
<div class="card-body">
    <form method="POST" action="{{url('search')}}">
        @csrf
         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Huduma No') }}</label>

                            <div class="col-md-6">
                                <input id="huduma_no" type="text" class="form-control @error('name') is-invalid @enderror" name="huduma_no" value="{{ old('name') }}" required autocomplete="huduma Number" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </div>
        </div>
    </form>
    @endsection

