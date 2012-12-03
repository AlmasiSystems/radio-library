<?php

class My_View_Helper_CreateMenu {

    public function createMenu($controllers, $c_controller = null) {
        //controller => menu title pairs
        if($c_controller == 'fundraiser'){
            $menu_items = array(
    			'fundraiser/premiums' => 'Premiums',
                'fundraiser/pledges' => 'Pledges',
    			'fundraiser/images' => 'Images'
                );
            $output = '';
            foreach($menu_items as $where => $title){
                $output .= '<a href="/' . $where . '/">' . $title . '</a>';
            }
            $output .= '<a href="/">Back to Library</a>';
        } else {
            $menu_items = array(
    			'shows' => 'Shows',
                'playlists' => 'Playlists',
    			'search' => 'Search',
                'music' => 'Music',
                'blog' => 'Blog',
                'admin' => 'Admin',
              	'schedule' => 'Schedule'
                );
            $output = '<a href="/">Home</a>';
            $controllers = (array)$controllers;
        
            foreach($menu_items as $controller => $title){
                if(in_array($controller, $controllers)){
                    $output .= '<a href="/' . $controller . '/">' . $title . '</a>';
                }
            }
            if(in_array('premiums', $controllers)){
                $output .= '<a href="http://money.kdvs.org">Money</a>';
            }
            
            $output .= '<a href="/archive">Archives</a>';
    		$output .= '<a href="/options">Options</a>';
        }

        $output .= '<a href="/auth/logout">Log Out</a>' . "\n";
        return $output;
    }
}
