<?php
/**
 * Created by Kotyk Ihor
 * Date : 20.07.2022
 * Time : 12:35
 */

namespace app\Controllers;


use app\Models\TreeApplication;
use components\Controller;

class TreeController extends Controller
{

    public function actionMain()
    {
        $application = new TreeApplication();
        echo $this->ajax([
            'id' => $application->addTreeBranches(['title' => 'root', 'parent' => 0])
        ]);
    }

    public function actionAddNewBranches()
    {
        $application = new TreeApplication();
        echo $this->ajax([
            'id' => $application->addTreeBranches(['title' => $_POST['title'], 'parent' => $_POST['parent']])
        ]);
    }
}