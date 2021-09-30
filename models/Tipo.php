<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo".
 *
 * @property integer $id
 * @property string $tipo
 * @property string $codigo
 */
class Tipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'codigo' => 'Codigo',
        ];
    }
}
