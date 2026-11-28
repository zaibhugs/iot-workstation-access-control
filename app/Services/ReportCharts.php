<?php

namespace App\Services;

class ReportCharts
{
    /**
     * Render the course distribution donut as a PNG data URI.
     *
     * DOMPDF does not reliably render inline SVG, so the chart is drawn with
     * GD and embedded directly in the report HTML.
     */
    public function donut(
        array $counts,
        array $labels,
        array $colors,
        int $total
    ): ?string {

        if ($total <= 0) {
            return null;
        }

        $scale = 2;
        $size = 360 * $scale;

        $image = imagecreatetruecolor($size, $size);

        imagealphablending($image, false);
        imagesavealpha($image, true);

        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefilledrectangle($image, 0, 0, $size, $size, $transparent);

        imagealphablending($image, true);

        if (function_exists('imageantialias')) {
            imageantialias($image, true);
        }

        $white = imagecolorallocate($image, 255, 255, 255);
        $cx = 180 * $scale;
        $cy = 180 * $scale;
        $outer = 264 * $scale;
        $inner = 154 * $scale;

        $segments = [];

        foreach ($counts as $index => $count) {
            $count = (int) $count;

            if ($count <= 0) {
                continue;
            }

            $segments[] = [
                'count' => $count,
                'color' => $this->color(
                    $image,
                    $colors[$index] ?? '#3B82F6'
                ),
            ];
        }

        if (count($segments) === 1) {
            imagefilledellipse($image, $cx, $cy, $outer, $outer, $segments[0]['color']);
        } else {
            $startAngle = -90;

            foreach ($segments as $segment) {
                $sweep = ($segment['count'] / $total) * 360;
                $endAngle = $startAngle + $sweep;

                imagefilledarc(
                    $image,
                    $cx,
                    $cy,
                    $outer,
                    $outer,
                    (int) round($startAngle),
                    (int) round($endAngle),
                    $segment['color'],
                    IMG_ARC_PIE
                );

                $radian = deg2rad($startAngle);

                imageline(
                    $image,
                    (int) round($cx + cos($radian) * ($inner / 2)),
                    (int) round($cy + sin($radian) * ($inner / 2)),
                    (int) round($cx + cos($radian) * ($outer / 2)),
                    (int) round($cy + sin($radian) * ($outer / 2)),
                    $white
                );

                $startAngle = $endAngle;
            }
        }

        imagefilledellipse($image, $cx, $cy, $inner, $inner, $white);

        $dark = imagecolorallocate($image, 15, 23, 42);
        $muted = imagecolorallocate($image, 100, 116, 139);

        $boldFont = storage_path('fonts/Aptos-Bold.ttf');
        $regularFont = storage_path('fonts/Aptos-Regular.ttf');

        if (is_file($boldFont) && is_file($regularFont)) {
            $this->centeredText(
                $image,
                $boldFont,
                (string) number_format($total),
                20 * $scale,
                $cx,
                $cy - (10 * $scale),
                $dark
            );

            $this->centeredText(
                $image,
                $regularFont,
                'Students',
                9 * $scale,
                $cx,
                $cy + (17 * $scale),
                $muted
            );
        } else {
            imagestring(
                $image,
                5,
                $cx - 20,
                $cy - 12,
                (string) $total,
                $dark
            );
        }

        $final = imagecreatetruecolor(360, 360);

        imagealphablending($final, false);
        imagesavealpha($final, true);

        $finalTransparent = imagecolorallocatealpha($final, 0, 0, 0, 127);
        imagefilledrectangle($final, 0, 0, 360, 360, $finalTransparent);

        imagecopyresampled($final, $image, 0, 0, 0, 0, 360, 360, $size, $size);

        ob_start();
        imagepng($final);
        $png = ob_get_clean();

        imagedestroy($image);
        imagedestroy($final);

        return 'data:image/png;base64,'.base64_encode($png);
    }

    private function color($image, string $hex): int
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $red = hexdec(substr($hex, 0, 2));
        $green = hexdec(substr($hex, 2, 2));
        $blue = hexdec(substr($hex, 4, 2));

        return imagecolorallocate($image, $red, $green, $blue);
    }

    private function centeredText(
        $image,
        string $font,
        string $text,
        int $size,
        int $centerX,
        int $baselineY,
        int $color
    ): void {

        $box = imagettfbbox($size, 0, $font, $text);
        $width = $box[2] - $box[0];

        imagettftext(
            $image,
            $size,
            0,
            (int) round($centerX - ($width / 2)),
            $baselineY,
            $color,
            $font,
            $text
        );
    }
}
