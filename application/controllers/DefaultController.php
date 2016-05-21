<?php

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        $model = new Recall();

        if (isset($_POST['recall'])) {
            $model->setAttributes($_POST['recall']);

            if ($model->validate()) {
                $model->image = $model->saveImage($_FILES['image']);
                
                if ($model->save()) {
                    $model = new Recall();
                }
            }
        }

        $recalls = Recall::model()->findAll(Application::$app->user->isGuest());

        return $this->render('views.default.index', ['recalls' => $recalls, 'model' => $model]);
    }

    public function actionUpdate()
    {
        if (Application::$app->user->isGuest())
            $this->redirect('default/index');

        if (isset($_GET['id']) and null !== ($model = Recall::model()->findByPk($_GET['id']))) {
            if (isset($_POST['recall'])) {
                $model->setAttributes($_POST['recall']);

                if ($model->validate()) {
                    if ($model->update()) {
                        $model = Recall::model()->findByPk($_GET['id']);
                    }
                }
            }

            return $this->render('views.default.update', ['model' => $model]);
        } else {
            $this->redirect('default/index');
        }
    }
    
    public function actionLogin()
    {
        if (isset($_POST['signin'], $_POST['signin']['login'], $_POST['signin']['password'])) {
            if (Application::$app->user->isGuest()) {
                Application::$app->user->login($_POST['signin']['login'], $_POST['signin']['password']);
            }
        }
        
        $this->redirect('default/index');
    }

    public function actionLogout()
    {
        if (!Application::$app->user->isGuest())
            Application::$app->user->logout();

        $this->redirect('default/index');
    }
    
    public function actionActivate()
    {
        if (!Application::$app->user->isGuest() and isset($_GET['id'])) {
            Recall::activate($_GET['id']);
        }

        $this->redirect('default/index');
    }

    public function actionDeactivate()
    {
        if (!Application::$app->user->isGuest() and isset($_GET['id'])) {
            Recall::deactivate($_GET['id']);
        }

        $this->redirect('default/index');
    }
}