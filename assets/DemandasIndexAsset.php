<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Assets para vistas de Demandas
 */
class DemandasIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/demandas/index.css',
    ];
    public $js = [
        'js/demandas/index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
