<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;
use Common\XssHtml;
class DiaryModel extends BaseModel
{
    protected $trueTableName  = 'diary'; 

    // 
    public function findAll()
    {
        $Diary = M('Diary');
        $res = $Diary->where("admin_id='%d'", session('admin_id'))->select();

        if($res){
            return $res;
        }
        return false;
    }

    public function findOne($id, &$error='')
    {

        $Diary = M('Diary');
        $res = $Diary->where("id='%d'",$id)->find();

        if($res){
            $res['content'] = htmlspecialchars_decode($res['content']);
            return $res;
        }
        $error = '失败！';
        return false;
    }

    public function add($content, &$error='')
    {
        $Diary = M('Diary');

        $data = array(
            'content' => $content,
            'addtime' => time(),
            'admin_id' => session('admin_id'),
            'uptime' => time()
        );

        if($this->authority($error) === false){
            return false;
        }

        $res = $Diary->add($data);
        if($res){
            return true;
        }
        $error = '添加日记失败！';
        return false;
    }
    
    public function update($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Diary = M('Diary');
        $admin_id = session('admin_id');

        $filter = new XssHtml(htmlspecialchars_decode($data['content']));
        $data['content'] = htmlspecialchars($filter->getHtml());
        $data['uptime'] = time();
        $data['admin_id'] = $admin_id;
        $data['del'] = 0;

        $res = $Diary->where("id='%s'",$data['id'])->save($data);
        if($res){
            return true;
        }
        $error = '更新日记失败！';
        return false;
    }
    
    public function delete($id, &$error='')
    {

        $Diary = M('Diary');

        if($this->authority($error) === false){
            return false;
        }
        
        $res = $Diary->where("id='%d'",$id)->delete();

        if($res){
            return true;
        }
        $error = '删除日记失败！';
        return false;
    }
}