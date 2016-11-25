<?php

namespace backend\controllers;

use Yii;
use common\models\Blog;
use backend\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\base\Exception;
use common\models\BlogCategory;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'myBehavior' => \backend\components\MyBehavior::className(),
//            'as access' => [
//                'class' => \backend\components\AccessControl::className(),
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('/blog/index')) {
            throw new ForbiddenHttpException('没有访问权限.');
        }
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Blog();
        // 调用validate，非save，save我们放在了事务中处理了
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 开启事务
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                $blogId = $model->id;
                $data = [];
                foreach ($model->category as $k => $v) {
                    // 数组形式[blog_id, category_id]，跟下面的batchInsert方法的第二个参数保持一致
                    $data[] = [$blogId, $v];
                }
                // 获取BlogCategory模型的所有属性和表名
                $blogCategory = new BlogCategory();
                $attributes = array_keys($blogCategory->getAttributes());
                $tableName = $blogCategory::tableName();
                // 批量插入栏目到BlogCategory::tableName()表
                Yii::$app->db->createCommand()->batchInsert(
                    $tableName,
                    $attributes,
                    $data
                )->execute();
                // 提交
                $transaction->commit();
                return $this->redirect(['index']);
            } catch (Exception $e) {
                // 回滚
                $transaction->rollBack();
                throw $e;
            }
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);

                $blogId = $model->id;
                $data = [];
                foreach ($model->category as $k => $v) {
                    $data[] = [$blogId, $v];
                }
                $blogCategory = new BlogCategory();
                $attributes = array_keys($blogCategory->getAttributes());
                $tableName = $blogCategory::tableName();

                // 先删除对应栏目
                $sql = "DELETE FROM `{$tableName}` WHERE `blog_id` = '{$blogId}'";
                Yii::$app->db->createCommand($sql)->execute();
                // 再批量插入栏目到BlogCategory::tableName()
                Yii::$app->db->createCommand()->batchInsert(
                    $tableName,
                    $attributes,
                    $data
                )->execute();
                $transaction->commit();
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {
            $model->category = BlogCategory::getRelationCategorys($id);
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
