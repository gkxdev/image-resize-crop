<?php
/**
 * Image
 * @author Gökhan Kaya <gkxdev@gmail.com>
 */
class Image {
    private $image;
    private $width, $height, $type;

    public function __construct($file) {
        if (!extension_loaded('gd')) {
            exit('PHP GD is not installed!');
        }

        if (!is_file($file)) {
            throw new Exception('Could not load file: ' . $file);
        }

        $info = getimagesize($file);

        if ($info === false) {
            throw new Exception('Could not load image: ' . $file);
        }

        list($this->width, $this->height, $this->type) = $info;

        switch ($this->type) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($file);
                break;

            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($file);
                break;

            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($file);
                break;

            default:
                throw new Exception('Unsupported image type: ' . $file);
                break;
        }

        return $this;
    }

    public function resize($width, $height, bool $crop = false) {
        if ($width <= 0)  $width = $this->width;
        if ($height <= 0) $height = $this->height;

        $x = $y = 0;

        if (!$crop) {

            $ratio = $this->width / $this->height;

            if (($width / $height) > $ratio) {
                $width = (int) round($height * $ratio);
            } else {
                $height = (int) round($width / $ratio);
            }

        } else {

            $ratio = $width / $height;

            if (($this->width / $this->height) > $ratio) {
                $w = (int) round($this->height * $ratio);
                $x = (int) round(($this->width - $w) / 2);
                $this->width = $w;
            } else {
                $h = (int) round($this->width / $ratio);
                $y = (int) round(($this->height - $h) / 2);
                $this->height = $h;
            }

        }

        return $this->renderImage($width, $height, $x, $y);
    }

    public function save($file, int $quality = 90) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        if ($extension == 'jpg' || $extension == 'jpeg') {
            imagejpeg($this->image, $file, $quality);
        } elseif ($extension == 'png') {
            imagepng($this->image, $file);
        } elseif ($extension == 'gif') {
            imagegif($this->image, $file);
        }

        imagedestroy($this->image);
        unset($this->image);

        return true;
    }

    public function display(int $quality = 90) {
        header('Content-Type: ' . image_type_to_mime_type($this->type));

        if ($this->type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, null, $quality);
        } elseif ($this->type == IMAGETYPE_PNG) {
            imagepng($this->image, null);
        } elseif ($this->type == IMAGETYPE_GIF) {
            imagegif($this->image, null);
        }

        imagedestroy($this->image);
        unset($this->image);
    }

    private function renderImage($width, $height, $x = 0, $y = 0) {
        $image = $this->image;
        $this->image = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($this->image, 255, 255, 255);
        imagefill($this->image, 0, 0, $background);

        // if ($this->type == IMAGETYPE_PNG) {
        //     imagesavealpha($this->image, true);
        //     imagealphablending($this->image, false);
        //     $background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
        //     imagecolortransparent($this->image, $background);
        // }

        imagecopyresampled($this->image, $image, 0, 0, $x, $y, $width, $height, $this->width, $this->height);

        imagedestroy($image);
        unset($image);

        return $this;
    }
}
