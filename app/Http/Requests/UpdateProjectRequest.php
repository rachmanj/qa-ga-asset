<?php

namespace App\Http\Requests;

use App\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('project_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'code'      => [
                'string',
                'required',
                'unique:projects,code,' . request()->route('project')->id,
            ],
            'location'  => [
                'string',
                'required',
            ],
            'bowheer'   => [
                'string',
                'required',
            ],
            'is_active' => [
                'required',
            ],
        ];
    }
}
