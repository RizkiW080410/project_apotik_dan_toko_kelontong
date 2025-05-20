<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'management_obat_access',
            ],
            [
                'id'    => 18,
                'title' => 'golongan_create',
            ],
            [
                'id'    => 19,
                'title' => 'golongan_edit',
            ],
            [
                'id'    => 20,
                'title' => 'golongan_show',
            ],
            [
                'id'    => 21,
                'title' => 'golongan_delete',
            ],
            [
                'id'    => 22,
                'title' => 'golongan_access',
            ],
            [
                'id'    => 23,
                'title' => 'jenis_create',
            ],
            [
                'id'    => 24,
                'title' => 'jenis_edit',
            ],
            [
                'id'    => 25,
                'title' => 'jenis_show',
            ],
            [
                'id'    => 26,
                'title' => 'jenis_delete',
            ],
            [
                'id'    => 27,
                'title' => 'jenis_access',
            ],
            [
                'id'    => 28,
                'title' => 'obat_create',
            ],
            [
                'id'    => 29,
                'title' => 'obat_edit',
            ],
            [
                'id'    => 30,
                'title' => 'obat_show',
            ],
            [
                'id'    => 31,
                'title' => 'obat_delete',
            ],
            [
                'id'    => 32,
                'title' => 'obat_access',
            ],
            [
                'id'    => 34,
                'title' => 'management_pesanan_access',
            ],
            [
                'id'    => 35,
                'title' => 'pengajuan_create',
            ],
            [
                'id'    => 36,
                'title' => 'pengajuan_edit',
            ],
            [
                'id'    => 37,
                'title' => 'pengajuan_show',
            ],
            [
                'id'    => 38,
                'title' => 'pengajuan_delete',
            ],
            [
                'id'    => 39,
                'title' => 'pengajuan_access',
            ],
            [
                'id'    => 40,
                'title' => 'pesanan_create',
            ],
            [
                'id'    => 41,
                'title' => 'pesanan_edit',
            ],
            [
                'id'    => 42,
                'title' => 'pesanan_show',
            ],
            [
                'id'    => 43,
                'title' => 'pesanan_delete',
            ],
            [
                'id'    => 44,
                'title' => 'pesanan_access',
            ],
            [
                'id'    => 45,
                'title' => 'pesanan_item_create',
            ],
            [
                'id'    => 46,
                'title' => 'pesanan_item_edit',
            ],
            [
                'id'    => 47,
                'title' => 'pesanan_item_show',
            ],
            [
                'id'    => 48,
                'title' => 'pesanan_item_delete',
            ],
            [
                'id'    => 49,
                'title' => 'pesanan_item_access',
            ],
            [
                'id'    => 50,
                'title' => 'management_pengiriman_access',
            ],
            [
                'id'    => 51,
                'title' => 'pengirim_create',
            ],
            [
                'id'    => 52,
                'title' => 'pengirim_edit',
            ],
            [
                'id'    => 53,
                'title' => 'pengirim_show',
            ],
            [
                'id'    => 54,
                'title' => 'pengirim_delete',
            ],
            [
                'id'    => 55,
                'title' => 'pengirim_access',
            ],
            [
                'id'    => 56,
                'title' => 'pengiriman_create',
            ],
            [
                'id'    => 57,
                'title' => 'pengiriman_edit',
            ],
            [
                'id'    => 58,
                'title' => 'pengiriman_show',
            ],
            [
                'id'    => 59,
                'title' => 'pengiriman_delete',
            ],
            [
                'id'    => 60,
                'title' => 'pengiriman_access',
            ],
            [
                'id'    => 61,
                'title' => 'profile_create',
            ],
            [
                'id'    => 62,
                'title' => 'profile_edit',
            ],
            [
                'id'    => 63,
                'title' => 'profile_show',
            ],
            [
                'id'    => 64,
                'title' => 'profile_delete',
            ],
            [
                'id'    => 65,
                'title' => 'profile_access',
            ],
            [
                'id'    => 66,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
