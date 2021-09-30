<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Documento;

/**
 * DocumentoSearch represents the model behind the search form of `app\models\Documento`.
 */
class DocumentoSearch extends Documento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_categoria', 'id_tipo', 'id_usuario', 'id_custodio', 'id_aprobacion'], 'integer'],
            [['nombre_archivo', 'codigo', 'path', 'fecha', 'version', 'estado'], 'safe'],
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

                                $query = Documento::find()->where(['id_aprobacion'=>$id])->andWhere(['IN', 'estado', [1]]);
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
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
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_custodio', $this->id_custodio]);

        return $dataProvider;
    }
    
    
     public function searchsuscriptor($params)
    {        
        $id_usuario = Yii::$app->user->identity['id'];
        $query = Documento::find()->where(['id_usuario'=>$id_usuario])->andWhere(['IN', 'estado', [1,2]]);

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
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
            'id_aprobacion' => $this->id_aprobacion,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion])
            ->andFilterWhere(['like', 'estado', $this->estado]);
        return $dataProvider_suscriptor;
    }
    
     public function searchsuscriptor2($params)
    {        
        $id_usuario = Yii::$app->user->identity['id'];
        $query = Documento::find()->where(['id_usuario'=>$id_usuario])->andWhere(['estado'=>3]);

        // add conditions that should always apply here
        $dataProvider_suscriptor2 = new ActiveDataProvider([
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
            return $dataProvider_suscriptor2;
    }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
            'id_aprobacion' => $this->id_aprobacion,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion])
            ->andFilterWhere(['like', 'estado', $this->estado]);        
        return $dataProvider_suscriptor2;
    }
    
       public function searchversionador($params)
    {        
        $id_usuario = Yii::$app->user->identity['id'];
        $query = Documento::find()->where(['id_usuario'=>$id_usuario])->andWhere(['estado'=>5]);

        // add conditions that should always apply here
        $dataProvider_versionador = new ActiveDataProvider([
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
            return $dataProvider_versionador;
    }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
            'id_aprobacion' => $this->id_aprobacion,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion])
            ->andFilterWhere(['like', 'estado', $this->estado]);        
        return $dataProvider_versionador;
    }
    
    
     public function searchusuario($params) //DOCUMENTOS UNICOS
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
                
//                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.id_usuario, d.id_aprobacion, d.id_categoria, d.id_tipo, d.path, d.version,
//                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, 
//                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
//                        from 
//                        documento d, 
//                        aprobacion a
//                        WHERE
//                        d.id = a.id_documento 
//                        AND d.id_original is NULL
//                        and d.estado = 5
//                        and d.id not in (select distinct(id_original) from documento where id_original is not null)
//                        and a.id_usuario_autorizado = $id order by d.id_categoria, d.fecha_aprobacion desc";
//                        $query = Documento::findBySql($sql); 
                        
                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.id_usuario, d.id_aprobacion, d.id_categoria, d.id_tipo, d.path, d.version,d.fecha, d.codigo,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, 
                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
                        from 
                        documento d, 
                        aprobacion a
                        WHERE
                        d.id = a.id_documento 
                        -- AND d.id_original is NULL
                        and d.estado = 5
                        and a.id_usuario_autorizado = $id 
                        order by d.id_categoria, d.fecha_aprobacion desc ";
                        
                        $query = Documento::findBySql($sql); 
                        
                                                
//----------------------------------- Fin Funcionalidad por Id de Usuario  

        
        // add conditions that should always apply here

        $dataProvider_usuario = new ActiveDataProvider([
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
            return $dataProvider_usuario;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        return $dataProvider_usuario;
    }
    
     public function searchusuario2($params) //DOCUMENTOS VERSIONADOS
    {        
//        $id_usuario = Yii::$app->user->identity['id'];
//        $query = \app\models\Documento::find()->where('id_original IS NOT NULL')->andWhere(['estado'=>3])->orderBy('id_original');
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
                
                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.id_categoria, d.id_tipo, d.path, d.version,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, d.id_usuario,
                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
                        from documento d, aprobacion a
                        WHERE
                        d.id = a.id_documento 
                        AND d.id_original is not NULL
                        and d.estado = 5
                        and a.id_usuario_autorizado = $id order by d.id_categoria, d.id_original,  d.fecha_aprobacion asc";
                        $query = Documento::findBySql($sql);  
                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider_usuario2 = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'fecha' => SORT_ASC,
                    ]
                ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider_usuario2;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider_usuario2;
    }
    
    
    
         public function searchusuarioadmin($params) //DOCUMENTOS UNICOS SUPERADMIN
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
                
                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.id_usuario, d.id_aprobacion, d.id_categoria, d.id_tipo, d.path, d.version,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, 
                        a.id_usuario_autorizado as auth, a.id_aprobador, a.id_documento
                        from documento d, aprobacion a
                        WHERE
                        d.id = a.id_documento 
                        AND d.id_original is NULL
                        and d.estado = 5
                        and d.id not in (select distinct(id_original) from documento where id_original is not null)
                        group by d.id
                       order by d.id_categoria, d.id_original,  d.fecha_aprobacion asc";                        
                        $query = Documento::findBySql($sql);  
                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider_usuario = new ActiveDataProvider([
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
            return $dataProvider_usuario;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        return $dataProvider_usuario;
    }
    
    
    public function searchusuario2admin($params) //DOCUMENTOS VERSIONADOS
    {        
//        $id_usuario = Yii::$app->user->identity['id'];
//        $query = \app\models\Documento::find()->where('id_original IS NOT NULL')->andWhere(['estado'=>3])->orderBy('id_original');
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
                
                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.id_categoria, d.id_tipo, d.path, d.version,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, d.id_usuario,
                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
                        from documento d, aprobacion a
                        WHERE
                        d.id = a.id_documento 
                        AND d.id_original is not NULL
                        and d.estado = 5
                        order by id_original, fecha_aprobacion asc
                        ";
                        $query = Documento::findBySql($sql);  
                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  
        
        // add conditions that should always apply here

        $dataProvider_usuario2 = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'fecha' => SORT_ASC,
                    ]
                ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider_usuario2;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider_usuario2;
    }
    
    
    
    
     public function searchpublicador($params) //DOCUMENTOS UNICOS
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
                
                        $sql1 = "select DISTINCT(d.id), d.nombre_archivo, d.codigo as codigo, d.id_usuario, d.fecha, d.id_aprobacion, d.id_categoria, d.id_tipo, d.path, d.version,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, d.copias, d.detalle_copias, d.obs_registros, 
                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
                        from documento d, aprobacion a
                        WHERE
                        d.id = a.id_documento                         
                        and d.estado = 3
                        and d.id not in (select distinct(id_original) from documento where id_original is not null)
                        group by d.id                        
                        order by d.fecha_aprobacion desc, d.id_categoria ";
                        //$query = Documento::findBySql($sql1); 

                        $query = \app\models\Documento::find()->andWhere(['estado'=>3])->orderBy([
                        'id_categoria'=>SORT_ASC,
//                        'fecha_aprobacion' => SORT_DESC                        
                      ]);
                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  

        
        // add conditions that should always apply here

        $dataProvider_publicador = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'fecha_aprobacion' => SORT_DESC,
                    ]
                ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider_publicador;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        return $dataProvider_publicador;
    }
    
    
    
     public function searchestado($params) //DOCUMENTOS UNICOS
    {        
//        $query = Documento::find()->orderBy('id_categoria');        
        $subquery = Documento::find()->select('max(fecha)')->where('codigo = tbl.codigo');
        $query = Documento::find()->from('documento tbl')->where(['fecha'=>$subquery])->orderBy('codigo');
        
        // add conditions that should always apply here

        $dataProvider_estado = new ActiveDataProvider([
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
//            'codigo' => $this->codigo,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'codigo', $this->codigo])    
            ->andFilterWhere(['like', 'path', $this->path])            
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        $dataProvider_estado->pagination->pageSize=20;
        return $dataProvider_estado;
    }
    
    
    
         public function searchsolicitud($params) //DOCUMENTOS UNICOS
    {        
//----------------------------------- Funcionalidad por Id de Usuario                                                               
                         $query = Documento::find()->orderBy('id_categoria');                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  

        
        // add conditions that should always apply here

        $dataProvider_solicitud = new ActiveDataProvider([
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
            return $dataProvider_solicitud;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        return $dataProvider_solicitud;
    }
    
    
    
    
     public function searchcalidad($params) //DOCUMENTOS UNICOS
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
                
                        $sql = "select DISTINCT(d.id), d.nombre_archivo, d.codigo, d.id_usuario, d.fecha, d.id_aprobacion, d.id_categoria, d.id_tipo, d.path, d.version,
                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, d.obs_suscriptor, d.obs_calidad, d.obs_registros, d.obs_publicador,
                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
                        from documento d, aprobacion a
                        WHERE
                        d.id = a.id_documento                         
                        and d.estado = 3
                        and d.id not in (select distinct(id_original) from documento where id_original is not null)
                        group by d.id                        
                        order by d.id_categoria, d.fecha_aprobacion desc";
                        $query = Documento::findBySql($sql); 
                                                 
//----------------------------------- Fin Funcionalidad por Id de Usuario  

        
        // add conditions that should always apply here

        $dataProvider_calidad = new ActiveDataProvider([
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
            return $dataProvider_calidad;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_categoria' => $this->id_categoria,
            'id_tipo' => $this->id_tipo,
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'id_aprobacion', $this->id_aprobacion]);

        return $dataProvider_calidad;
    }
    
    
    
//     public function searchpublicador2($params) //DOCUMENTOS VERSIONADOS
//    {        
////        $id_usuario = Yii::$app->user->identity['id'];
////        $query = \app\models\Documento::find()->where('id_original IS NOT NULL')->andWhere(['estado'=>3])->orderBy('id_original');
//        //----------------------------------- Funcionalidad por Id de Usuario                                                               
//                        $id_usuario_logueado = Yii::$app->user->identity['id'];
//                        //traigo el nombre completo del superivosr
//                        $sql = " select u.id, p.full_name  FROM
//                                      soporte.profile p, soporte.user u
//                                      where u.id = p.user_id
//                                      and u.id = '$id_usuario_logueado'";
//                        $data = Yii::$app->getDb()
//                                          ->createCommand($sql)
//                                          ->queryOne();
//                        $id = $data['id'];  
//                
//                        $sql = "select d.id, d.nombre_archivo, d.id_categoria, d.id_tipo, d.path, d.version,
//                        d.estado, d.fecha_aprobacion, d.id_original, d.id_custodio, d.id_usuario, d.obs_suscriptor, d.obs_publicador,
//                        a.id_usuario_autorizado, a.id_aprobador, a.id_documento
//                        from documento d, aprobacion a
//                        WHERE
//                        d.id = a.id_documento 
//                        AND d.id_original is not NULL
//                        and d.estado = 3
//                        order by d.id_categoria, d.id_original,  d.fecha_aprobacion asc";
//                        $query = Documento::findBySql($sql);  
//                                                 
////----------------------------------- Fin Funcionalidad por Id de Usuario  
//        
//        // add conditions that should always apply here
//
//        $dataProvider_publicador2 = new ActiveDataProvider([
//            'query' => $query,
//                'sort' => [
//                    'defaultOrder' => [
//                        'fecha' => SORT_ASC,
//                    ]
//                ],
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider_publicador2;
//        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'id_categoria' => $this->id_categoria,
//            'id_tipo' => $this->id_tipo,
//            'id_usuario' => $this->id_usuario,
//        ]);
//
//        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
//            ->andFilterWhere(['like', 'path', $this->path])
//            ->andFilterWhere(['like', 'fecha', $this->fecha])
//            ->andFilterWhere(['like', 'version', $this->version])
//            ->andFilterWhere(['like', 'estado', $this->estado]);
//
//        return $dataProvider_publicador2;
//    }
    
    
    
    
    
    
    
    
//    public function getDb2() {
//    return Yii::$app->db2;
//}
    
    
}
