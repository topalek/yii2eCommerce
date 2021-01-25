<?php
/**
 * Created by topalek
 * Date: 13.01.2021
 * Time: 11:57
 */

namespace console\controllers;


use common\models\Product;

class ProductController extends \yii\console\Controller
{
    public function seed()
    {
    }

    public function actionBook()
    {
        // https://telestat.org/audiobooks/22348/book/00_01.mp3
        for ($i = 0; $i <= 16; $i++) {
            for ($j = 0; $j <= 99; $j++) {
                $n = $i;
                if ($i < 10) {
                    $n = '0' . $n;
                }
                $k = $j;
                if ($j < 10) {
                    $k = '0' . $k;
                }
                $n = $n . "_" . $k;

                $file = "https://telestat.org/audiobooks/22348/book/" . $n . '.mp3';
                try {
                    $file = file_get_contents($file);
                    file_put_contents(Product::getUploadsPath() . "/book/" . $n . ".mp3", $file);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        return "ok";
    }
}
