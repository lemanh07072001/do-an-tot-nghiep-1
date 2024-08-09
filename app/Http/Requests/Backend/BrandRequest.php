<?php

namespace App\Http\Requests\Backend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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

        if (!empty(request()->route()->brand->id)) {
            $id = request()->route()->brand->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $id],
                    'slug' => ['required', 'string', 'max:255'],
                    'image' => ['required']
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
                    'slug' => ['required', 'string', 'max:255'],
                    'image' => ['required']
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

            'image.required' => ':attribute không được để trống',

        ];
    }

    public function attributes(): array
    {
        return [
            'slug' => 'Slug',
            'name' => 'Tên tiêu đề',
            'image' => 'Hình ảnh',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
