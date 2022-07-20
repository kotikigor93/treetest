<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:23
 */

namespace app\Controllers;

use app\Models\TreeApplication;
use components\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        $application = new TreeApplication();
        $list = $application->getTreeList();
        $data = [
            'view_title' => 'Home Page',
            'active_root_create' => !$list,
        ];
        $this->viewLoad(
            'index',
            $data,
        );
    }

    public function actionBranchesList()
    {
        $application = new TreeApplication();
        $list = $application->getTreeList();
        echo $this->ajax($list);
    }

    public function actionError()
    {
        $data = ['view_title' => 'Error 404',];
        $this->viewLoad(
            'error',
            $data
        );
    }
}