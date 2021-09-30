<?php

namespace app\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "documento".
 *
 * @property integer $id
 * @property string $nombre_archivo
 * @property integer $id_categoria
 * @property integer $id_tipo
 * @property string $path
 * @property string $fecha
 * @property string $version
 * @property integer $estado
 * @property integer $id_usuario
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
//    var $path;
    
    public static function tableName()
    {
        return 'documento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_archivo', 'version', 'copias', 'detalle_copias', 'path'], 'required'],
            
            [['codigo'], 'required'],
//            [['codigo'], 'unique', 'message'=>'El código ingresado ya existe. Por favor ingrese un nuevo código'],
            
            [['id_departamento'], 'required', 'message'=>'Seleccione un Departamento'],
            [['id_categoria'], 'required', 'message'=>'Seleccione una Categoría'],
            [['id_tipo'], 'required', 'message'=>'Seleccione un Tipo'],
            
//            [['path'], 'required', 'message'=>'Debe añadir un archivo para continuar'],
            [['id_aprobacion'], 'required', 'message'=>'Por favor seleccione la persona que aprobará el documento'],
            [['id_departamento', 'id_categoria', 'id_tipo', 'estado', 'id_usuario', 'id_original', 'id_custodio', 'id_aprobacion', 'id_autorizador', 'id_publicador'], 'integer'],
            [['nombre_archivo'], 'string', 'max' => 200],
            [['codigo'], 'string', 'max' => 100],
            //[['path'], 'string', 'max' => 100],
            [['path'], 'file', 'extensions' => 'doc, docx, xls, xlsx, pdf'],
//            [['activo'], 'string', 'max' => 10],
            [['observacion'], 'string', 'max' => 500],
            [['obs_suscriptor'], 'string', 'max' => 500],
            [['obs_corrector'], 'string', 'max' => 500],
            [['copias'], 'integer', 'min' => 0, 'message'=>'Por favor ingrese solo NUMEROS ENTEROS y mínimo 1 copia'],            
            [['detalle_copias'], 'string', 'max' => 500],
            [['obs_registros'], 'string', 'max' => 500],
            [['fecha'], 'string', 'max' => 30],
            [['fecha_autorizacion', 'fecha_publicacion'], 'string', 'max' => 20],
            [['version'], 'string', 'max' => 10],
            
            [['codigo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_archivo' => 'Nombre Archivo',
            'id_categoria' => 'Id Categoria',
            'id_tipo' => 'Id Tipo',
            'path' => 'Path',
            'fecha' => 'Fecha',
            'version' => 'Version',
            'estado' => 'Estado',
            'id_usuario' => 'Id Usuario',
            'id_aprobacion' => 'Aprobado por',
        ];
    }
    
    /***************************************************************************/
       public function getAtributo($id) {           
            $data = \app\models\Categoria::find()->select(['id', 'categoria AS name'])->where(['departamento_id' => $id])->asArray()->all();
            return $data;
    }
    
    /***************************************************************************/
}
