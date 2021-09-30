<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistroSanitario;

/**
 * RegistroSanitarioSearch represents the model behind the search form of `app\models\RegistroSanitario`.
 */
class RegistroSanitarioSearch extends RegistroSanitario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'estado', 'copias'], 'integer'],
            [['codigo', 'producto', 'fecha_modificacion', 'modificacion', 'fecha_vigencia', 'path', 'fecha_publicacion', 'detalle_copias', 'status'], 'safe'],
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
//        $query = RegistroSanitario::find();
        
        $subquery = RegistroSanitario::find()->select('max(fecha_modificacion)')->where('codigo = tbl.codigo');
        $query = RegistroSanitario::find()->from('registro_sanitario tbl')->where(['fecha_modificacion'=>$subquery]);

        // add conditions that should always apply here

//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'fecha_modificacion' => SORT_DESC,
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
            'id_usuario' => $this->id_usuario,
            'estado' => $this->estado,
            'copias' => $this->copias,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'fecha_modificacion', $this->fecha_modificacion])
            ->andFilterWhere(['like', 'modificacion', $this->modificacion])
            ->andFilterWhere(['like', 'fecha_vigencia', $this->fecha_vigencia])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha_publicacion', $this->fecha_publicacion])
            ->andFilterWhere(['like', 'detalle_copias', $this->detalle_copias])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
    
        public function searchpublicador($params)
    {
        $query = RegistroSanitario::find();
        
//        $subquery = RegistroSanitario::find()->select('max(fecha_modificacion)')->where('codigo = tbl.codigo');
//        $query = RegistroSanitario::find()->from('registro_sanitario tbl')->where(['fecha_modificacion'=>$subquery]);

        // add conditions that should always apply here

//        $dataProvider_publicador = new ActiveDataProvider([
//            'query' => $query,
//        ]);
         $dataProvider_publicador = new ActiveDataProvider([
            'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'fecha_modificacion' => SORT_DESC,
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
            'id_usuario' => $this->id_usuario,
            'estado' => $this->estado,
            'copias' => $this->copias,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'fecha_modificacion', $this->fecha_modificacion])
            ->andFilterWhere(['like', 'modificacion', $this->modificacion])
            ->andFilterWhere(['like', 'fecha_vigencia', $this->fecha_vigencia])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'fecha_publicacion', $this->fecha_publicacion])
            ->andFilterWhere(['like', 'detalle_copias', $this->detalle_copias])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider_publicador;
    }
}
