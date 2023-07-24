<?php
class menu_template extends model
{
    protected $class_name = 'menu_template';

    public function menu_top() //lấy data menu trên
    {
        global $db;

        $menu = new menu();
        $menu->set('type', 0);

        $kq = array();
        $kq = $menu->list_by_type();
        $html = $this->render_menu_top($kq);

        return $html;
    }


    public function render_menu_top($kq) //render menu trên
    {
        $h = "<ul>";
        foreach ($kq as $item) {
            if ($item['level'] == 1) {
                $h .= '<li class="li-sub">
                            <a target="_self" href="'.$this->check_link($item['link']).'" title="'.$item['name'].'"><b>'.$item['name'].'</b>'.$item['description'].'</a>';
                if(COUNT($item['root_menu'])>0){
                    $h .= '<div class="wrap-sub">
                            <div class="item">
                             <ul class="sub">';

                             foreach($item['root_menu'] as $items){
                                $h .= '<li>
                                        <a target="_self" href="'.$this->check_link($items['link']).'" title="'.$items['name'].'">'.$items['name'].'</a>';
                                        if(COUNT($items['root_menu'])>0){
                                            $h .='<ul class="sub">';
                                            foreach($items['root_menu'] as $itemss){
                                                $h .= '<li>
                                                    <a target="_self" href="'.$this->check_link($itemss['link']).'" title="'.$itemss['name'].'">'.$itemss['name'].'</a>
                                                    </li>';
                                            }
                                            $h .='</ul>';
                                        }
                                $h .= '<li>';
                             }
                    $h.='</ul>
                        </div>
                        </div>';
                }
            }
        }
        $h .= '</ul>';
        return $h;
    }

    public function menu_bottom() //lấy data menu dưới
    {
        global $db;

        $menu = new menu();
        $menu->set('type', 1);

        $kq = array();
        $kq = $menu->list_by_type();
        $html = $this->render_menu_bottom($kq);

        return $html;
    }

    public function render_menu_bottom($kq) //render menu dưới
    {
        $h = "";
        foreach ($kq as $item) {
            $h .= '<div class="col-md-3 col-sm-6 col-xs-6">
                    <h3 class="title"><a href="'.$this->check_link($item['link']).'" title="'.$item['name'].'" target="_self">'.$item['name'].'</a></h3>';
                if(COUNT($item['root_menu'])>0){
                    $h .= '<ul>';
                        foreach($item['root_menu'] as $items){
                            $h .= '<li><a href="'.$this->check_link($items['link']).'" title="" target="_self">'.$items['name'].'</a></li>';
                        }
                    $h .= '</ul>';
                }
                $h .= '</div>';
        }
        return $h;
    }

    public function menu_suggest() //lấy data menu trên để render menu gợi ý ở phần cuối trang
    {
        global $db;

        $menu = new menu();
        $menu->set('type', 0);

        $kq = array();
        $kq = $menu->list_by_type();
        $html = $this->render_menu_suggest($kq);

        return $html;
    }

    public function render_menu_suggest($kq) //render menu gợi ý ở phần cuối trang
    {
        $h = "";
        foreach ($kq as $item) {
            $h .= '<li><a href="'.$this->check_link($item['link']).'">'.$item['name'].'</a></li>';
        }
        return $h;
    }

    public function check_link($url) //kiểm tra link ra trang ngoài hay link trong hệ thống
    {
        if (!preg_match('/^http(s)?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)) {
            $url = '/'.$url;
            return $url;
        }

        return $url;
    }

}
