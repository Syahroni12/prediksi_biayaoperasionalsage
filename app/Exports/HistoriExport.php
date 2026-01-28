<?php

namespace App\Exports;

use App\Models\Prediksi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

class HistoriExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithChunkReading,
    WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $exportedBy;

    public function __construct($startDate, $endDate, $exportedBy)
    {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->exportedBy = $exportedBy;
    }

    /** 🔥 Query (tidak load semua data) */
    public function query()
    {
        return Prediksi::with('user', 'varietas')
            ->whereBetween('tanggal_tanam', [
                $this->startDate,
                $this->endDate
            ])
            ->orderBy('tanggal_tanam');
    }

    /** 🔥 Chunk untuk data besar */
    public function chunkSize(): int
    {
        return 1000;
    }

    /** Header kolom */
    public function headings(): array
    {
        return [
            'Nama User',
            'Kabupaten',
            "Kecamatan",
            "Desa",
            "Rata Rata Suhu (°C)",
            "Rata Rata Curah Hujan (mm)",
            "Estimasi Tanggal Panen",
            'Luas Lahan (Ha)',
            'Estimasi Hasil Panen (Kg)',
            'Harga Beli Petani',
            "Estimasi Total Pembayaran",
            "Varietas",
            'Estimasi Umur Tanam (Hari)',

            'Tanggal Tanam',
            'Tanggal Export'
        ];
    }

    /** Mapping isi row */
    public function map($row): array
    {
        return [
            $row->user->name ?? '-',
            $row->kabupaten,
            $row->kecamatan,
            $row->desa,
            $row->mean_suhu,
            $row->mean_hujan,
            $row->tanggal_panen,
            $row->luas_lahan,

            $row->estimasi_panen,
            $row->harga_beli,
            $row->estimasi_pembayaran,
            $row->varietas->varietas ?? '-',
            $row->umur_tanaman,
            $row->tanggal_tanam,
            now()->format('d-m-Y'),
        ];
    }

    /** Judul report di Excel */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

                // Tambah 4 baris di atas
                $event->sheet->insertNewRowBefore(1, 4);

                $event->sheet->setCellValue('A1', 'REPORT HISTORI PREDIKSI PANEN');
                $event->sheet->setCellValue(
                    'A2',
                    'Tanggal Tanam: ' . $this->startDate . ' s/d ' . $this->endDate
                );
                $event->sheet->setCellValue(
                    'A3',
                    'Diexport oleh: ' . $this->exportedBy
                );

                $event->sheet->mergeCells('A1:F1');
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A2:A3')->getFont()->setItalic(true);
            }
        ];
    }
}
