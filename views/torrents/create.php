<?php

use app\assets\TorrentsCreateAsset;
use yii\helpers\Html;

TorrentsCreateAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Torrents */

$this->title = 'Subir Torrent';
$this->params['breadcrumbs'][] = ['label' => 'Torrents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="torrents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'licencias' => $licencias,
        'categorias' => $categorias,
    ]) ?>

</div>
