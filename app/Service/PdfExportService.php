<?php

namespace App\Service;

use Illuminate\Support\Facades\File;
use Mpdf\Mpdf;

class PdfExportService
{

    private string $exportPath = 'pdf_exports';

    public function __construct()
    {
        $this->ensureExportDirectoryExists();
    }

    public function generatePdf($view, $data, $fileName): ?string
    {
        $path = $this->exportPath;
        $html = view($view, $data)->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'dejavusans',
        ]);

        $mpdf->WriteHTML($html);

        $filePath = public_path("{$path}/{$fileName}.pdf");

        $mpdf->Output($filePath, 'F'); // 'F' saves the file

        return asset("{$path}/{$fileName}.pdf");
    }


    private function ensureExportDirectoryExists(): void
    {
        $directory = public_path($this->exportPath);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }
}
