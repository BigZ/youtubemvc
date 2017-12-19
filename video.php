<?php
header("Content-type: image/png");

$trackName = "THAT THOU ART";
$releaseName = "Quiet your mind EP";
$releaseBand = "Out of Jetlag";
$releaseCatalog = "Nataraja Records / NTJ025";

function resiteTo169($image) {
  $width = imagesx($image);
  $height = ($width / 16) * 9;
  $y = (imagesy($image) - $height) / 2;

  $cropped = imagecrop($image, ['x' => 0, 'y' => $y, 'width' => $width, 'height' => $height]);
  return imagescale($cropped, 1280, 720);
}

function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}


$originalImage = imagecreatefromjpeg("1.jpg");
$resizedImage = resiteTo169($originalImage);
// blur image
for ($x=1; $x<=15; $x++)
   imagefilter($resizedImage, IMG_FILTER_GAUSSIAN_BLUR);
imagefilter($resizedImage, IMG_FILTER_BRIGHTNESS, 60);
imagefilter($resizedImage, IMG_FILTER_CONTRAST, 1);

// copy original in center
$thumbnail = imagescale($originalImage, 600);
imagecopy($resizedImage, $thumbnail, 60 , 60, 0, 0, 600, 600);
// Add text
putenv('GDFONTPATH=' . realpath('.'));
$font_color = imagecolorallocate($resizedImage, 255, 255, 255);
$stroke_color = imagecolorallocate($resizedImage, 0, 0, 0);
imagettfstroketext($resizedImage, 30, 0, 720, 100, $font_color, $stroke_color, 'Emmanuelle.ttf', $trackName, 2);
imagettfstroketext($resizedImage, 20, 0, 720, 150, $font_color, $stroke_color, 'Emmanuelle.ttf', $releaseBand, 2);
imagettfstroketext($resizedImage, 20, 0, 720, 200, $font_color, $stroke_color, 'Emmanuelle.ttf', $releaseName, 2);
imagettfstroketext($resizedImage, 20, 0, 720, 250, $font_color, $stroke_color, 'Emmanuelle.ttf', $releaseCatalog, 2);

// Add shop logos
$beatportImage = imagecreatefrompng("beatport.png");
$bandcampImage = imagecreatefrompng("bandcamp.png");
$psyshopImage = imagecreatefrompng("psyshop.png");
$spotifyImage = imagecreatefrompng("spotify.png");
imagecopy($resizedImage, $beatportImage, 720 ,520, 0, 0, 200, 50);
imagecopy($resizedImage, $bandcampImage, 970 ,520, 0, 0, 200, 50);
imagecopy($resizedImage, $psyshopImage, 720, 610, 0, 0, 200, 50);
imagecopy($resizedImage, $spotifyImage, 970, 610, 0, 0, 200, 50);

// render
imagepng($resizedImage);
imagedestroy($resizedImage);
imagedestroy($originalImage);

?>
