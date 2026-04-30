<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class QuestionsTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [
            [
                'Python’da lug‘at (dictionary) nima?',
                'Tartiblangan ro‘yxat',
                'Indeks asosida ishlovchi tuzilma',
                'Kalit-qiymat juftligidan iborat to‘plam',
                'Faqat sonlar saqlovchi tuzilma',
                'C'
            ],
            [
                'Lug‘at elementiga qanday murojaat qilinadi?',
                'Indeks orqali',
                'Kalit orqali',
                'Faqat sikl orqali',
                'Funksiya orqali',
                'B'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Savol matni',
            'Variant A',
            'Variant B',
            'Variant C',
            'Variant D',
            'To\'g\'ri javob (A, B, C yoki D)'
        ];
    }

    public function title(): string
    {
        return 'Savollar shabloni';
    }
}
