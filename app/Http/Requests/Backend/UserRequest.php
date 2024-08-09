<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        if (!empty(request()->route()->user->id)) {
            $id = request()->route()->user->id;
        }

        if (!empty($id)) {
            $rule = [
                'email' => ['required', 'email', 'string', 'unique:users,email,' . $id],
                'name' => ['required', 'string'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['nullable', 'string', 'min:8'],
            ];
        } else {
            $rule = [
                'email' => ['required', 'email', 'string', 'unique:users,email'],
                'name' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:8'],
            ];
        };

        return $rule;
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute phải là một email hợp lệ',
            'email.string' => ':attribute phải là một chuỗi',
            'email.unique' => ':attribute đã tồn tại trong hệ thống',

            'name.required' => ':attribute không được để trống',
            'name.string' => ':attribute phải là một chuỗi',
            'name.string' => ':attribute phải là một chuỗi',

            'password.required' => ':attribute không được để trống',
            'password.string' => ':attribute phải là một chuỗi',
            'password.min' => ':attribute phải lớn hơn :min ký tự',
            'password.confirmed' => ':attribute không trùng nhau',

            'password_confirmation.required' => ':attribute không được để trống',
            'password_confirmation.string' => ':attribute phải là một chuỗi',
            'password_confirmation.min' => ':attribute phải lớn hơn :min ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'name' => 'Họ tên',
            'password' => 'Mật khẩu',
            'password_confirmation' => 'Nhập lại mật khẩu',
        ];
    }
}