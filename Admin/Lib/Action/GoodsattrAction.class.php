<?php

class GoodsattrAction extends CommonAction {

    public $attr_type_model;
    public $attr_mode;

    public function __construct() {
        parent::__construct();
        $this->$attr_type_model = M("goods_attr_type");
        $this->$attr_model = M("goods_attr");
    }

    public function index() {
        $this->display();
    }

    function add() {
        $data["attr_type_value"] = $_REQUEST["attr_type_value"];
    }

}
