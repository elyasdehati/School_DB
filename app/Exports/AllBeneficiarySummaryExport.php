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

class AllBeneficiarySummaryExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $rows = [];

        $grouped = collect($this->reportData)->groupBy('project');

        foreach ($grouped as $project => $projectRows) {
            foreach ($projectRows->groupBy('province') as $province => $districtRows) {
                foreach ($districtRows as $row) {
                    $rows[] = [
                        $project,
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

                    $project = '';
                    $province = '';
                }
            }
        }

        // footer rows
        $rows[] = ['TOTAL', '', '', '', '', '', '', '', '', '', '', '', ''];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];
        $rows[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        return $rows;
    }

    public function headings(): array
    {
        return [
            ['All Projects Beneficiary Summary Report'],
            [
                'Project',
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
                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'All Projects Beneficiary Summary Report');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // HEADER MERGE
                $sheet->mergeCells('A2:A3');
                $sheet->mergeCells('B2:B3');
                $sheet->mergeCells('C2:C3');
                $sheet->mergeCells('D2:D3');
                $sheet->mergeCells('E2:H2');
                $sheet->mergeCells('I2:J2');
                $sheet->mergeCells('K2:K3');
                $sheet->mergeCells('L2:M2');

                $sheet->getStyle('A2:M3')->applyFromArray([
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

                foreach (range('A', 'M') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(15);
                }

                $sheet->getColumnDimension('A')->setWidth(25);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(20);

                $sheet->getStyle("A1:M{$lastRow}")->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_THICK],
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle("A1:M{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // ================= PROJECT MERGE =================
                $startRow = 4;
                $currentProject = null;
                $projectStart = $startRow;

                for ($row = $startRow; $row <= $dataLastRow; $row++) {
                    $project = $sheet->getCell("A{$row}")->getValue();

                    if (!empty($project) && $project !== $currentProject) {
                        if ($currentProject !== null) {
                            $end = $row - 1;
                            if ($projectStart <= $end) {
                                $sheet->mergeCells("A{$projectStart}:A{$end}");
                            }
                        }

                        $currentProject = $project;
                        $projectStart = $row;
                    }
                }

                if ($currentProject !== null) {
                    $end = $dataLastRow;
                    if ($projectStart <= $end) {
                        $sheet->mergeCells("A{$projectStart}:A{$end}");
                    }
                }

                // ================= PROVINCE MERGE =================
                $currentProvince = null;
                $provinceStart = $startRow;

                for ($row = $startRow; $row <= $dataLastRow; $row++) {
                    $province = $sheet->getCell("B{$row}")->getValue();

                    if (!empty($province) && $province !== $currentProvince) {
                        if ($currentProvince !== null) {
                            $end = $row - 1;
                            if ($provinceStart <= $end) {
                                $sheet->mergeCells("B{$provinceStart}:B{$end}");
                            }
                        }

                        $currentProvince = $province;
                        $provinceStart = $row;
                    }
                }

                if ($currentProvince !== null) {
                    $end = $dataLastRow;
                    if ($provinceStart <= $end) {
                        $sheet->mergeCells("B{$provinceStart}:B{$end}");
                    }
                }

                // ================= FOOTER =================
                $row1 = $dataLastRow + 1;
                $row2 = $dataLastRow + 2;
                $row3 = $dataLastRow + 3;

                $classes = 0;
                $nb = $ng = $db = $dg = 0;
                $mt = $ft = 0;
                $sms = 0;
                $smsM = $smsF = 0;

                for ($r = 4; $r <= $dataLastRow; $r++) {
                    $classes += (int)$sheet->getCell("D{$r}")->getValue();
                    $nb += (int)$sheet->getCell("E{$r}")->getValue();
                    $ng += (int)$sheet->getCell("F{$r}")->getValue();
                    $db += (int)$sheet->getCell("G{$r}")->getValue();
                    $dg += (int)$sheet->getCell("H{$r}")->getValue();
                    $mt += (int)$sheet->getCell("I{$r}")->getValue();
                    $ft += (int)$sheet->getCell("J{$r}")->getValue();
                    $sms += (int)$sheet->getCell("K{$r}")->getValue();
                    $smsM += (int)$sheet->getCell("L{$r}")->getValue();
                    $smsF += (int)$sheet->getCell("M{$r}")->getValue();
                }

                $normal = $nb + $ng;
                $disabled = $db + $dg;
                $students = $normal + $disabled;
                $teachers = $mt + $ft;
                $smsMembers = $smsM + $smsF;

                $sheet->mergeCells("A{$row1}:C{$row3}");
                $sheet->setCellValue("A{$row1}", "TOTAL");

                $sheet->mergeCells("D{$row1}:D{$row3}");
                $sheet->setCellValue("D{$row1}", $classes);

                $sheet->setCellValue("E{$row1}", $nb);
                $sheet->setCellValue("F{$row1}", $ng);
                $sheet->setCellValue("G{$row1}", $db);
                $sheet->setCellValue("H{$row1}", $dg);

                $sheet->mergeCells("E{$row2}:F{$row2}");
                $sheet->mergeCells("G{$row2}:H{$row2}");
                $sheet->setCellValue("E{$row2}", $normal);
                $sheet->setCellValue("G{$row2}", $disabled);

                $sheet->mergeCells("E{$row3}:H{$row3}");
                $sheet->setCellValue("E{$row3}", $students);

                $sheet->setCellValue("I{$row1}", $mt);
                $sheet->setCellValue("J{$row1}", $ft);

                $sheet->mergeCells("I{$row2}:J{$row2}");
                $sheet->setCellValue("I{$row2}", $teachers);

                $sheet->mergeCells("I{$row3}:J{$row3}");

                $sheet->mergeCells("K{$row1}:K{$row3}");
                $sheet->setCellValue("K{$row1}", $sms);

                $sheet->setCellValue("L{$row1}", $smsM);
                $sheet->setCellValue("M{$row1}", $smsF);

                $sheet->mergeCells("L{$row2}:M{$row2}");
                $sheet->setCellValue("L{$row2}", $smsMembers);

                $sheet->mergeCells("L{$row3}:M{$row3}");

                // FOOTER STYLE
                $sheet->getStyle("A{$row1}:M{$row3}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'BFBFBF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}