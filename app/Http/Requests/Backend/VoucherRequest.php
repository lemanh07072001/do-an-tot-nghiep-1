<?php

namespace App\Http\Requests\Backend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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

        if (!empty(request()->route()->voucher->id)) {
            $id = request()->route()->voucher->id;
        }

        if (!empty($id)) {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:vouchers,name,' . $id],
                   'value_reduction' => ['required', 'string', 'max:255', function ($attr, $value, $err) {
                        if (request()->input('discount_type') == '%') {
                            if ($value > 100) {
                                $err('Giá trị giảm phải nhỏ hơn hoặc bằng 100%');
                            }
                        } elseif (request()->input('discount_type') == 'vnd') {
                            if (!is_numeric($value) || intval($value) != $value) {
                                $err('Giá trị giảm phải là số nguyên');
                            }
                        }
                    }],
                    'limit' => ['nullable', 'integer'],
                    'date_start' => ['nullable'],
                    'date_end' => ['nullable',],
                ];
        } else {
            $rule =
                [
                    'name' => ['required', 'string', 'max:255', 'unique:banners,name'],
                    'value_reduction' => ['required', 'string', 'max:255', function ($attr, $value, $err) {
                        if (request()->input('discount_type') == '%') {
                            if ($value > 100) {
                                $err('Giá trị giảm phải nhỏ hơn hoặc bằng 100%');
                            }
                        } elseif (request()->input('discount_type') == 'vnd') {
                            if (!is_numeric($value) || intval($value) != $value) {
                                $err('Giá trị giảm phải là số nguyên');
                            }
                        }
                    }],
                    'limit' => ['nullable', 'integer'],
                    'date_start' => ['nullable'],
                    'date_end' => ['nullable',],
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

            'value_reduction.required' => ':attribute không được để trống',
            'value_reduction.string' => ':attribute phải là một chuỗi',
            'value_reduction.max' => ':attribute không được quá :max ký tự',

            'limit.integer' => ':attribute phải là kiểu số nguyên',

        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Mã code',
            'slug' => 'Slug',
            'value_reduction' => 'Giá trị',
            'limit' => 'Lược sử dụng',
            'date_start' => 'Ngày bắt đầu',
            'date_end' => 'Ngày kết thúc',

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
}
