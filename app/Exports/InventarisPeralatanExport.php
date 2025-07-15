<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\FasilitasPrasarana;

class InventarisPeralatanExport implements WithTitle, FromCollection, ShouldAutoSize
{
    // protected $id;

    // public function __construct(String $id)
    // {
    //     $this->id = $id;
    // }

    public function collection()
    {
        $data[0] = ['No', 'Nama', 'Kondisi', 'Tanggal Inspeksi', 'Editor', 'Validator', 'Dokumen Inspeksi'];
        $index = 1;
        foreach(FasilitasPrasarana::get() as $dtdb){
            $data[$index++] = [
                (string) $index-1,
                (string) $dtdb->nama,
                (string) $dtdb->kondisi,
                (string) date("d M Y", strtotime($dtdb->tanggal_inspeksi)),
                (string) $dtdb->editor()->name,
                (string) $dtdb->validator() ? $dtdb->validator()->name : '-',
                (string) env('APP_URL').$dtdb->dokumen_inspeksi,
            ];
        }
        return collect($data);
    }
    public function title(): string
    {
        return 'Fasilitas Prasarana';
    }
}
