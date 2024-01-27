<?php

namespace App\MyClass;

class Validations
{
    public static function userValidation($request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email Sudah Digunakan',
                'email.email' => 'Email Tidak Valid',
                'password.required' => 'Password tidak boleh kosong',
                'password.confirmed' => 'Password tidak sama',
                'role.required' => 'Role tidak boleh kosong',
            ]
        );
    }

    public static function userEditValidation($request, $userId)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $userId,
                'password' => 'nullable|confirmed',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email sudah digunakan',
                'email.email' => 'Email Tidak Valid',
                'password.confirmed' => 'Password tidak sama',
                'role.required' => 'Role tidak boleh kosong',
            ]
        );
    }

    public static function campaignValidation($request)
    {
        $request->validate(
            [
                'campaign_name' => 'required',
            ],
            [
                'campaign_name.required' => 'Nama Campaign tidak boleh kosong',
            ]
        );
    }

    public static function campaignEditValidation($request)
    {
        $request->validate(
            [
                'campaign_name' => 'required',
                'message' => 'required',
            ],
            [
                'campaign_name.required' => 'Nama Campaign tidak boleh kosong',
                'message.required' => 'Pesan tidak boleh kosong',
            ]
        );
    }

    public static function campaignTargetValidation($request)
    {
        $request->validate(
            [
                'id_campaign' => 'required',
                'file_excel' => 'required|file|mimes:xlsx,xls',
            ],
            [
                'id_campaign.required' => 'Pilih salah satu Campaign',
                'file_excel.required' => 'File Excel Tidak Boleh Kosong',
                'file_excel.file' => 'File Excel Tidak Valid',
                'file_excel.mimes' => 'File harus berformat .xlsx, .xls',
            ]
        );
    }
}
