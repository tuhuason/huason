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
                return false;
            }else{
                //文章详情页里 获取最热和最新文章
                $hot_list = M('Article')->field('id,title,hit,comment')->where("auditing = 1 and admin_id=1")->order('hit desc,addtime desc')->limit(10)->select();
                $new_list = M('Article')->field('id,title,hit,comment')->where("auditing = 1 and admin_id=1")->order('comment desc,addtime desc')->limit(10)->select();

                //上一篇文章
                $prev = M('Article')->field('id,title,hit,comment')->where("auditing = 1 and admin_id=1 and id<'%d'", $id)->order('id desc')->find();
                //下一篇文章
                $next = M('Article')->field('id,title,hit,comment')->where("auditing = 1 and admin_id=1 and id>'%d'", $id)->order('id asc')->find();

                $data['prev'] = $prev;
                $data['next'] = $next;
            
                $this->assign(array(
                    'art' => $data,
                    'new_list' => $new_list,
                    'hot_list' => $hot_list
                ));
                $this->display('article');
            }
        }else{
            $this->indexAction();
        }
        
    }

    public function webFrontendAction()
    {
        // 设置页面标示符
        $this->assign('identifier', 'article.web');

        $where =array(
            'auditing' => 1,
            'name'=>'前端',
            'admin_id' => 1
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
        $this->assign('identifier', 'article.php');
        $where =array(
            'auditing' => 1,
            'name'=>'PHP',
            'admin_id' => 1
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();

        $this->assign(array(
            'data' => $data,
            'tag' => 'PHP'
        ));
        $this->display('tags');
    }
    public function computerAction()
    {
        $this->assign('identifier', 'article.computer');
        $where =array(
            'auditing' => 1,
            'name'=>'计算机',
            'admin_id' => 1
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();

        $this->assign(array(
            'data' => $data,
            'tag' => '计算机'
        ));
        $this->display('tags');
    }

    public function lifeAction()
    {
        $this->assign('identifier', 'article.life');
        $where =array(
            'auditing' => 1,
            'name'=>'生活百科',
            'admin_id' => 1
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();
        
        $this->assign(array(
            'data' => $data,
            'tag' => '生活百科'
        ));
        $this->display('tags');
    }

    public function mysqlAction()
    {
        $this->assign('identifier', 'article.mysql');
        $where =array(
            'auditing' => 1,
            'name'=>'Mysql',
            'admin_id' => 1
        ); 
        $data = M('Article')->join('category ON article.catid = category.catid')->where($where)->order('tag desc,addtime desc')->select();
        
        $this->assign(array(
            'data' => $data,
            'tag' => 'Mysql'
        ));
        $this->display('tags');
    }
    
    public function pageAction(){
        if(IS_POST){
            $current_page = I('post.page/d');
            $num = I('post.num/d');;

            $Article = M('Article');
            $Art = new \Admin\Model\ArticleModel();
            
            //加载分页
            $total_page = $Article->where("auditing=1 and admin_id=1")->count();
            $data['data'] = $Art->pages($current_page, $num);
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