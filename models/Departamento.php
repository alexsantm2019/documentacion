<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamento".
 *
 * @property integer $id
 * @property string $departamento
 * @property string $codigo
 */
class Departamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'departamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departamento'], 'string', 'max' => 45],
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
            'departamento' => 'Departamento',
            'codigo' => 'Codigo',
        ];
    }
}
