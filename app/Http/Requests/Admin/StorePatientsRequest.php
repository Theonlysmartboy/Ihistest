<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'huduma_no' => 'required|unique:patients,huduma_no,'.$this->route('patient'),
            'dob' => 'required|date_format:'.config('app.date_format').' H:i:s|unique:patients,dob',
            'email' => 'email',
            'photo' => 'nullable|mimes:png,jpg,jpeg,gif',
            'diagnostic' => 'required',
            'prescription' => 'required',
        ];
    }
}
