<?php
namespace app\index\controller\user;
use think\Controller;
use think\Db; 
use think\Request;
use think\Session;
/**
 * @Author: Administrator
 * @Date:   2018-05-10 08:59:08
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-05-10 13:11:35
 */

//登陆程序
class Login extends Controller{

	private $e;
	public function _initialize(){
    	$this->e = controller('index/record/Record');
	}
	public function index(){
		//$this->login();
		
		return $this->fetch();
	}



    /**
     * 登录
     * @return [type] [description]
     */
    
    public function login()
    {
    	$req=Request::instance();
    	$data=$req->param();
    	if($this->isUser($data))
    	{
    		//echo "<br>用户".$data['name']."登录成功";
    	
    		Session::set('user',$data['name']);
    		$this->success("<br>用户".$data['name']."登录成功",'user/index');
    		return 1;
    	}else{
    		$this->error("<br>用户登录失败，用户名或密码错误");
    		return 0;
    	}
	}

	/**
	 * 判断数据库内是否有这个管理员
	 * @param  [type]  $e [获得的参数]
	 * @return boolean    [1 是管理员 0 未找到管理员]
	 */
	private function isUser($e){
		$res = Db::table('users')
			->where('name',$e['name'])
			->where('password',$e['password'])
			->find();
		//print_r($res);
		if($res)
			return 1;
		else
			return 0;
	}


}