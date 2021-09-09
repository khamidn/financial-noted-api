<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\{ FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles };
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with('user', 'account', 'category', 'sub_category', 'tag')->get();
    }

    public function map($transactions) : array {
        return [
            $transactions->id,
            $transactions->user->name,
            $transactions->tanggal,
            $transactions->nominal,
            $transactions->keterangan,
            $transactions->account->name,
            $transactions->category->name,
            $transactions->sub_category->name,
            $transactions->tag->name,
        ];
    }

    public function headings() : array {
        return [
            '#',
            'Name User',
            'Tanggal',
            'Nominal',
            'Keterangan',
            'Name Akun',
            'Kategori',
            'Sub Kategori',
            'Tag',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 10,
            'D' => 30,
            'E' => 50,
            'F' => 30,
            'G' => 30,
            'H' => 20,
            'I' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
