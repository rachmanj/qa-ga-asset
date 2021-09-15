@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.department.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.departments.update", [$department->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="required" for="name">{{ trans('cruds.department.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required>
                            @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.department.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('alias') ? 'has-error' : '' }}">
                            <label for="alias">{{ trans('cruds.department.fields.alias') }}</label>
                            <input class="form-control" type="text" name="alias" id="alias" value="{{ old('alias', $department->alias) }}">
                            @if($errors->has('alias'))
                                <span class="help-block" role="alert">{{ $errors->first('alias') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.department.fields.alias_helper') }}</span>
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