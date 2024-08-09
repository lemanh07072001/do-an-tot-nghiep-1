<?php

namespace App\Http\Requests\Backend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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

        if (!empty(request()->route()->banner->id)) {
            $id = request()->route()->banner->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:banners,name,' . $id],
                    'slug' => ['required', 'string', 'max:255'],
                    'link' => ['nullable', 'url'],
                    'date_start' => ['nullable'],
                    'date_end' => ['nullable',],
                    'image' => ['required']
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:banners,name'],
                    'slug' => ['required', 'string', 'max:255'],
                    'link' => ['nullable', 'url'],
                    'date_start' => ['nullable',],
                    'date_end' => ['nullable',],
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

            'link.url' => ':attribute không đúng định dạng',

            'image.required' => ':attribute không được để trống',

        ];
    }

    public function attributes(): array
    {
        return [
            'slug' => 'Slug',
            'name' => 'Tên tiêu đề',
            'link' => 'Đường dẫn',
            'date_start' => 'Ngày bắt đầu',
            'date_end' => 'Ngày kết thúc',
            'image' => 'Hình ảnh',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('date_start') && $this->filled('date_end')) {
                if (strtotime($this->input('date_end')) < strtotime($this->input('date_start'))) {

                    $validator->errors()->add('date_end', 'Ngày kết thúc phải lớn hơn ngày bắt đầu.');
                }
            }
        });
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
