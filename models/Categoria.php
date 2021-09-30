<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property integer $id
 * @property string $categoria
 * @property string $codigo
 * @property integer $departamento_id
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departamento_id'], 'integer'],
            [['categoria'], 'string', 'max' => 100],
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
            'categoria' => 'Categoria',
            'codigo' => 'Codigo',
            'departamento_id' => 'Departamento ID',
        ];
    }
}
