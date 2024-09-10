<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PolicyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = null;

        if (!empty(request()->route()->label->id)) {
            $id = request()->route()->label->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:policys,name,' . $id],
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:policys,name'],
                ];
        };

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute không được để trống',
            'name.max' => ':attribute không được quá :max ký tự',
            'name.string' => ':attribute phải là một chuỗi',
            'name.unique' => ':attribute đã tồn tại trong hệ thống',


        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tiêu đề',
        ];
    }
}
