<?php
Zend_Loader::loadClass('Zend_Filter_HtmlEntities');

class My_View_Helper_CreateLabelPrintButtons {

    public function CreateLabelPrintButtons($album, $url = false) {
        $output = "";
		$f = new Zend_Filter_HtmlEntities();
		$output .= '
			<input type="button" name="Btn'.$album['id'].'" value="Print Label"  
			onclick="labelScript('.	
				$album['id']. ",'" .
				$this->escaper($album['artist']) . "','" .
				$this->escaper($album['title']) . "','" .
				$this->escaper($album['genre']) . "','" .
				date('m/d/Y', strtotime($album['add_datetime'])) 

				. "'" . 
				')"  />';
        return $output;
    }
	function escaper($string){
		$new_string = '';
		$new_string .= str_replace('"', '""', $string);
		//$new_string .= str_replace(',', '', $string);
		return $new_string;
	}
	
}
