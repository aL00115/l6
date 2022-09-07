<?php

namespace App\Org;

use Illuminate\Support\Facades\Session;

class Captcha
{

//    verify(['noise'=>false]);
    function dump($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    function verify($config = [])
    {
        // session_start();
        header("content-type:image/png;");
        $size = !empty($config['size']) ? $config['size'] : 20;
        $len = !empty($config['len']) ? $config['len'] : 4;
        $style = !empty($config['style']) ? $config['style'] : 1;
        $width = ($size + 5) * $len;
        $height = $size + 20;
        $noise = isset($config['noise']) ? $config['noise'] : true;

        $im = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($im, 240, 240, 240);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagefill($im, 0, 0, $white);
        //画干扰
        if ($noise) {
            for ($i = 0; $i < 50; $i++) {
                $c = $this->rand_str(1,3);
                $color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                imagechar($im, mt_rand(1, 5), mt_rand(0, $width), mt_rand(0, $height), $c, $color);
            }
        }

        $code = $this->rand_str($len, $style);
        $_SESSION['verify'] = strtolower($code);
        for ($i = 0; $i < strlen($code); $i++) {
            $x = $size * $i + 10;
            $y = mt_rand(26, 26);
            imagettftext($im, $size, mt_rand(0, 20), $x, $y, $black, 'D:\phpstudy_pro\WWW\l6\app\Org\AGENCYB.TTF', $code[$i]);
        }

        imagepng($im);
        imagedestroy($im);
    }


    function rand_str($len = 4, $style = 1)
    {
        switch ($style) {
            case 1:
                $arr = range(0, 9);
                break;
            case 2:
                $arr = array_merge(range('a', 'z'), range('A', 'Z'));
                break;
            case 3:
                $arr = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
                break;
            default:
                $arr = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        }
        shuffle($arr);
        $subarr = array_slice($arr, 0, $len);
        return implode($subarr);
    }


}
