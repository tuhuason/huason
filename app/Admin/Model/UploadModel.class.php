<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class UploadModel extends BaseModel
{
    public function uploadfile(&$error=''){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录

        if($this->authority($error) === false){
            return false;
        }
        
        //上传图片
        $info = $upload->upload();
        if(!$info) {
            $error = $upload->getError();
            return false;
        }else{
            foreach($info as $file){
                $path = './uploads/'.$file['savepath'].$file['savename'];
                $thumb_name = explode('.',$file['savename']);

                //生成300等比例缩略图
                $img = new \Think\Image();
                $thumb_path = './uploads/'.$file['savepath'].$thumb_name[0].'thumb.'.$thumb_name[1];
                $thumb = $img->open($path)->thumb(300, 300,\Think\Image::IMAGE_THUMB_SCALE)->save($thumb_path);

                //删除原图
                if($thumb){
                    unlink($path);
                }

                //返回缩略图
                return substr($thumb_path, 1);
            }
        }
    }
}