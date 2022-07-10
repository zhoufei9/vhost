<?php
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller {
    public function _initialize()
    {

        $user = session('userInfo');
        if (!$user && !((CONTROLLER_NAME == 'Index' && ACTION_NAME == 'index') ||
         (CONTROLLER_NAME == 'User' && ACTION_NAME == 'login')
        )) {
            $this->redirect('User/login');
        }
        if ($user && (CONTROLLER_NAME == 'User' && ACTION_NAME == 'login')) {
            $this->redirect('Index/index');
        }
    }
}