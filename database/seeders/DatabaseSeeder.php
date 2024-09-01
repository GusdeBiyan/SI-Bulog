<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Biaya;
use App\Models\Kecamatan;
use App\Models\Gudang;
use App\Models\User;
use App\Models\Permintaan;
use App\Models\UserKec;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Buat hash password menggunakan bcrypt
        $hashedPassword = Hash::make('12345678');

        // Tambahkan pengguna dengan hash password ke database

        UserKec::create([
            'id_kecamatan' => '1',
            'nama_penanggung_jawab' => 'Gusde Biyan Ambarista',
            'username' => 'Wuluhan',
            'email' => 'wuluhan@example.com',
            'password' => $hashedPassword,
        ]);

        UserKec::create([
            'id_kecamatan' => '2',
            'nama_penanggung_jawab' => 'Bahrul Aji Santoso',
            'username' => 'Kencong',
            'email' => 'kencong@example.com',
            'password' => $hashedPassword,
        ]);

        UserKec::create([
            'id_kecamatan' => '3',
            'nama_penanggung_jawab' => 'Danu Wicaksono',
            'username' => 'Jenggawah',
            'email' => 'jenggawah@example.com',
            'password' => $hashedPassword,
        ]);

        UserKec::create([
            'id_kecamatan' => '4',
            'nama_penanggung_jawab' => 'M Rokhis',
            'username' => 'Arjasa',
            'email' => 'arjasa@example.com',
            'password' => $hashedPassword,
        ]);

        UserKec::create([
            'id_kecamatan' => '5',
            'nama_penanggung_jawab' => 'Adam Hafids',
            'username' => 'Tempurejo',
            'email' => 'tempurejo@example.com',
            'password' => $hashedPassword,
        ]);

        // Permintaan::create([
        //     'id_kecamatan' => '1',
        //     'id_user_kec' => '1',
        //     'data_permintaan' => '',
        //     'jumlah_permintaan_beras' => '',
        //     'jumlah_rts' => '',
        // ]);



        User::create([
            'name' => 'John Doe',
            'username' => 'Jhondoe',

            'password' => $hashedPassword,

        ]);

        User::create([
            'name' => 'Suyatno',
            'username' => 'suyatno',

            'password' => $hashedPassword,

        ]);




        Gudang::create([
            'nama_gudang' => 'Gudang Mangli',
            'lokasi' => 'Mangli',
            'kapasitas' => '101460'
        ]);

        Gudang::create([
            'nama_gudang' => 'Gudang Kertosari',
            'lokasi' => 'Kertosari',
            'kapasitas' => '126500'
        ]);
        Gudang::create([
            'nama_gudang' => 'Gudang Percoro',
            'lokasi' => 'Percoro',
            'kapasitas' => '125500'
        ]);
        Gudang::create([
            'nama_gudang' => 'Gudang Jambearum',
            'lokasi' => 'Jambearum',
            'kapasitas' => '186200'
        ]);
        Gudang::create([
            'nama_gudang' => 'Gudang Yosorati',
            'lokasi' => 'Yosorati',
            'kapasitas' => '134530'
        ]);


        Kecamatan::create([
            'nama_kecamatan' => 'Wuluhan',
            'Kebutuhan_beras' => '137025',
            'jumlah_penerima' => '3045'
        ]);

        Kecamatan::create([
            'nama_kecamatan' => 'Kencong',
            'Kebutuhan_beras' => '71010',
            'jumlah_penerima' => '1578'
        ]);
        Kecamatan::create([
            'nama_kecamatan' => 'Jenggawah',
            'Kebutuhan_beras' => '145260',
            'jumlah_penerima' => '3228'
        ]);
        Kecamatan::create([
            'nama_kecamatan' => 'Arjasa',
            'Kebutuhan_beras' => '131715',
            'jumlah_penerima' => '2927'
        ]);
        Kecamatan::create([
            'nama_kecamatan' => 'Tempurejo',
            'Kebutuhan_beras' => '189180',
            'jumlah_penerima' => '4204'
        ]);


        Biaya::create([
            'id_gudang' => '1',
            'id_kecamatan' => '1',
            'jarak' => '22',
            'biaya_pengiriman' => '54'
        ]);

        Biaya::create([
            'id_gudang' => '1',
            'id_kecamatan' => '2',
            'jarak' => '40',
            'biaya_pengiriman' => '70'
        ]);

        Biaya::create([
            'id_gudang' => '1',
            'id_kecamatan' => '3',
            'jarak' => '13',
            'biaya_pengiriman' => '44'
        ]);

        Biaya::create([
            'id_gudang' => '1',
            'id_kecamatan' => '4',
            'jarak' => '16',
            'biaya_pengiriman' => '45'
        ]);

        Biaya::create([
            'id_gudang' => '1',
            'id_kecamatan' => '5',
            'jarak' => '33',
            'biaya_pengiriman' => '63'
        ]);

        Biaya::create([
            'id_gudang' => '2',
            'id_kecamatan' => '1',
            'jarak' => '36',
            'biaya_pengiriman' => '68'
        ]);

        Biaya::create([
            'id_gudang' => '2',
            'id_kecamatan' => '2',
            'jarak' => '55',
            'biaya_pengiriman' => '85'
        ]);

        Biaya::create([
            'id_gudang' => '2',
            'id_kecamatan' => '3',
            'jarak' => '22',
            'biaya_pengiriman' => '54'
        ]);

        Biaya::create([
            'id_gudang' => '2',
            'id_kecamatan' => '4',
            'jarak' => '12',
            'biaya_pengiriman' => '43'
        ]);

        Biaya::create([
            'id_gudang' => '2',
            'id_kecamatan' => '5',
            'jarak' => '35',
            'biaya_pengiriman' => '68'
        ]);

        Biaya::create([
            'id_gudang' => '3',
            'id_kecamatan' => '1',
            'jarak' => '16',
            'biaya_pengiriman' => '48'
        ]);

        Biaya::create([
            'id_gudang' => '3',
            'id_kecamatan' => '2',
            'jarak' => '35',
            'biaya_pengiriman' => '66'
        ]);

        Biaya::create([
            'id_gudang' => '3',
            'id_kecamatan' => '3',
            'jarak' => '16',
            'biaya_pengiriman' => '48'
        ]);

        Biaya::create([
            'id_gudang' => '3',
            'id_kecamatan' => '4',
            'jarak' => '22',
            'biaya_pengiriman' => '54'
        ]);

        Biaya::create([
            'id_gudang' => '3',
            'id_kecamatan' => '5',
            'jarak' => '36',
            'biaya_pengiriman' => '69'
        ]);

        Biaya::create([
            'id_gudang' => '4',
            'id_kecamatan' => '1',
            'jarak' => '10',
            'biaya_pengiriman' => '40'
        ]);
        Biaya::create([
            'id_gudang' => '4',
            'id_kecamatan' => '2',
            'jarak' => '17',
            'biaya_pengiriman' => '48'
        ]);
        Biaya::create([
            'id_gudang' => '4',
            'id_kecamatan' => '3',
            'jarak' => '18',
            'biaya_pengiriman' => '49'
        ]);
        Biaya::create([
            'id_gudang' => '4',
            'id_kecamatan' => '4',
            'jarak' => '38',
            'biaya_pengiriman' => '68'
        ]);
        Biaya::create([
            'id_gudang' => '4',
            'id_kecamatan' => '5',
            'jarak' => '34',
            'biaya_pengiriman' => '67'
        ]);

        Biaya::create([
            'id_gudang' => '5',
            'id_kecamatan' => '1',
            'jarak' => '33',
            'biaya_pengiriman' => '65'
        ]);
        Biaya::create([
            'id_gudang' => '5',
            'id_kecamatan' => '2',
            'jarak' => '21',
            'biaya_pengiriman' => '53'
        ]);
        Biaya::create([
            'id_gudang' => '5',
            'id_kecamatan' => '3',
            'jarak' => '40',
            'biaya_pengiriman' => '70'
        ]);
        Biaya::create([
            'id_gudang' => '5',
            'id_kecamatan' => '4',
            'jarak' => '48',
            'biaya_pengiriman' => '75'
        ]);
        Biaya::create([
            'id_gudang' => '5',
            'id_kecamatan' => '5',
            'jarak' => '60',
            'biaya_pengiriman' => '90'
        ]);
    }
}
