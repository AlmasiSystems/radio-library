<?php
Zend_Loader::loadClass('Zend_Filter_HtmlEntities');

class My_View_Helper_CreateEventDescription {

    public function createEventDescription($event, $urls = false) {
        //controller => menu title pairs
		$output = ""; //html
		$f = new Zend_Filter_HtmlEntities();		

		if(isset($event['show_id']) && $event['show_id'] != 'NULL' && $event['show_id'] != NULL){
			$output .= '<strong>';
			if(isset($event['dj1_name'])){
			    $output .= $f->filter($event['dj1_name']);
		    }
			if(isset($event['dj2_name'])){
				$output .= $f->filter(' & ' . $event['dj2_name']);
			}
			if(isset($event['dj3_name'])){
				$output .= $f->filter(' & ' . $event['dj3_name']);
			}		
			$output .= '</strong><br />';
			if(isset($event['show_name'])){
				$output .= $f->filter($event['show_name']) . '<br />';
			}
			if(isset($event['alt_show_id'])){
				$output .= '<br /><div style="text-align: center">-Alternates With-</div><br ><strong>';
				if(isset($event['alt_dj1_name'])){
					$output .= $f->filter($event['alt_dj1_name']);
				}
				if(isset($event['alt_dj2_name'])){
					$output .= $f->filter(' & ' . $event['alt_dj2_name']);
				}
				if(isset($event['alt_dj3_name'])){
					$output .= $f->filter(' & ' . $event['alt_dj3_name']);
				}		
				$output .= '</strong><br />' . $f->filter($event['alt_show_name']) . '<br />';	
			
			}
		} else {
		    $output .= "No Show Selected";
	    }
        return $output;
    }
}
