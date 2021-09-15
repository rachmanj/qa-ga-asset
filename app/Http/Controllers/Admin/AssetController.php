<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use App\AssetCategory;
use App\AssetLocation;
use App\AssetStatus;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAssetRequest;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Project;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AssetController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('asset_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Asset::with(['category', 'status', 'location', 'project', 'department'])->select(sprintf('%s.*', (new Asset)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'asset_show';
                $editGate      = 'asset_edit';
                $deleteGate    = 'asset_delete';
                $crudRoutePart = 'assets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->editColumn('serial_number', function ($row) {
                return $row->serial_number ? $row->serial_number : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('photos', function ($row) {
                if (!$row->photos) {
                    return '';
                }

                $links = [];

                foreach ($row->photos as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->addColumn('location_name', function ($row) {
                return $row->location ? $row->location->name : '';
            });

            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : "";
            });
            $table->addColumn('project_code', function ($row) {
                return $row->project ? $row->project->code : '';
            });

            $table->editColumn('project.location', function ($row) {
                return $row->project ? (is_string($row->project) ? $row->project : $row->project->location) : '';
            });
            $table->editColumn('project.bowheer', function ($row) {
                return $row->project ? (is_string($row->project) ? $row->project : $row->project->bowheer) : '';
            });
            $table->addColumn('department_alias', function ($row) {
                return $row->department ? $row->department->alias : '';
            });

            $table->editColumn('department.name', function ($row) {
                return $row->department ? (is_string($row->department) ? $row->department : $row->department->name) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'photos', 'status', 'location', 'project', 'department']);

            return $table->make(true);
        }

        $asset_categories = AssetCategory::get();
        $asset_statuses   = AssetStatus::get();
        $asset_locations  = AssetLocation::get();
        $projects         = Project::get();
        $departments      = Department::get();

        return view('admin.assets.index', compact('asset_categories', 'asset_statuses', 'asset_locations', 'projects', 'departments'));
    }

    public function create()
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::all()->pluck('alias', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.assets.create', compact('categories', 'statuses', 'locations', 'projects', 'departments'));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $asset->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $asset->id]);
        }

        return redirect()->route('admin.assets.index');
    }

    public function edit(Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::all()->pluck('alias', 'id')->prepend(trans('global.pleaseSelect'), '');

        $asset->load('category', 'status', 'location', 'project', 'department');

        return view('admin.assets.edit', compact('categories', 'statuses', 'locations', 'projects', 'departments', 'asset'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->update($request->all());

        if (count($asset->photos) > 0) {
            foreach ($asset->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }

        $media = $asset->photos->pluck('file_name')->toArray();

        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $asset->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.assets.index');
    }

    public function show(Asset $asset)
    {
        abort_if(Gate::denies('asset_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset->load('category', 'status', 'location', 'project', 'department');

        return view('admin.assets.show', compact('asset'));
    }

    public function destroy(Asset $asset)
    {
        abort_if(Gate::denies('asset_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssetRequest $request)
    {
        Asset::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('asset_create') && Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Asset();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
