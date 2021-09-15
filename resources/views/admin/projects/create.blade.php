@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.projects.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                            <label class="required" for="code">{{ trans('cruds.project.fields.code') }}</label>
                            <input class="form-control" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                            @if($errors->has('code'))
                                <span class="help-block" role="alert">{{ $errors->first('code') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.code_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                            <label class="required" for="location">{{ trans('cruds.project.fields.location') }}</label>
                            <input class="form-control" type="text" name="location" id="location" value="{{ old('location', '') }}" required>
                            @if($errors->has('location'))
                                <span class="help-block" role="alert">{{ $errors->first('location') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('bowheer') ? 'has-error' : '' }}">
                            <label class="required" for="bowheer">{{ trans('cruds.project.fields.bowheer') }}</label>
                            <input class="form-control" type="text" name="bowheer" id="bowheer" value="{{ old('bowheer', '') }}" required>
                            @if($errors->has('bowheer'))
                                <span class="help-block" role="alert">{{ $errors->first('bowheer') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.bowheer_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                            <label class="required">{{ trans('cruds.project.fields.is_active') }}</label>
                            @foreach(App\Project::IS_ACTIVE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', '1') === (string) $key ? 'checked' : '' }} required>
                                    <label for="is_active_{{ $key }}" style="font-weight: 400">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('is_active'))
                                <span class="help-block" role="alert">{{ $errors->first('is_active') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.is_active_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection