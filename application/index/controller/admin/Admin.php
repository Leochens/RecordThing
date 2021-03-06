<?php
namespace app\index\controller\admin;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Admin extends Controller
{
    public function index()
    {
    	if($this->check())
    	{
    		$msg = '管理员'.Session::get('admin').'登录成功';
    	}else{
    		 $this->error('管理员未登陆,跳转至登陆页面',"index/admin.Login/index");
    	}
        $userList = $this->getAllUser();
        $recordList = $this->getAllRecords();

    	$this->assign([
    			'msg'=>$msg,
                'userList'=>$userList,
                'recordList'=>$recordList
    			]);
    	return $this->fetch();
    }
    private function getAllUser()
    {
        $userControl = model('index/admin/UserControl');
        //$userControl = new UserControl();
        $res = $userControl->getAllUser();
        return $res;
    }
    public function forbiddenUser()
    {
        $userControl = model('index/admin/UserControl');
        $user_id = getParam('user_id','请输入被禁言者的id');
        $res = $userControl -> forbiddenUser($user_id);
        if($res)
            $this->success('禁言成功');
        else
            $this->error('禁言失败');
    }
    public function unForbiddenUser()
    {
        $userControl = model('index/admin/UserControl');
        $user_id = getParam('user_id','请输入被要解禁者的id');
        $res = $userControl -> unForbiddenUser($user_id);
        if($res)
            $this->success('解禁成功');
        else
            $this->error('解禁失败');
    }
    private function getAllRecords(){
        $record = controller('index/record/Record');
        $res = $record->getAllRecords();
        return $res;
    }
    private function check()
    {
    	if(Session::has('admin')) 
    		return 1;
    	else 
    		return 0;
	}

    public function deleteRecord()
    {
        if(!$this->check())
            $this->error('管理员未登陆');
        else{
            $id = getParam('r_id','未获取到说说id');
            if(Db::table('records')->delete($id))
                $this->success('删除成功');
            else 
                $this->error('删除失败');
            
        }
    }
	public function logout(){
		Session::delete('user');
		$this->success('删除session成功','admin/Login');    //
        
        }

    
}
