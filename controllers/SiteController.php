<?php

namespace app\controllers;

use app\helpers\ArrayHelper;
use app\models\Category;
use app\models\Comment;
use app\models\News;
use app\models\SignupForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($category = null)
    {
        $dateSort = Yii::$app->request->post('dateSort') ?: Yii::$app->request->get('date-sort');

        $categoryExist = null;
        $categoriesIds = [];
        if ($category) {
            $categoryExist = Category::findOne(['name' => $category]);
            if ($categoryExist) {
                $descendants = $categoryExist->getDescendants()->all();
                $categoriesIds = ArrayHelper::getColumn($descendants, 'id');
            }

            $categoriesIds[] = $categoryExist->id;
        }

        $additionalConditions = [] ;
        if ($categoriesIds) {
            $additionalConditions = ['in', 'category_id', $categoriesIds];
        }
        $query = News::find()->where(['active' => 1])->andWhere($additionalConditions);

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => News::PAGE_SIZE]);
        $pagination->pageSizeParam = false;
        $pagination->forcePageParam = false;

        if ($dateSort && in_array($dateSort, ['ASC', 'DESC'])) {
            $sortParam = $dateSort === 'ASC' ? SORT_ASC : SORT_DESC;
            $query->orderBy(['created' => $sortParam]);
        } else {
            $query->orderBy(['created' => SORT_DESC]);
        }

        $news = $query->with(['category'])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'selectedCategory' => $categoryExist,
            'news' => $news,
            'pagination' => $pagination,
            'dateSort' => $dateSort,
        ]);
    }

    public function actionNews($url)
    {
        $news = News::findOne(['url' => $url]);
        if (!$news) {
            Yii::$app->session->setFlash('error', '?????????????? ???? ??????????????');
            $this->goHome();
        }

        $newsComment = new Comment();
        if (Yii::$app->request->post() && Yii::$app->user->identity && $newsComment->load(Yii::$app->request->post())) {
            $newsComment->news_id = $news->id;
            $newsComment->user_id = Yii::$app->user->getId();
            if (!$newsComment->save()) {
                Yii::$app->session->setFlash('error', '?????????????????? ???????????? ?????? ???????????????? ??????????????????????');
            }
        }

        $comments = [];
        $pagination = null;

        $query = Comment::find()
            ->innerJoinWith(['news'])
            ->with(['user'])
            ->where(['news_id' => $news->id]);

        $countQuery = (clone $query)->count();
        if ($countQuery) {
            $pagination = new Pagination(['totalCount' => $countQuery, 'pageSize' => Comment::PAGE_SIZE]);
            $pagination->pageSizeParam = false;
            $pagination->forcePageParam = false;
            $comments = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }

        return $this->render('news', [
            'news' => $news,
            'comments' => $comments,
            'commentsPagination' => $pagination,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Login action.
     *
     * @return Response|string
     * @throws \Exception
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
