<?php
/*
Plugin Name: PDFjs Shortcode
Description: View pdf's with pdf.js
Version: 1.0
Author: arul
License: GPLv2
*/




//tell wordpress to register the pdfjs-viewer shortcode
 add_shortcode("pdfjs-shortcode", "pdfjs_view_shortcode");


function pdfjs_view_shortcode($atts, $content = null)
{
    
    extract(shortcode_atts(array(
      'pdf_width' => '100%',
      'pdf_height' => '500px',
      'pdf_download' => 'true',
      'pdf_print' => 'true',
      'pdf_openfile'=>'true',  
   ), $atts));

   
     
     $viewer_base_url= plugin_dir_url( __FILE__ )."web/viewer.php";
     $pdfjs_url = $viewer_base_url."?file=".$content."&download=".$pdf_download."&print=".$pdf_print."&openfile=".$pdf_openfile;
     $iframe_code = '<iframe width="'.$pdf_width.'" height="'.$pdf_height.'" src="'.$pdfjs_url.'"></iframe> ';
    
    return $iframe_code ;
}



function auto_pdfjs_shortcode( $html, $id ) {

        preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i',$html, $result, PREG_PATTERN_ORDER);
        $result=$result[0];
        $ext = pathinfo($result[0], PATHINFO_EXTENSION);
        if($ext=='pdf')
        {
        return '[pdfjs-shortcode pdf_width=100% pdf_height=500px  pdf_download=true pdf_print=true pdf_openfile=false]'.$result[0].'[/pdfjs-shortcode]';
        }
        else
        {
        return $html;
        }

}

 add_filter( 'media_send_to_editor', 'auto_pdfjs_shortcode',10,3 );

?>