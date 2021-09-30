<?php 
namespace app\models;
use Yii;

use yii\db\ActiveRecord;

//class Ticket extends ActiveRecord
class Usersoporte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
      return 'user';
    }

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->db2;
    }
} 