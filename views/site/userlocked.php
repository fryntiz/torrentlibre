<?php
/**
 * Created by PhpStorm.
 * User: fryntiz
 * Date: 10/10/18
 * Time: 23:21
 */

use app\assets\UserLockedAsset;

/**
 * @author    Raúl Caro Pastorino
 * @link      https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license   https://www.gnu.org/licenses/gpl-3.0-standalone.html
 **/

/* @var $this yii\web\View */

UserLockedAsset::register($this);

$this->title = 'Usuario Bloqueado';

?>
<div id="site-userlocked">
    <h1>Usuario Bloqueado</h1>
    <h2>Inicio de sesión no permitido para usuario bloqueado</h2>

    <p>
        Este usuario ha sido bloqueado.
    </p>

    <p class="alert-warning">
        Para cualquier consulta al respecto diríjase por favor a <?=
        Yii::getAlias('@adminEmail') ?>
    </p>
</div>
