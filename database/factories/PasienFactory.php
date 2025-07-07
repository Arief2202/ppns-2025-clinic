<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pasien;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kelamin = ['Laki Laki', 'Perempuan'];
        $bagian = [
            'Teknik K3',
            'Kelistrikan',
            'Design dan Manufaktur',
            'Teknik Perpipaan',
            'Teknik Pengelasan',
            'Teknik Bangunan Kapal',
            'Teknik Mesin',
            'Teknik Pengolahan Limbah',
            'Teknik Otomasi',
            'Manajemen Bisnis',
        ];
        return [
            'nip' => $this->generateRandomNIP(),
            'nama' => fake()->name(),
            'tanggal_lahir' => fake()->dateTimeBetween('-35 year', '-25 year'),
            'jenis_kelamin' => $kelamin[rand(0, 1)],
            'bagian' => $bagian[rand(0, 9)],
            'tanggal_registrasi' => fake()->dateTimeBetween('-10 month', '-1 month'),
        ];
    }
    public function generateRandomNIP(){
        $num = rand(1000000000, 99999999999);
        if($this->checkNIP($num)) return $this->generateRandomNIP();
        return $num;

    }
    public function checkNIP($nip){
        if(Pasien::where('nip', $nip)->first()) return 1;
        else return 0;
    }
}
