<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu {
    
    var $CI = NULL;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function index($allMenus = "") {
        $arr = array();

        foreach ($allMenus as $key => $row) {
            if ($row['menu_code'] == MENU_CODE) {
                $arr[] = array(
                    'MN_ID'        => $row['id'],
                    // 'ROLES'     => $row["ROLES"],
                    'MN_PARENT'    => $row['parent_id'],
                    'MN_NAME'      => $row['name'],
                    // 'MN_TEASER' => $row->teaser,
                    'MN_LINK'      => $row['url'],
                    'MN_LEVEL'     => $row['level'],
                    'MN_SEQUENCE'  => $row['sequence'],
                    'MN_URL'       => $row['url'],
                    // 'MN_FLAG'   => $row["MN_FLAG"]
                    );
            }
        } 

        $new = array();
        foreach ($arr as $a)
            $new[$a['MN_PARENT']][] = $a;

        if(count($new) > 0) {
            $tree = $this->createTree($new, $new[0]); 
        } else {
            $tree = array();
        }
        
        return $tree;
    }

    public function createTree(&$list, $parent, &$path = "", $isFirst = TRUE) {
        $tree = array();
        
        foreach ($parent as $k => $l) {
            $path = $l["MN_LINK"];

            if (isset($list[$l['MN_ID']])){
                $l['CHILDREN'] = $this->createTree($list, $list[$l['MN_ID']], $path, $isFirst);
            }

            $tree[$l['MN_ID']] = $l;
        }

        $result = $tree;

        return $result;
    }

    public function generate($data) {
        $result   = "";

        if (isset($data["CHILDREN"])) {
            $arrData = $data["CHILDREN"];
        }
        else {
            $arrData = $data;
        }

        foreach ($arrData as $key => $row) {
            if (isset($row["CHILDREN"]) and count($row["CHILDREN"]) > 0) {
                $result .= '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">'. $row["MN_NAME"] .' <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        '. $this->generate($row) .'
                    </ul>
                </li>';
            } else {
                $result .= '<li><a href="'. site_url($row["MN_LINK"]) .'">'. $row["MN_NAME"] .'</a></li>';
            }
        }

        return $result;
    }

}