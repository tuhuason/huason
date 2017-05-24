<?php
namespace Admin\Controller;

class UploadController extends BaseController {

	public function uploadImgAction(){
		$error = '';

		$result =  D('Upload')->uploadfile($error);
		if($result){
			return $this->ajaxReturn(array("code"=>0,"msg"=>'上传成功',"data"=>array('src'=>$result,"title"=>'图片')));
		}else{
			return $this->ajaxReturn(array("code"=>1,"msg"=>$error));
		}
	}

}