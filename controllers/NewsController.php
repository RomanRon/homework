<?php

namespace app\controllers;

use app\models\News;
use app\models\NewsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUploads($id = null)
    {
        if ($id != null) {
            $model = $this->findModel($id);

            if (Yii::$app->request->post()) {
                $file = UploadedFile::getInstance($model, 'file');

                $model->img = $file->name;
                $model->save();
            }
            else
                $model = Null;
        } else {
            if (Yii::$app->request->post()) {
                $model = new News();
                $file = UploadedFile::getInstance($model, 'file');
                if ($model->img == Null) {
                    $model->img = $file->name;
                    $model->save();
                }
                 if ($model->name == Null) {
                     $model->name = 'Необхідно редагувати ім\'я';
                     $model->save();
                }
                 if ($model->img == Null) {
                     $model->short_description = 'Необхідно редагувати короткий опис';
                     $model->save();
                }
                 if ($model->description == Null) {
                     $model->description = 'Необхідно редагувати опис';
                     $model->save();
                }
            }
            else
                $model = Null;
        }
        if ($file->saveAs(Yii::getAlias('@webroot/uploads/' . $model->img))) {
            $addres = Yii::getAlias('@web/uploads/' . $file->name);
            return $this->asJson([
                'initialPreview' => [
                    $addres,
                ],
                'initialPreviewConfig' => [
                    'url' => Yii::getAlias('@webroot/uploads/'),
                    'extra' => [
                        'key' => $file->name,
                    ],
                ],
                'initialPreviewThumbTags' => [
                    [
                        '{CUSTOM_TAG_NEW}' => ' ',
                        '{CUSTOM_TAG_INIT}' => '<span class=\'custom-css\'>CUSTOM MARKUP</span>'
                    ]
                ],
                'append' => true,
            ]);
        } else {
            return $this->asJson([
                'error' => Yii::t('app', ''),
            ]);

        }
    }


    public function actionDeleteImage($id)
    {
        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('key') == 'update') {
                $model = $this->findModel($id);
                $model->img = Null;
                $model->save();
                unlink(Yii::getAlias('@webroot/uploads/' . Yii::$app->request->post('mode')));
                return $this->asJson(' ');
            } else {
                $a = Yii::$app->request->post('fileName');
                unlink(Yii::getAlias('@webroot/uploads/' . $a));
                return $this->asJson($id);
            }
        }
        print_r($_POST);
        return $this->asJson([
            'error' => Yii::t('app', 'Ви зробили щось неправильно!'),
        ]);

    }
}

