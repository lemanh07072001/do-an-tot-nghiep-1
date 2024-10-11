<?php

namespace App\Http\Requests\Backend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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

        if (!empty(request()->route()->categories->id)) {
            $id = request()->route()->categories->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
                    'slug' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
                    'slug' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
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

            'description.string' => ':attribute phải là một chuỗi',

            'order.required' => ':attribute không được để trống',
            'order.max' => ':attribute không được quá :max ký tự',
            'order.min' => ':attribute không được nhỏ hơn :min ký tự',
            'order.integer' => ':attribute phải là số nguyên',
        ];
    }

    public function attributes(): array
    {
        return [
            'slug' => 'Slug',
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'order' => 'Thứ tự',
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
