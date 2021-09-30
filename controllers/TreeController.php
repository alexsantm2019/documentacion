<?php 


namespace app\controllers;

use Yii;
use app\models\Tree;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class TreeController extends Controller
{

    /**
     * Lists all Tree models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$query = ::find();
        $query = \app\models\Documento::find();
        
        //$query = \app\models\Documento::find()->where(['=!',['id_original' => null]]); 
//        $query = \app\models\Documento::find()->where('id_original IS NOT NULL');
//        $query = \app\models\Documento::find()->where(['id_original' => null]); 
//        print_r($query); die();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}