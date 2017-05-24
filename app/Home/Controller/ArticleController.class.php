<?php
namespace Home\Controller;

class ArticleController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('文章')
            ->setIdentifier('article');

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        // 设置面包屑
        // $this->setCrumbs();
        $this->display('index');
    }

    public function articleAction()
    {
        if(IS_GET){
            $id = I('get.id','');

            $error = '';
            //更新文章点击数并查看文章详情
            $data = D('Index')->findOneArticle($id, $error);
            if(!$data){
                $this->error404Page();
                return;
            }else{
                //文章详情页里 获取最热和最新文章
                $hot_list = M('Article')->where("auditing = 1 and admin_id='%d'",session('admin_id'))->order('hit desc,addtime desc')->limit(10)->select();
                $new_list = M('Article')->where("auditing = 1 and admin_id='%d'",session('admin_id'))->order('comment desc')->limit(10)->select();
                $review = M('Review')->where("article_id='%d'",$id)->select();

                $this->assign(array(
                    'art' => $data,
                    'new_list' => $new_list,
                    'hot_list' => $hot_list,
                    'review' => $review
                ));
                $this->display('article');
            }
        }else{
            $this->indexAction();
        }
        
    }

    public function webFrontendAction()
    {
        $where =array(
            'auditing' => 1,
            'name'=>'前端',
            'admin_id' => session('admin_id')
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();
        
        $this->assign(array(
            'data' => $data,
            'tag' => '前端'
        ));
        $this->display('tags');
    }
    public function phpAction()
    {
        $where =array(
            'auditing' => 1,
            'name'=>'PHP',
            'admin_id' => session('admin_id')
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();

        $this->assign(array(
            'data' => $data,
            'tag' => 'PHP'
        ));
        $this->display('tags');
    }
    public function talkAction()
    {
        $where =array(
            'auditing' => 1,
            'name'=>'杂谈',
            'admin_id' => session('admin_id')
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();

        $this->assign(array(
            'data' => $data,
            'tag' => '杂谈'
        ));
        $this->display('tags');
    }

    public function lifeAction()
    {
        $where =array(
            'auditing' => 1,
            'name'=>'生活百科',
            'admin_id' => session('admin_id')
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();
        
        $this->assign(array(
            'data' => $data,
            'tag' => '生活百科'
        ));
        $this->display('tags');
    }

    public function pageAction(){
        if(IS_POST){
            $current_page = I('post.page/d');
            $num = I('post.num/d');;

            $Article = M('Article');

            //加载分页
            $total_page = $Article->where("auditing=1 and admin_id='%d'",session('admin_id'))->count();
            $data['data'] = $Article->join('category ON article.catid = category.catid')->where("auditing=1 and admin_id='%d'",session('admin_id'))->order('addtime desc,tag desc')->page($current_page.','.$num)->select();
            $data['total_page'] = ceil($total_page/$num);

            $this->successAjax($data);
        }
        return $this->error404Page();
    }

    public function searchAction(){
        if(IS_GET){
            $param = I('get.param/s');
            $search = D('Index')->search($param);

            $this->assign(array('search' => $search, 'param' => $param));
            $this->display('search');
        }
    }
}