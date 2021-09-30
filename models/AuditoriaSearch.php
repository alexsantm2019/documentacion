<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use app\models\Auditoria;
use yii\data\ActiveDataProvider;

/**
 * CategoriaSearch represents the model behind the search form of `app\models\Categoria`.
 */
class AuditoriaSearch extends Auditoria
{
    /**
     * @inheritdoc
     */

    public $autor;

    public function rules()
    {
        return [
            [['id', 'audUsuarioLogueado', 'audDocumentoId'], 'integer'],
            [['audFlag','audAccion', 'audDetalle', 'audIp'], 'string', 'max' => 50],
            [['audFecha'], 'safe'],
            [['autor'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
//$query = Auditoria::find();

       $query = Auditoria::find();
       //$query = Auditoria::find()->where(['date(audFecha)' => php('Y-m-d')])->one(); 
        // ->select('
        //         auditoria.id as id,
        //         p.full_name as Autor,
        //         auditoria.audFlag as Flag,
        //         auditoria.audAccion as Accion,
        //         auditoria.audDetalle as Detalle,
        //         auditoria.audFecha as FechaAuditoria,
        //         auditoria.audIp as IP,
        //         d.codigo as CodigoDocumento,
        //         d.nombre_archivo as NombreArchivo,
        //         dep.departamento as Departamento,
        //         est.estado as Estado ,
        //         d.fecha_aprobacion as FechaAprobacionDocumento,
        //         d.fecha_publicacion as FechaPublicacionDocumento')
        // ->from('auditoria')  // make sure same column name not there in both table
        // ->innerJoin('_profile as p', 'p.user_id = auditoria.audUsuarioLogueado')
        // ->innerJoin('documento as d', 'd.id = auditoria.audDocumentoId')
        // ->innerJoin('departamento as dep', 'dep.id = d.id_departamento')
        // ->innerJoin('categoria as cat', 'd.id_categoria = cat.id')
        // ->innerJoin('estado as est', 'd.estado = est.id');


        // $query = Auditoria::find()->select('auditoria.id as id,
        //         p.full_name as Autor,
        //         auditoria.audFlag as Flag,
        //         auditoria.audAccion as Accion,
        //         auditoria.audDetalle as Detalle,
        //         auditoria.audFecha as FechaAuditoria,
        //         auditoria.audIp as IP,
        //         d.codigo as CodigoDocumento,
        //         d.nombre_archivo as NombreArchivo,
        //         dep.departamento as Departamento,
        //         est.estado as Estado ,
        //         d.fecha_aprobacion as FechaAprobacionDocumento,
        //         d.fecha_publicacion as FechaPublicacionDocumento');
        // $query->innerJoinWith(['profile'], true);
        // $query->innerJoinWith(['documento'], true);
        // $query->innerJoinWith(['departamento'], true);
        // $query->innerJoinWith(['categoria'], true);
        // $query->innerJoinWith(['estado'], true);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider(
            ['pagination' => ['pageSize' => 5],
            'query' => $query
        ]);

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'audUsuarioLogueado' => $this->audUsuarioLogueado,
        ]);

        $query->andFilterWhere(['like', 'audFlag', $this->audFlag])
            ->andFilterWhere(['like', 'audAccion', $this->audAccion])
            ->andFilterWhere(['like', 'audDetalle', $this->audDetalle])
            // ->andFilterWhere(['like', 'audFecha', $this->audFecha])
            // ->andFilterWhere([
            //     '>=',
            //     'audFecha',
            //     strtotime($this->audFecha)
            // ])
            ->andFilterWhere(['>=', 'audFecha', Date('Y-m-d', strtotime($this->audFecha))])
        // ->andFilterWhere(
        //     [
        //         '=',
        //         new \yii\db\Expression('DATE_FORMAT(audFecha, "%Y.%m.%d")'),
        //         date('Y.m.d', strtotime($this->audFecha)),
        //     ]
        // )
        // ->andFilterWhere([
        //     'like',
        //     'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
        //     $this->audFecha
        // ])
            
            ->andFilterWhere(['like', 'audIp', $this->audIp]);
            // ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

       //$query->andFilterWhere(['like', 'autor', $this->autor]);

        return $dataProvider;
    }
}
