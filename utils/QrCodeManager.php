<?php

namespace Utils;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrCodeManager {

    private string $pngDir;
    private string $svgDir;
    private string $pdfDir;

    public function __construct() {
        $base = realpath(dirname(__DIR__) . '/public/qrcodes');

        $this->pngDir = $base . '/png/';
        $this->svgDir = $base . '/svg/';
        $this->pdfDir = $base . '/pdf/';

        $this->ensureDirs();
    }

    private function ensureDirs() {
        foreach ([$this->pngDir, $this->svgDir, $this->pdfDir] as $dir) {
            if (!is_dir($dir)) mkdir($dir, 0777, true);
        }
    }

    public function generateForParticipant(array $participant): string {

        $filename = 'participant_' . $participant['nom'] . $participant['prenom'];

        // QR data
        
        $data = $this->formatData($participant);

        // PNG
        $optionsPng = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L
        ]);

        $pngPath = $this->pngDir . $filename . '.png';
        (new QRCode($optionsPng))->render($data, $pngPath);
        
        // SVG
        $optionsSvg = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L
        ]);

        $svgPath = $this->svgDir . $filename . '.svg';
        (new QRCode($optionsSvg))->render($data, $svgPath);

        // PDF (optionnel)
        $pdfPath = $this->pdfDir . $filename . '.pdf';
        file_put_contents($pdfPath, file_get_contents($svgPath));

        return '/qrcodes/png/' . $filename . '.png';
    }

    private function formatData(array $data){
        return json_encode([
            'nom'              => $data['nom'],
            'prenom'           => $data['prenom'],
            'email'            => $data['email'],
            'a_vote'           => $data['a_vote'],
        ]);
    }
    public function generateSvgFormat($data, $filename){
        $optionsPng = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L
        ]);

        $pngPath = $this->pngDir . $filename . '.png';
        (new QRCode($optionsPng))->render($data, $pngPath);
        //return '/qrcodes/png/' . 
    }
}
