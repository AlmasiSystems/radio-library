<?php

class My_View_Helper_CreateSubMenu {

    public function createSubMenu($controller) {
        //controller => menu title pairs
        $menu_items = array(
		    'schedule' => array(
                'Manage Seasons' => 'seasons', 
                'Manage Shows' => 'shows',
                'Manage Schedule' => 'schedule'
	            ),
            'playlists' => array(
                
                ),
            'music' => array(
                'Manage Albums' => 'albums', 
                'Manage Labels' => 'labels',
				'Recent Adds (week)' => 'recent',
				'Recent Adds (month)' => 'recent/view/month',
                'Spins Generator' => 'spins',
				'Publish Spins' => 'topspins'
                ),
            'blog' => array(
                
                ),
            'admin' => array(
                'Manage Users' => 'users',
                'Manage Website' => 'web'
                )             
            );
        
        $output = '';
        foreach($menu_items[$controller] as $title => $action){
            $output .= '<a href="/' . $controller . '/' . $action . '/">' . $title . '</a>';
        }
        $output .= "\n";
        return $output;
    }
}
