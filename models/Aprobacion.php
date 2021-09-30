<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aprobacion".
 *
 * @property integer $id
 * @property integer $id_usuario_autorizado
 * @property integer $id_aprobador
 * @property integer $id_documento
 * @property string $fecha
 */
class Aprobacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aprobacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_aprobador', 'id_documento'], 'integer'],
             [['id_usuario_autorizado'], 'safe'],
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
            'id_usuario_autorizado' => 'Id Usuario Autorizado',
            'id_aprobador' => 'Id Aprobador',
            'id_documento' => 'Id Documento',
            'fecha' => 'Fecha',
        ];
    }
    
//     public static function getDb()
//    {
//        // use the "db2" application component
//        return \Yii::$app->db2;
//    }
}
