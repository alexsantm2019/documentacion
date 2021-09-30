<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descargas".
 *
 * @property integer $id
 * @property integer $id_documento
 * @property integer $id_usuario
 * @property string $fecha
 */
class Descargas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'descargas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_documento', 'id_usuario'], 'integer'],
            [['fecha'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_documento' => 'Id Documento',
            'id_usuario' => 'Id Usuario',
            'fecha' => 'Fecha',
        ];
    }
}
