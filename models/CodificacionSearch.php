<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Codificacion;

/**
 * CodificacionSearch represents the model behind the search form of `app\models\Codificacion`.
 */
class CodificacionSearch extends Codificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ultimo_registro'], 'integer'],
            [['codigo_departamento', 'codigo_categoria', 'codigo_tipo', 'codigo', 'descripcion'], 'safe'],
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
        $query = Codificacion::find();

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
            'ultimo_registro' => $this->ultimo_registro,
        ]);

        $query->andFilterWhere(['like', 'codigo_departamento', $this->codigo_departamento])
            ->andFilterWhere(['like', 'codigo_categoria', $this->codigo_categoria])
            ->andFilterWhere(['like', 'codigo_tipo', $this->codigo_tipo])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        $dataProvider->pagination->pageSize=false;
        return $dataProvider;
    }
}
