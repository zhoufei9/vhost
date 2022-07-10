<?php
namespace Htai\Controller;
use Think\Controller;
use Think\Template;

class UserController extends Controller {
    public function login()
    {

        $this->assign('famousWord', 1);

        // 或者批量赋值
        $this->assign([
            'name'  => 'ThinkPHP',
            'email' => 'thinkphp@qq.com'
        ]);

        // 模板输出
        $this->display();
    }

    public function lists()
    {

        $list = M('users')->select();
        $this->assign('list', $list);

        // 模板输出
        $this->display();
    }

    public function userTable()
    {
        $page = I('get.page', 1);
        $limit = I('get.limit', 10);

        $roleArr = [
            1 => '前台用户',
            2 => '后台用户',
            3 => '管理员',
        ];

        $start = $limit * ($page -1);
        $list = M('users')->limit($start, $limit)->select();
        foreach ($list as &$v) {
            unset($v['password']);
            $v['role'] = $roleArr[$v['role']];
        }
        $count = M('users')->count();
        $this->ajaxReturn(['code' => 0, 'count' => $count, 'data' => $list]);
    }

    public function passwordMd5PlusSalt($password)
    {
         return md5('-2-' . $password . '.');
    }

    public function add()
    {
        $data['name'] = I('post.username');
        if ($data['name']) {
            $data['role'] = I('post.role');
            $data['phone'] = I('post.phone');
            $data['email'] = I('post.email');
            $data['password'] = $_POST['password'] ? $this->passwordMd5PlusSalt($_POST['password']) : '';
            M('users')->add($data);
            $this->ajaxReturn(['code' => 0]);
        } else {
            $this->display();
        }
    }
}