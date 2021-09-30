<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "certificacion_leterago".
 *
 * @property integer $id
 * @property integer $id_usuario
 */
class CertificacionLeterago extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificacion_leterago';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'required'],
            [['id_usuario'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
        ];
    }
}
