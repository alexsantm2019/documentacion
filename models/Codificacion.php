<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "codificacion".
 *
 * @property integer $id
 * @property string $codigo_departamento
 * @property string $codigo_categoria
 * @property string $codigo_tipo
 * @property string $codigo
 * @property integer $ultimo_registro
 * @property string $descripcion
 */
class Codificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'codificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ultimo_registro'], 'integer'],
            [['codigo_departamento', 'codigo_categoria', 'codigo_tipo'], 'string', 'max' => 5],
            [['codigo'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_departamento' => 'Codigo Departamento',
            'codigo_categoria' => 'Codigo Categoria',
            'codigo_tipo' => 'Codigo Tipo',
            'codigo' => 'Codigo',
            'ultimo_registro' => 'Ultimo Registro',
            'descripcion' => 'Descripcion',
        ];
    }

        
        public function getAtributo($id) {           
            $data = \app\models\Categoria::find()->select(['id', 'categoria AS name'])->where(['departamento_id' => $id])->asArray()->all();
            return $data;
    }

}
