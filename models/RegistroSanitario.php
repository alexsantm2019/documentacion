<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_sanitario".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $producto
 * @property string $fecha_modificacion
 * @property string $modificacion
 * @property string $fecha_vigencia
 * @property string $path
 * @property integer $id_usuario
 * @property integer $estado
 * @property string $fecha_publicacion
 * @property integer $copias
 * @property string $detalle_copias
 * @property string $status
 */
class RegistroSanitario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registro_sanitario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'producto', 'fecha_modificacion', 'modificacion', 'fecha_vigencia', 'path', 'id_usuario', 'estado', 'status'], 'required'],
            [['modificacion'], 'string'],
            [['id_usuario', 'estado', 'copias'], 'integer'],
            [['codigo'], 'string', 'max' => 45],
            [['producto'], 'string', 'max' => 200],
            [['fecha_modificacion', 'fecha_vigencia'], 'string', 'max' => 30],
            //[['path'], 'string', 'max' => 100],
            [['path'], 'file', 'extensions' => 'pdf'],
            [['fecha_publicacion'], 'string', 'max' => 40],
            //[['detalle_copias'], 'string', 'max' => 500],
            [['copias'], 'integer', 'min' => 0, 'message'=>'Por favor ingrese solo NUMEROS ENTEROS y mínimo 1 copia'],            
            [['status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'producto' => 'Producto',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificacion' => 'Modificacion',
            'fecha_vigencia' => 'Fecha Vigencia',
            'path' => 'Path',
            'id_usuario' => 'Id Usuario',
            'estado' => 'Estado',
            'fecha_publicacion' => 'Fecha Publicacion',
            'copias' => 'Copias',
            'detalle_copias' => 'Detalle Copias',
            'status' => 'Status',
        ];
    }
}
