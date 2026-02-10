<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelHelper
{
    protected static $autoloaded = false;

    protected static function autoload()
    {
        if (!self::$autoloaded) {
            require_once Yii::getPathOfAlias('application') . '/../vendor/autoload.php';
            self::$autoloaded = true;
        }
    }

    /**
     * Export Excel file
     *
     * @param array  $headers
     * @param array  $rows
     * @param string $filename
     * @param array  $columnWidths
     * @param array  $options
     */
    public static function export(
    array $headers,
    array $rows,
    $filename = 'export',
    array $columnWidths = [],
    array $options = []
    ) {
        self::autoload();

        $format = strtolower($options['format'] ?? 'xlsx'); // xlsx | csv

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Properties
        $spreadsheet->getProperties()
            ->setCreator($options['creator'] ?? 'Dev Yii')
            ->setLastModifiedBy($options['creator'] ?? 'Dev Yii')
            ->setTitle($filename);

        // Header
        $sheet->fromArray($headers, null, 'A1');

        $lastColumn = Coordinate::stringFromColumnIndex(count($headers));

        $numberFormat = $options['number_format'] ?? [];


        $rowNum = count($rows) + 1;

        foreach ($numberFormat as $column => $formatCode) {

            // Column range like F:G
            if (strpos($column, ':') !== false) {
                [$start, $end] = explode(':', $column);
                // pr($start);
                $sheet->getStyle("{$start}2:{$end}" . ($rowNum - 1))
                      ->getNumberFormat()
                      ->setFormatCode($formatCode);
            }
            // Single column like D
            else {
                $sheet->getStyle("{$column}2:{$column}" . ($rowNum - 1))
                      ->getNumberFormat()
                      ->setFormatCode($formatCode);
            }
        }

        // Styling (only for XLSX)
        if ($format === 'xlsx') {
            $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
            $sheet->getStyle("A1:{$lastColumn}1")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB($options['headerColor'] ?? 'D3D3D3');

            foreach(@$options['bold_rows'] as $rnumber)
            {
                $sheet->getStyle("A{$rnumber}:{$lastColumn}{$rnumber}")->getFont()->setBold(true);
            }

            // Column widths
            $totalColumns = count($headers);
            for ($i = 0; $i < $totalColumns; $i++) {
                $col = Coordinate::stringFromColumnIndex($i + 1);
                if (isset($columnWidths[$col])) {
                    $sheet->getColumnDimension($col)->setWidth($columnWidths[$col]);
                } else {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        }

        // Data
        $rowIndex = 2;
        foreach ($rows as $row) {
            $sheet->fromArray($row, null, 'A' . $rowIndex);
            $rowIndex++;
        }

        // Optional XLSX features
        if ($format === 'xlsx') {
            if (!empty($options['freezeHeader'])) {
                $sheet->freezePane('A2');
            }

            if (!empty($options['autoFilter'])) {
                $sheet->setAutoFilter("A1:{$lastColumn}1");
            }
        }

        // Output filename
        $date = date('d-m-Y');
        $filename .= "-{$date}.{$format}";

        if (ob_get_length()) {
            ob_end_clean();
        }

        // Writer & headers
        if ($format === 'csv') {

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Csv($spreadsheet);
            $writer->setDelimiter($options['csvDelimiter'] ?? ',');
            $writer->setEnclosure($options['csvEnclosure'] ?? '"');
            $writer->setLineEnding($options['csvLineEnding'] ?? PHP_EOL);
            $writer->setUseBOM($options['csvUseBOM'] ?? true);
            $writer->setSheetIndex(0);

        } else {

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
        }

        $writer->save('php://output');
        Yii::app()->end();
    }
}
