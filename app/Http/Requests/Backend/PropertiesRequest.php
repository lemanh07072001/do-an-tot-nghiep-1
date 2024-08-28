<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PropertiesRequest extends FormRequest
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

        if (!empty(request()->route()->properties->id)) {
            $id = request()->route()->properties->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:properties,name,' . $id],
                    'slug' => ['required', 'string', 'max:255'],
                    'parent_id' => ['nullable', 'string'],
                    'value' => ['nullable', 'string',function ($attribute, $value, $fail) {
                        if ($this->input('parent_id') === null && $value !== null) {
                            $fail('Cột value không được nhập khi thuộc tính cha là --root--.');
                        }
                    }],
                    'status' => ['required', ]
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:properties,name'],
                    'slug' => ['required', 'string', 'max:255'],
                    'parent_id' => ['nullable', 'string'],
                    'value' => ['nullable', 'string',function ($attribute, $value, $fail) {
                        if ($this->input('parent_id') === null && $value !== null) {
                            $fail('Cột value không được nhập khi thuộc tính cha là --root--.');
                        }
                    }],
                    'status' => ['required', ]
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

            'slug.required' => ':attribute không được để trống',
            'slug.string' => ':attribute phải là một chuỗi',
            'slug.max' => ':attribute không được quá :max ký tự',

            'parent_id.string' => ':attribute phải là một chuỗi',

            'status.required' => ':attribute không được để trống',


        ];
    }

    public function attributes(): array
    {
        return [
            'slug' => 'Slug',
            'name' => 'Tiêu đề',
            'parent_id' => 'Thuộc tính cha',
            'status' => 'Trạng thái',

        ];
    }

}
