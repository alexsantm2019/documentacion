<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property integer $id
 * @property string $comentario
 * @property integer $id_documento
 * @property string $fecha
 * @property integer $autor
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comentario'], 'string'],
            [['id_documento', 'autor'], 'integer'],
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
            'comentario' => 'Comentario',
            'id_documento' => 'Id Documento',
            'fecha' => 'Fecha',
            'autor' => 'Autor',
        ];
    }
}
