<?php

class My_View_Helper_CreateGenreList {

    public function createGenreList($show) {
        //controller => menu title pairs
        $genres = array(
          	'genre_metal' => 'Metal',
			'genre_international' => 'International',
			'genre_reggae' => 'Reggae',
			'genre_classical' => 'Classical',
			'genre_eclectic' => 'Eclectic',
			'genre_hardcore' => 'Hardcore',
			'genre_jazz' => 'Jazz',
			'genre_folk' => 'Folk',
			'genre_rock' => 'Rock',
			'genre_indie' => 'Indie',
			'genre_blues' => 'Blues',
			'genre_industrial' => 'Industrial',
			'genre_punk' => 'Punk',
			'genre_hiphop' => 'Hip Hop',
			'genre_latin' => 'Latin',
			'genre_noise' => 'Noise',
			'genre_experimental' => 'Experimental', 
			'genre_other' => $show['genre_other']		
            );
        
        $output = '';
		$show = (array)$show;
        foreach($show as $key => $value){
			if(isset($genres[$key]) && $value){
	            if($output != ''){
					$output .= ', ';
				}
				$output .= $genres[$key];
			}
        }
        $output .= "\n";
        return $output;
    }
}
