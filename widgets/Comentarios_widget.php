<?php
/**
 * @author Raúl Caro Pastorino
 * @link https://fryntiz.es
 * @copyright Copyright (c) 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
**/

namespace app\widgets;

use app\models\Comentarios;

/**
 * Class Comentarios_widget
 * Genera una tabla con los últimos comentarios o por puntuación.
 *
 * @package app\widgets
 */
class Comentarios_widget extends \yii\bootstrap\Widget
{
    /**
     * @var Representa la cantidad de comentarios.
     */
    public $cantidad;

    /**
     * @var Indica si contendrá los últimos comentarios o los más votados.
     *      admite los valores 'ultimos' y 'votados'
     */
    public $tipo;

    /**
     * @var Modelo con la consulta para los datos.
     */
    public $model;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->cantidad === null) {
            $this->cantidad = 5;
        }

        if ($this->tipo === null) {
            $this->tipo = 'ultimos';
        }

        $this->model = $this->obtenerComentarios();
    }

    /**
     * Obtiene todos los comentarios unidos a los usuarios a los que pertenecen.
     * @return array
     */
    private function obtenerComentarios()
    {
        $query = Comentarios::obtenerPuntuacion();

        if ($this->tipo == 'ultimos') {
            $query->orderBy('comment.created_at DESC');
        } else if ($this->tipo == 'votados') {
            $query->orderBy('p.puntuacion DESC');
        }

        return $query->limit($this->cantidad)->all();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('comentarios_widget', [
            'model' => $this->model,
        ]);
    }
}
