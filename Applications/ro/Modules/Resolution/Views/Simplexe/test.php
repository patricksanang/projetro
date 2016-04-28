<?php
public function soluzione_ottima() {
		$content='';
		$content.= $this->sol[0]->fractoa().':;';
		for ($j = 1; $j < $this->col - 1; $j++) $content.= $this->sol[$j]->fractoa().';';
		$content.= $this->sol[$j]->fractoa().';';
		//$content.= "</font><br>\n";
		//$content='';
		return $content;
	}
	public function soluzioni_ottime($verticeA, $verticeB) {
		$content='';
		$content.= sprintf("%s", $verticeA[0]->fractoa()).':;';
		for ($j = 1; $j < $this->col - 1; $j++) $content.= sprintf("%s;", $verticeA[$j]->fractoa()); $content.= $verticeA[$j]->fractoa().';';
		$content.= sprintf("%s ]<sup>T</sup> + (1-&lambda;) [ ", $verticeB[0]->fractoa());
		for ($j = 1; $j < $this->col - 1; $j++) $content.= $verticeB[$j]->fractoa().';';
		$content.= $verticeB[$j]->fractoa().';';
		//$content.= "</font><br>\n";*/
		//$content=';'.$verticeA[0]->fractoa().';'.$verticeB[0]->fractoa().';';
		return $content;
	}
	
public function soluzione_ottima() {
		$content.= sprintf("z<sup>*</sup> = %s, &nbsp;&nbsp;&nbsp; x<sup>*</sup> = [ ", $this->sol[0]->fractoa());
		for ($j = 1; $j < $this->col - 1; $j++) $content.= sprintf("%s, ", $this->sol[$j]->fractoa());
		$content.= sprintf("%s ]<sup>T</sup>", $this->sol[$j]->fractoa());
		$content.= "</font><br>\n";
		return $content;
	}
	public function soluzioni_ottime($verticeA, $verticeB) {
		$content = '<font color="#0000FF" size="+2">';
		$content.= sprintf("z<sup>*</sup> = %s, &nbsp;&nbsp;&nbsp; x<sup>*</sup> = &lambda; [ ", $verticeA[0]->fractoa());
		for ($j = 1; $j < $this->col - 1; $j++) $content.= sprintf("%s, ", $verticeA[$j]->fractoa());
		$content.= sprintf("%s ]<sup>T</sup> + (1-&lambda;) [ ", $verticeB[0]->fractoa());
		for ($j = 1; $j < $this->col - 1; $j++) $content.= sprintf("%s, ", $verticeB[$j]->fractoa());
		$content.= sprintf("%s ]<sup>T</sup>", $verticeB[$j]->fractoa());
		$content.= "</font><br>\n";
		return $content;
	}
	