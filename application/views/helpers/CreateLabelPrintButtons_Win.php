<?php
Zend_Loader::loadClass('Zend_Filter_HtmlEntities');

class My_View_Helper_CreateLabelPrintButtons_Win {

    public function CreateLabelPrintButtons_Win($album, $url = false) {
        $output = "";
		$f = new Zend_Filter_HtmlEntities();
		$output .= "
			<script language='VBScript'>
				Sub Btn".$album['id']."_onclick()
					Dim DymoAddIn, DymoLabel
					Set DymoAddIn = CreateObject(\"DYMO.DymoAddIn\")
					Set DymoLabel = CreateObject(\"DYMO.DymoLabels\")
					DymoAddIn.Open \"C:\Documents and Settings\All Users\Documents\DYMO Label\Label Files\kdvs_music.lwt\"\n";
					
		$output .= '	DymoLabel.SetField "id","'. $album['id'] . '"'. "\n";
		$output .= '	DymoLabel.SetField "artist","'. $this->escaper($album['artist']) . '"'. "\n";
		$output .= '	DymoLabel.SetField "album","'. $this->escaper($album['title']) . ' ('.$this->escaper($album['label_name']).')"'. "\n";
		$output .= '	DymoLabel.SetField "genre","'. $this->escaper($album['genre']) . '"'. "\n";
		$output .= '	DymoLabel.SetField "add_date","'. date('m/d/Y', strtotime($album['add_datetime'])) . '"'. "\n";

		$output .= "		
					DymoAddIn.Print 1, TRUE
				End Sub
			</script>";
										
			
		$output .= '<input type="button" name="Btn'.$album['id'].'" value="Print Label">';
        return $output;
    }
	function escaper($string){
		$new_string = '';
		$new_string .= str_replace('"', '""', $string);
		return $new_string;
	}
	
	/*    public function CreateLabelPrintButtons($album, $url = false) {
        $output = "";
		$f = new Zend_Filter_HtmlEntities();
		$output .= "
			<script language='VBScript'>
				Sub Btn".$album['id']."_onclick()
					Dim DymoAddIn, DymoLabel
					Set DymoAddIn = CreateObject(\"DYMO.DymoAddIn\")
					Set DymoLabel = CreateObject(\"DYMO.DymoLabels\")
					DymoAddIn.Open \"C:\Documents and Settings\All Users\Documents\DYMO Label\Label Files\kdvs_music.lwt\"\n";
					
		$output .= '	DymoLabel.SetField "id","'. $album['id'] . '"'. "\n";
		$output .= '	DymoLabel.SetField "artist","'. $this->escaper($album['artist']) . '"'. "\n";
		$output .= '	DymoLabel.SetField "album","'. $this->escaper($album['title']) . ' ('.$this->escaper($album['label_name']).')"'. "\n";
		$output .= '	DymoLabel.SetField "genre","'. $this->escaper($album['genre']) . '"'. "\n";
		$output .= '	DymoLabel.SetField "add_date","'. date('m/d/Y', strtotime($album['add_datetime'])) . '"'. "\n";

		$output .= "		
					DymoAddIn.Print 1, TRUE
				End Sub
			</script>";
										
			
		$output .= '<input type="button" name="Btn'.$album['id'].'" value="Print Label">';
        return $output;
    }
	function escaper($string){
		$new_string = '';
		$new_string .= str_replace('"', '""', $string);
		return $new_string;
	}
	*/
	
	
	
}
