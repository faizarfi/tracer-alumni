<?php

namespace App\Http\Controllers\Concerns;

trait PdfGenerator
{
    /**
     * Try available PDF generators and return download response.
     * Throws RuntimeException if none available.
     */
    public function generatePdf(string $view, array $data, string $filename)
    {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            \Barryvdh\DomPDF\Facade\Pdf::setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, $data)->setPaper('a4', 'portrait');
            return $pdf->download($filename);
        }

        if (app()->bound('dompdf.wrapper')) {
            $pdf = app('dompdf.wrapper');
            if (method_exists($pdf, 'setOptions')) {
                $pdf->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
            }
            $pdf->loadView($view, $data);
            return $pdf->download($filename);
        }

        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view($view, $data)->render();
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            return response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        throw new \RuntimeException('No PDF generator available');
    }
}
