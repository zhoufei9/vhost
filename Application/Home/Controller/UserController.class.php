<?php
namespace Home\Controller;
use Think\Controller;
use Think\Template;

class UserController extends BaseController {

    public function login() {
        $username = I('post.username');
        if ($username) {
            $user = M('users')->where('name = "' . $username . '"')->find();
            if($user) {
                session('userInfo', $user);
                $this->ajaxReturn(['code' => 0]);
            } else {
                $this->ajaxReturn(['code' => 10000, 'msg' => '账户不存在']);
            }
            $this->redirect('Index/index');
        } else {
            $this->display();
        }
    }

    public function loginOut() {
        if (getUid()) {
            session('userInfo', null);
        }
        $this->redirect('Index/index');
    }
}