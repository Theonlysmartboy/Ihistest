<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOurPatientsRequest extends FormRequest
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
            'huduma_no' => 'required|unique:our_patients,huduma_no,'.$this->route('our_patient'),
            'dob' => 'required|date_format:'.config('app.date_format').' H:i:s|unique:our_patients,dob',
            'email' => 'email',
            'photo' => 'nullable|mimes:png,jpg,jpeg,gif',
            'diagnostic' => 'required',
            'prescription' => 'required',
        ];
    }
}
