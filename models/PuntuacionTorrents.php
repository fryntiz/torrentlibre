<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puntuacion_torrents".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $torrent_id
 * @property int $puntuacion
 * @property string $created_at
 *
 * @property Torrents $torrent
 * @property Usuarios $usuario
 */
class PuntuacionTorrents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puntuacion_torrents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'torrent_id', 'puntuacion'], 'default', 'value' => null],
            [['usuario_id', 'torrent_id', 'puntuacion'], 'integer'],
            [['puntuacion'], 'required'],
            [['created_at'], 'safe'],
            [['usuario_id', 'torrent_id'], 'unique', 'targetAttribute' => ['usuario_id', 'torrent_id']],
            [['torrent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torrents::className(), 'targetAttribute' => ['torrent_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'torrent_id' => 'Torrent ID',
            'puntuacion' => 'Puntuacion',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTorrent()
    {
        return $this->hasOne(Torrents::className(), ['id' => 'torrent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}
