<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Request;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $res = Db::name('msg')->order('id','desc')->select();
        $this->assign('res',$res);
        return view();
    }

    public function add()
    {
        return view();
    }

    public function save()
    {
        $data = Request::instance()->param();
        $validata = new \app\index\validate\msg();
        if (!$validata->check($data)){
            return $this->error($validata->getError());
        }
        $data['create_time'] = date('Y-m-d H:i:s');
        $res = Db::name('msg')->insert($data);
        if ($res){
            return $this->success('新增成功','/');
        }else{
            return $this->error('新增失败');
        }
    }

    public function del()
    {
        $param = Request::instance()->param();
        $ret = Db::name('msg')->where('id',$param['id'])->delete();
        if ($ret){
            return $this->success('删除成功','/');
        }else{
            return $this->error('删除失败');
        }
    }

    public function edit()
    {
        $param = Request::instance()->param();
        $ret = Db::name('msg')->where('id',$param['id'])->find();
        return $this->fetch('',[
            'ret'   =>  $ret
        ]);
    }

    public function update()
    {
        $param = Request::instance()->param();
        $ret = Db::name('msg')->where('id',$param['id'])->update(['content'=>$param['content']]);
        if ($ret){
            return $this->success('修改成功','/');
        }else{
            return $this->error('修改失败');
        }
    }

    public function search()
    {
        $param = Request::instance()->param();
        $ret = Db::name('msg')->where('content','like','%'.$param['keywords'].'%')->select();
        return $this->fetch('index',[
            'res'   =>  $ret
        ]);
    }

}
