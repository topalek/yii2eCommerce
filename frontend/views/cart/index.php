<?php
/**
 * Created by topalek
 * Date: 14.01.2021
 * Time: 16:20
 *
 * @var $this View
 */

use yii\web\View;

?>
<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js') ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <iframe width="560" height="315" class="embed-video lazy-load"
                    data-src="https://www.youtube.com/embed/QRU_5SaZyJE" src="/img/no-photo.png" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>
    </div>
</div>
<?php
$this->registerJs(
    <<<JS
const observer = lozad('.lazy-load'); // lazy loads elements with default selector as '.lozad'

setTimeout(()=>{
    observer.observe();
},2000)

JS

) ?>

