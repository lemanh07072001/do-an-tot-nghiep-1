<?php

namespace App\Http\Requests\Backend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

        if (!empty(request()->route()->products->id)) {
            $id = request()->route()->products->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:products,name,'.$id],
                    'slug' => ['required', 'string', 'max:255'],
                    'images' => ['required'],
                    'avatar' => ['required'],
                    'sku' => ['required', 'unique:products,sku,'.$id],
                    'price' => ['required'],
                    'categories_id' => ['required'],
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:products,name'],
                    'slug' => ['required', 'string', 'max:255'],
                    'images' => ['required'],
                    'avatar' => ['required'],
                    'sku' => ['required', 'unique:products,sku'],
                    'price' => ['required'],
                    'categories_id' => ['required'],
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

            'images.required' => ':attribute không được để trống',

            'avatar.required' => ':attribute không được để trống',

            'sku.required' => ':attribute không được để trống',
            'sku.unique' => ':attribute đã tồn tại trong hệ thống',

            'price.required' => ':attribute không được để trống',

            'categories_id.required' => ':attribute không được để trống',

        ];
    }

    public function attributes(): array
    {
        return [
            'slug' => 'Slug',
            'name' => 'Tiêu đề',
            'images' => 'Hình ảnh',
            'avatar' => 'Ảnh đại diện',
            'price' => 'Giá tiền',

            'categories_id' => 'Danh mục',

        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
