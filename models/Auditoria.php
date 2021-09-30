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
class Auditoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auditoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['audUsuarioLogueado'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'audUsuarioLogueado' => 'Usuario logueado',
            'audFlag' => 'Tag',
            'audAccion' => 'Accion',
            'audDetalle' => 'Detalle',
            'audDocumentoId' => 'Documento',
            'audFecha' => 'Fecha',
            'audIp' => 'Dirección IP',
        ];
    }

    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['audUsuarioLogueado' => 'user_id']);
    }
}
