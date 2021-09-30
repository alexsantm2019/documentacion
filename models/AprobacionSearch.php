<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Aprobacion;

/**
 * AprobacionSearch represents the model behind the search form of `app\models\Aprobacion`.
 */
class AprobacionSearch extends Aprobacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario_autorizado', 'id_aprobador', 'id_documento'], 'integer'],
            [['fecha'], 'safe'],
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
//        $id = Yii::$app->user->identity['id'];
//        print_r($id); 
        //----------------------------------- Funcionalidad por Id de Usuario                               
                                
                                $id_usuario_logueado = Yii::$app->user->identity['id'];
                                //traigo el nombre completo del superivosr
                                $sql = " select u.id, p.full_name  FROM
                                              soporte.profile p, soporte.user u
                                              where u.id = p.user_id
                                              and u.id = '$id_usuario_logueado'";
                                $data = Yii::$app->getDb()
                                                  ->createCommand($sql)
                                                  ->queryOne();
                                $id = $data['id']; 
//                                print_r($id); die();

//----------------------------------- Fin Funcionalidad por Id de Usuario  
        //die();
        $query = Aprobacion::find()->where(['id_aprobador'=>$id]);
//        $query = Aprobacion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_usuario_autorizado' => $this->id_usuario_autorizado,
            'id_aprobador' => $this->id_aprobador,
            'id_documento' => $this->id_documento,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha]);

        return $dataProvider;
    }
    
    /****************************************************************************************************************/
    /****************************************************************************************************************/
    /****************************************************************************************************************/
    /****************************************************************************************************************/
    
         public function searchsuscriptor($params)
    {        
 //----------------------------------- Funcionalidad por Id de Usuario                                                               
                                $id_usuario_logueado = Yii::$app->user->identity['id'];
                                //traigo el nombre completo del superivosr
                                $sql = " select u.id, p.full_name  FROM
                                              soporte.profile p, soporte.user u
                                              where u.id = p.user_id
                                              and u.id = '$id_usuario_logueado'";
                                $data = Yii::$app->getDb()
                                                  ->createCommand($sql)
                                                  ->queryOne();
                                $id = $data['id']; 
                                
                                
//                                $subquery = Aprobacion::find()->select('id_documento')->distinct()->asArray()->all();
//                                $lista = array();
//                                foreach($subquery as $s){
//                                    $list[] = $s ['id_documento'] ;
//                                }
//                                $lista = implode(", ",$list);
//                                print_r($lista); die();
//                                $query = Documento::find()->where(['estado'=>3])
//                                        ->andWhere(['id_aprobacion'=>$id])
//                                        ->andWhere(['not in', 'id', '"'.$lista.'"']);
//                               var_dump($lista); die();
//                               
//                               
                        $sql = "SELECT * FROM  documento  where estado = 3
                                and id not in(select id_documento from aprobacion)
                                and id_aprobacion = $id";
                        $query = Documento::findBySql($sql);
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider_suscriptor = new ActiveDataProvider([
            'query' => $query,
                            'sort' => [
                    'defaultOrder' => [
                        'fecha' => SORT_DESC,
                    ]
                ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider_suscriptor;
        }


        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'id_categoria' => $this->id_categoria,
//            'id_tipo' => $this->id_tipo,
//            'id_usuario' => $this->id_usuario,
//            'id_aprobacion' => $this->id_aprobacion,
//        ]);
//
//        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
//            ->andFilterWhere(['like', 'path', $this->path])
//            ->andFilterWhere(['like', 'fecha', $this->fecha])
//            ->andFilterWhere(['like', 'version', $this->version])
//            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion])
//            ->andFilterWhere(['like', 'estado', $this->estado]);        
        return $dataProvider_suscriptor;
    }
    
    
    
    
    public function searchpublicador($params)
    {        
 //----------------------------------- Funcionalidad por Id de Usuario                                                               
                                $id_usuario_logueado = Yii::$app->user->identity['id'];
                                //traigo el nombre completo del superivosr
                                $sql = " select u.id, p.full_name  FROM
                                              soporte.profile p, soporte.user u
                                              where u.id = p.user_id";
                                $data = Yii::$app->getDb()
                                                  ->createCommand($sql)
                                                  ->queryOne();
                                $id = $data['id']; 

                        $sql = "SELECT * FROM  documento  where estado = 3
                                and id not in(select id_documento from aprobacion)";
                        $query = Documento::findBySql($sql);
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider_publicador = new ActiveDataProvider([
            'query' => $query,
                            'sort' => [
                    'defaultOrder' => [
                        'fecha' => SORT_DESC,
                    ]
                ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider_publicador;
        }
                 
        return $dataProvider_publicador;
    }
    
    /****************************************************************************************************************/
    
}
