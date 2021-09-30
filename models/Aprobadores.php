<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aprobadores".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $estado
 * @property string $fecha
 */
class Aprobadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aprobadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['estado'], 'string', 'max' => 20],
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
            'user_id' => 'User ID',
            'estado' => 'Estado',
            'fecha' => 'Fecha',
        ];
    }
}
