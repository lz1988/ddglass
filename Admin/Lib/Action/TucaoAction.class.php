<?php

/**
 * Class TucaoAction
 * @title 吐槽活动管理
 * @author lizhi
 * @create on 2015-06-17
 */
class TucaoAction extends CommonAction{

    //活动内容列表
    public function tucao_list()
    {
        import('@.ORG.Page');

        $name        = $_POST['username'];
        $create_time = $_POST['create_time'];

        if(!empty($name)){
            $arr['cms_user.username'] = array('like', "%" . $name . "%");
            $this->assign("username", $name);
        }


        if(!empty($create_time)){
            $arr['cms_ridicule.time'] = array('EGT',$create_time);
            $this->assign("create_time", $create_time);
        }

        $user = M("user");
        $count = $user->where($arr)->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")->count();
        $p = new Page($count, 100);
        $page = $p->show();

        $datalist = $user->where($arr)->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
            ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
            ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
            ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
            ->group("cms_ridicule.id")
            ->limit($p->firstRow . ',' . $p->listRows)->order('cms_ridicule.id desc')->select();
        //echo $user->getLastSql();


       /* echo '<pre>';
        print_r($datalist);*/

        $this->assign("page", $page);
        $this->assign("datalist", $datalist);
        $this->display("tucao_list");
    }

    /**
     * @title 获取用户点赞数
     */
    public function get_dianzan()
    {
        $tuchao_id = $_GET['id'];
        $ridicule_dianzan = M("ridicule_dianzan");
        $rs = $ridicule_dianzan->field("cms_ridicule_dianzan.*,cms_user.username")->join("right join cms_user on cms_user.openid=cms_ridicule_dianzan.openid")->where("tuchao_id = ".$tuchao_id)->select();
        //echo $ridicule_dianzan->getLastSql();
        $this->assign("rs",$rs);
        $this->display("get_dianzan");
    }
    /*@title 获取用户评论*/
    public function get_comment(){
        $tuchao_id=$_GET['id'];
        $ridicule_comment=M('RidiculeComment');
        $res=$ridicule_comment->field("cms_ridicule_comment.*,cms_user.username")
            ->join('right join cms_user on cms_user.openid=cms_ridicule_comment.openid')->where('tuchao_id = '.$tuchao_id)->select();
        $this->assign('rs',$res);
        $this->display('get_comment');
    }

}