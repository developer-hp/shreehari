<?php
/**
 * PdfHelper – Flexible PDF generation for Yii1 with mPDF (v6 & v7+)
 *
 * Example:
 * PdfHelper::render(
 *     'barcode',
 *     ['m' => $m1],
 *     $m1[0]['code'].'.pdf',
 *     'I',
 *     [110,18],       // page size (mm) or standard name ('A4')
 *     [2,2,2,2,0,0],  // margins [left,right,top,bottom,header,footer]
 *     'L',            // orientation: 'P' (portrait) or 'L' (landscape)
 *     'gothic'        // default font
 * );
 */
class PdfHelper
{
    /**
     * Generate a PDF with dynamic options.
     *
     * @param string       $view       Yii view name (without .php)
     * @param array        $data       Data passed to the view
     * @param string       $fileName   PDF output file name
     * @param string       $dest       Destination: I=inline, D=download, F=save to file, S=string
     * @param string|array $pageSize   Page size array(width, height) in mm or standard name ('A4')
     * @param array        $margins    Margins [left,right,top,bottom,header,footer]
     * @param string       $orientation 'P' = Portrait (default), 'L' = Landscape
     * @param string       $font       Default font
     */
    public static function render(
        $view,
        $data = [],
        $fileName = 'output.pdf',
        $dest = 'I',
        $pageSize = 'A4',
        $margins = [0,0,0,0,0,0],
        $orientation = 'P',
        $font = 'gothic',
        $save = false,
        $savepathname = ""
    ) {

        // unpack margins safely
        list($ml, $mr, $mt, $mb, $mh, $mf) = $margins + [0,0,0,0,0,0];

            // 👉 New mPDF v7+ (Composer)
        require_once Yii::app()->basePath . '/../vendor/autoload.php';


        $config = [
            'tempDir' => Yii::app()->basePath.'/../uploads/temp',
            'allow_url_fopen' => true,
            'curlAllowUnsafeSslRequests' => true,
            'mode'           => 'utf-8',
            'format'         => $pageSize,
            'orientation'    => $orientation,
            'default_font'   => $font,
            'default_font_size' => 0,
            'margin_left'    => $ml,
            'margin_right'   => $mr,
            'margin_top'     => $mt,
            'margin_bottom'  => $mb,
            'margin_header'  => $mh,
            'margin_footer'  => $mf,
        ];
        $mpdf = new \Mpdf\Mpdf($config);
        $mpdf->useSubstitutions = false;
        // $mpdf->showImageErrors = true;
        

        // ✅ Load CSS using filesystem path
        $cssPath = Yii::getPathOfAlias('webroot') . '/css/pdf.css';
        if (file_exists($cssPath)) {
            $stylesheet = file_get_contents($cssPath);
            $mpdf->WriteHTML($stylesheet, 1);
        }

        if($save)
        {
            // $cssPath = Yii::getPathOfAlias('webroot') . '/css/orderform.css';
            // if (file_exists($cssPath)) {
            //     $stylesheet = file_get_contents($cssPath);
            //     $mpdf->WriteHTML($stylesheet, 1);
            // }

        }

        // ✅ Render the view
        $html = Yii::app()->controller->renderPartial($view, $data, true);
        $mpdf->WriteHTML($html, 2);

        // ✅ Output the PDF
        $mpdf->Output($fileName, $dest);



        if($save)
        {
            $mpdf->Output($savepathname, 'F');
        }
        if($dest=="F") return;

        Yii::app()->end();
    }
}
