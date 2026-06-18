<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BeneficiarySummaryExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $rows = [];

        $grouped = collect($this->reportData)->groupBy('province');

        foreach ($grouped as $province => $districts) {
            foreach ($districts as $row) {

                $rows[] = [
                    $province,
                    $row['district'],
                    $row['total_classes'],
                    $row['boys_no_disability'],
                    $row['girls_no_disability'],
                    $row['boys_disability'],
                    $row['girls_disability'],
                    $row['male_teachers'],
                    $row['female_teachers'],
                    $row['total_sms'],
                    $row['male_sms_members'],
                    $row['female_sms_members'],
                ];

                $province = '';
            }
        }

        // footer rows (3)
        $rows[] = ['TOTAL', '', '', '', '', '', '', '', '', '', '', ''];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', '', ''];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', '', ''];

        return $rows;
    }

    public function headings(): array
    {
        return [
            ['AKF - PROJECT BENEFICIARY SUMMARY TABLE'],
            [
                'Province',
                'District',
                'Total Classes',
                'Students',
                '',
                '',
                '',
                'Teachers',
                '',
                'SMS',
                'SMS Members',
                ''
            ],
            [
                '',
                '',
                '',
                'Normal Boys',
                'Normal Girls',
                'Disabled Boys',
                'Disabled Girls',
                'Male',
                'Female',
                '',
                'Male',
                'Female'
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $lastRow = $sheet->getHighestRow();

                $dataLastRow = count($this->reportData) + 3;

                // TITLE
                $sheet->mergeCells('A1:L1');
                $sheet->setCellValue('A1', 'AKF PROJECT BENEFICIARY SUMMARY TABLE');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // HEADER
                $sheet->mergeCells('A2:A3');
                $sheet->mergeCells('B2:B3');
                $sheet->mergeCells('C2:C3');
                $sheet->mergeCells('D2:G2');
                $sheet->mergeCells('H2:I2');
                $sheet->mergeCells('J2:J3');
                $sheet->mergeCells('K2:L2');

                $sheet->getStyle('A2:L3')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9D9D9'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                foreach (range('A', 'L') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(15);
                }

                $sheet->getColumnDimension('A')->setWidth(18);
                $sheet->getColumnDimension('B')->setWidth(22);

                $sheet->getStyle("A1:L{$lastRow}")->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_THICK],
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle("A1:L{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // ================= PROVINCE MERGE =================
                $startRow = 4;
                $currentProvince = null;
                $provinceStart = $startRow;

                for ($row = $startRow; $row <= $dataLastRow; $row++) {

                    $province = $sheet->getCell("A{$row}")->getValue();

                    if (!empty($province) && $province !== $currentProvince) {

                        if ($currentProvince !== null) {
                            $end = $row - 1;
                            if ($provinceStart <= $end) {
                                $sheet->mergeCells("A{$provinceStart}:A{$end}");
                            }
                        }

                        $currentProvince = $province;
                        $provinceStart = $row;
                    }
                }

                if ($currentProvince !== null) {
                    $end = $dataLastRow;
                    if ($provinceStart <= $end) {
                        $sheet->mergeCells("A{$provinceStart}:A{$end}");
                    }
                }

                // ================= FOOTER =================
                $row1 = $dataLastRow + 1;
                $row2 = $dataLastRow + 2;
                $row3 = $dataLastRow + 3;

                $nb = $ng = $db = $dg = 0;
                $mt = $ft = 0;
                $smsM = $smsF = 0;
                $classes = 0;

                for ($r = 4; $r <= $dataLastRow; $r++) {

                    $classes += (int)$sheet->getCell("C$r")->getValue();
                    $nb += (int)$sheet->getCell("D$r")->getValue();
                    $ng += (int)$sheet->getCell("E$r")->getValue();
                    $db += (int)$sheet->getCell("F$r")->getValue();
                    $dg += (int)$sheet->getCell("G$r")->getValue();
                    $mt += (int)$sheet->getCell("H$r")->getValue();
                    $ft += (int)$sheet->getCell("I$r")->getValue();
                    $smsM += (int)$sheet->getCell("K$r")->getValue();
                    $smsF += (int)$sheet->getCell("L$r")->getValue();
                }

                $normal = $nb + $ng;
                $disabled = $db + $dg;
                $students = $normal + $disabled;
                $teachers = $mt + $ft;
                $smsMembers = $smsM + $smsF;

                $sheet->mergeCells("A{$row1}:B{$row3}");
                $sheet->setCellValue("A{$row1}", "TOTAL");

                $sheet->mergeCells("C{$row1}:C{$row3}");
                $sheet->setCellValue("C{$row1}", $classes);

                $sheet->setCellValue("D{$row1}", $nb);
                $sheet->setCellValue("E{$row1}", $ng);
                $sheet->setCellValue("F{$row1}", $db);
                $sheet->setCellValue("G{$row1}", $dg);

                $sheet->mergeCells("D{$row2}:E{$row2}");
                $sheet->mergeCells("F{$row2}:G{$row2}");
                $sheet->setCellValue("D{$row2}", $normal);
                $sheet->setCellValue("F{$row2}", $disabled);

                $sheet->mergeCells("D{$row3}:G{$row3}");
                $sheet->setCellValue("D{$row3}", $students);

                $sheet->setCellValue("H{$row1}", $mt);
                $sheet->setCellValue("I{$row1}", $ft);

                $sheet->mergeCells("H{$row2}:I{$row3}");
                $sheet->setCellValue("H{$row2}", $teachers);

                $sheet->mergeCells("J{$row1}:J{$row3}");
                $sheet->setCellValue("J{$row1}", $smsM + $smsF);

                $sheet->setCellValue("K{$row1}", $smsM);
                $sheet->setCellValue("L{$row1}", $smsF);

                $sheet->mergeCells("K{$row2}:L{$row3}");
                $sheet->setCellValue("K{$row2}", $smsMembers);

                // style footer
                $sheet->getStyle("A{$row1}:L{$row3}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'BFBFBF'],
                    ],
                ]);

                $sheet->getStyle("A{$row1}:L{$row3}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // ================= FIX FOOTER BORDERS =================
                $sheet->getStyle("A{$row1}:L{$row3}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}