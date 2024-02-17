<?php

function load_jquery($front = false) {



    //jquery & jquery ui files & path

    $path = 'js/jquery';



    $jquery = 'jquery-1.5.1.min.js';

    $jquery_ui = 'jquery-ui-1.8.11.custom.min.js';

    $jquery_ui_css = 'jquery-ui-1.8.11.custom.css';



    //load jquery ui css



    if ($front) {

        echo link_tag($path . '/' . $front . '/' . $jquery_ui_css);
    } else {

        echo link_tag($path . 'smart/' . $jquery_ui_css);
    }

    //load scripts

    echo load_script($path . '/' . $jquery);

    echo load_script($path . '/' . $jquery_ui);



    //colorbox

    $path = $path . '/colorbox';

    $colorbox = 'jquery.colorbox-min.js';

    $colorbox_css = 'colorbox.css';



    echo link_tag($path . '/' . $colorbox_css);

    echo load_script($path . '/' . $colorbox);
}

function load_script($path) {

    return '<script type="text/javascript" src="/' . $path . '"></script>';
}

function color_msaccess2hex($in) {
    $hex = str_pad(dechex($in), 6, 0, STR_PAD_LEFT);

    // Switch first and third byte
    $hex = mb_substr($hex, 4, 2) . mb_substr($hex, 2, 2) . mb_substr($hex, 0, 2);

    return '#' . $hex;
}

function color_hex2msaccess($in) {

    // Switch first and third byte
    $hex = mb_substr($in, 4, 2) . mb_substr($in, 2, 2) . mb_substr($in, 0, 2);
    return hexdec($hex);
}
function color_shade($couleur,$shade){
  $couleur=substr($couleur,1,6);
  $cl=explode('x',wordwrap($couleur,2,'x',3));
  $couleur='';
  for($i=0;$i<=2;$i++){
   $cl[$i]=hexdec($cl[$i]);
   $cl[$i]=$cl[$i]+$shade;
   if($cl[$i]<0) $cl[$i]=0;
   if($cl[$i]>255) $cl[$i]=255;
   $couleur.=StrToUpper(substr('0'.dechex($cl[$i]),-2));
  }
  return '#'.$couleur; 
}