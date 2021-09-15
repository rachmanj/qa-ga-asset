@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.project.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $project->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.code') }}
                                    </th>
                                    <td>
                                        {{ $project->code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.location') }}
                                    </th>
                                    <td>
                                        {{ $project->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.bowheer') }}
                                    </th>
                                    <td>
                                        {{ $project->bowheer }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.is_active') }}
                                    </th>
                                    <td>
                                        {{ App\Project::IS_ACTIVE_RADIO[$project->is_active] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.projects.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.relatedData') }}
                </div>
                <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                    <li role="presentation">
                        <a href="#project_assets" aria-controls="project_assets" role="tab" data-toggle="tab">
                            {{ trans('cruds.asset.title') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" role="tabpanel" id="project_assets">
                        @includeIf('admin.projects.relationships.projectAssets', ['assets' => $project->projectAssets])
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection