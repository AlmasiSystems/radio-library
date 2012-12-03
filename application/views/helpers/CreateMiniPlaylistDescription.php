<?php
Zend_Loader::loadClass('Zend_Filter_HtmlEntities');

class My_View_Helper_CreateMiniPlaylistDescription {

    public function createMiniPlaylistDescription($playlist, $shows, $djs) {
        //controller => menu title pairs
		$output = ""; //html
		$f = new Zend_Filter_HtmlEntities();		

		$show = $shows[$playlist['show_id']];
		
		$output .= "<div class=\"mini_playlist\">";
		if (isset($playlist['image_url']) && $playlist['image_url'] != ''){
			$output .= '<div style="float: right; padding: 5px;">';
			$output .= '<img src="/public/phpThumb/phpThumb.php?w=200&src=' . $playlist['image_url'] .'" />';
			$output .= '</div>';
		}	
		$output .= "<strong>" . date("l m/d/Y", strtotime($playlist['date'])) . " <br /> @ " ;
		$output .= date("g:ia", strtotime($playlist['start_time'])) . " - " . date("g:ia", strtotime($playlist['end_time'])) . "</strong><br />";
		$output .= "<a class=\"show_name\" href=\"\">" . $playlist['show_name'] . "</a><br />";
		if (isset($djs[$show['dj1_id']]['dj_name'])){
			$output .= "<strong>" . $f->filter($djs[$show['dj1_id']]['dj_name']);
		}
		if (isset($djs[$show['dj2_id']]['dj_name'])){
			$output .= $f->filter(" & " . $djs[$show['dj2_id']]['dj_name']);
		}
		if (isset($djs[$show['dj3_id']]['dj_name'])){
			$output .= $f->filter(" & " . $djs[$show['dj3_id']]['dj_name']);
		}
		$output .= "</strong><br /><br />";
	
		if (isset($playlist['comments']) && $playlist['comments'] != ''){
			//$output .= $f->filter($playlist['comments']);
			$output .= $playlist['comments'];
		} else {
			$output .= $f->filter($show['description']);
		}
		
		$output .= "</div>";
        return $output;
    }
}
