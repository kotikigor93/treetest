<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:23
 */

namespace app\Controllers;

class MainController extends Controller
{
    public function actionIndex()
    {
        $this->viewLoad('index', ['index' => 1]);
    }

    public function actionError()
    {
        $this->viewLoad('error');
    }
}