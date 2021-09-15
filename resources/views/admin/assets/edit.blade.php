@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.assets.update", [$asset->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label class="required" for="category_id">{{ trans('cruds.asset.fields.category') }}</label>
                            <select class="form-control select2" name="category_id" id="category_id" required>
                                @foreach($categories as $id => $category)
                                    <option value="{{ $id }}" {{ ($asset->category ? $asset->category->id : old('category_id')) == $id ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <span class="help-block" role="alert">{{ $errors->first('category') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.category_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('serial_number') ? 'has-error' : '' }}">
                            <label for="serial_number">{{ trans('cruds.asset.fields.serial_number') }}</label>
                            <input class="form-control" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}">
                            @if($errors->has('serial_number'))
                                <span class="help-block" role="alert">{{ $errors->first('serial_number') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.serial_number_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required>
                            @if($errors->has('name'))
                                <span class="help-block" role="alert">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('photos') ? 'has-error' : '' }}">
                            <label for="photos">{{ trans('cruds.asset.fields.photos') }}</label>
                            <div class="needsclick dropzone" id="photos-dropzone">
                            </div>
                            @if($errors->has('photos'))
                                <span class="help-block" role="alert">{{ $errors->first('photos') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.photos_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="required" for="status_id">{{ trans('cruds.asset.fields.status') }}</label>
                            <select class="form-control select2" name="status_id" id="status_id" required>
                                @foreach($statuses as $id => $status)
                                    <option value="{{ $id }}" {{ ($asset->status ? $asset->status->id : old('status_id')) == $id ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                            <label class="required" for="location_id">{{ trans('cruds.asset.fields.location') }}</label>
                            <select class="form-control select2" name="location_id" id="location_id" required>
                                @foreach($locations as $id => $location)
                                    <option value="{{ $id }}" {{ ($asset->location ? $asset->location->id : old('location_id')) == $id ? 'selected' : '' }}>{{ $location }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('location'))
                                <span class="help-block" role="alert">{{ $errors->first('location') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.location_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                            <label for="notes">{{ trans('cruds.asset.fields.notes') }}</label>
                            <textarea class="form-control" name="notes" id="notes">{{ old('notes', $asset->notes) }}</textarea>
                            @if($errors->has('notes'))
                                <span class="help-block" role="alert">{{ $errors->first('notes') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.notes_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('project') ? 'has-error' : '' }}">
                            <label class="required" for="project_id">{{ trans('cruds.asset.fields.project') }}</label>
                            <select class="form-control select2" name="project_id" id="project_id" required>
                                @foreach($projects as $id => $project)
                                    <option value="{{ $id }}" {{ ($asset->project ? $asset->project->id : old('project_id')) == $id ? 'selected' : '' }}>{{ $project }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project'))
                                <span class="help-block" role="alert">{{ $errors->first('project') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.project_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
                            <label class="required" for="department_id">{{ trans('cruds.asset.fields.department') }}</label>
                            <select class="form-control select2" name="department_id" id="department_id" required>
                                @foreach($departments as $id => $department)
                                    <option value="{{ $id }}" {{ ($asset->department ? $asset->department->id : old('department_id')) == $id ? 'selected' : '' }}>{{ $department }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('department'))
                                <span class="help-block" role="alert">{{ $errors->first('department') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.department_helper') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('person_in_charge') ? 'has-error' : '' }}">
                            <label for="person_in_charge">{{ trans('cruds.asset.fields.person_in_charge') }}</label>
                            <input class="form-control" type="text" name="person_in_charge" id="person_in_charge" value="{{ old('person_in_charge', $asset->person_in_charge) }}">
                            @if($errors->has('person_in_charge'))
                                <span class="help-block" role="alert">{{ $errors->first('person_in_charge') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.asset.fields.person_in_charge_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.assets.storeMedia') }}',
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($asset) && $asset->photos)
          var files =
            {!! json_encode($asset->photos) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection