<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Maybe there are some use cases, when it is wiser to perform authorization here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title' => 'required|max:255|unique:reports' . ($this->report ? (',title,' . $this->report->title . ',title') : ''),
            'body' => 'required',
            'vehicle_id' => 'required',
            'injured_count' => 'required|numeric',
            'happened_at' => 'required|date|nullable',

        ];




    }
}
