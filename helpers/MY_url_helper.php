<?php

function theme_url($uri) {

    $CI = & get_instance();

    return $CI->config->base_url('smart/themes/' . config_item('theme') . '/' . $uri);
}

//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag

function theme_img($uri, $tag = false) {

    if ($tag) {

        return '<img src="' . theme_url('assets/img/' . $uri) . '" alt="' . $tag . '" >';
    } else {

        return theme_url('assets/img/' . $uri);
    }
}

function theme_js($uri, $tag = false) {
    if ($tag) {

        return '<script type="text/javascript" src="' . theme_url('assets/js/' . $uri) . '" data-minify="1"></script>';
    } else {

        return theme_url('assets/js/' . $uri);
    }
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute

function theme_css($uri, $tag = false) {

    if ($tag) {

        $media = false;

        if (is_string($tag)) {

            $media = 'media="' . $tag . '"';
        }

        return '<link href="' . theme_url('assets/css/' . $uri) . '" type="text/css" rel="stylesheet" ' . $media . ' data-minify="1"/>';
    }



    return theme_url('assets/css/' . $uri);
}

function theme_assets($uri, $tag = false) {

    if ($tag) {

        switch ($tag) {
            case 'css':return '<link href="' . theme_url('assets/' . $uri) . '" type="text/css" rel="stylesheet" />';
            case 'js': return '<script type="text/javascript" src="' . theme_url('assets/' . $uri) . '"></script>';

            case 'img': return '<img src="' . theme_url('assets/' . $tag . '/' . $uri) . '" >';
        }
    }



    return theme_url('assets/' . $tag . '/' . $uri);
}

/* * *****************************************   WebSite   ********************************************************* */

function website_img($uri, $tag = false) {

    if ($tag) {

        return '<img src="' . theme_url('assets/website/img/' . $uri) . '" alt="' . $tag . '">';
    } else {

        return theme_url('assets/website/img/' . $uri);
    }
}

function website_js($uri, $tag = false) {

    if ($tag) {

        return '<script type="text/javascript" src="' . theme_url('assets/website/js/' . $uri) . '"></script>';
    } else {

        return theme_url('assets/website/js/' . $uri);
    }
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute

function website_css($uri, $tag = false) {

    if ($tag) {

        $media = false;

        if (is_string($tag)) {

            $media = 'media="' . $tag . '"';
        }

        return '<link href="' . theme_url('assets/website/css/' . $uri) . '" type="text/css" rel="stylesheet" ' . $media . '/>';
    }



    return theme_url('assets/website/css/' . $uri);
}

function website_assets($uri, $tag = false) {

    if ($tag) {

        switch ($tag) {
            case 'css':return '<link href="' . theme_url('assets/website/' . $tag . '/' . $uri) . '" type="text/css" rel="stylesheet" />';
            case 'js': return '<script type="text/javascript" src="' . theme_url('assets/website/' . $tag . '/' . $uri) . '"></script>';

            case 'img': return '<img src="' . theme_url('assets/website/' . $tag . '/' . $uri) . '" >';
        }
    }



    return theme_url('assets/website/' . $tag . '/' . $uri);
}

/* * ***************************************** Admin URL ******************************************************** */

function admin_url($uri) {
    $CI = & get_instance();
    return $CI->config->base_url( 'index.php/'.$CI->config->item('admin_folder') . '/' . $uri);
}
function admin_themes_url($uri) {
    $CI = & get_instance();
    return $CI->config->base_url('themes/' . $CI->config->item('admin_folder') . '/' . $uri);
}

//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag
function admin_img($uri, $tag = false) {
    if ($tag) {
        return '<img src="' . admin_themes_url('assets/img/'.$uri) . '" alt="' . $tag . '">';
    } else {
        return admin_themes_url('assets/img/'.$uri);
    }
}

function admin_assests($uri, $type) {
    
	if ($type == 'css')
		return '<link href="' . admin_themes_url($uri) . '" type="text/css" rel="stylesheet" />';
	else
		return '<script type="text/javascript" src="' . admin_themes_url($uri) . '"></script>';

}

/* * ************************************************************************************************************ */
function slidepicture($uri)
{
	$CI = & get_instance();
    if (is_file('uploads/sliders/' . $uri) && file_exists('uploads/sliders/' . $uri))
        return $CI->config->base_url('uploads/sliders/' . $uri);
    else {
            return theme_url('assets/img/no-photo-available.jpg');
    }
}

function userpicture($uri, $special = false) {
    $CI = & get_instance();
    if (is_file('uploads/images/' . $uri) && file_exists('uploads/images/' . $uri))
        return $CI->config->base_url('uploads/images/' . $uri);
    else {
        if ($special == "avatar")
            return theme_url('assets/img/user.jpg' );
        else
            return theme_url('assets/img/no-photo-available.jpg');
    }
}
function uploaded_picture($uri, $special = false) {
    $CI = & get_instance();
    if (is_file('uploads/' . $uri) && file_exists('uploads/' . $uri))
        return $CI->config->base_url('uploads/' . $uri);
    else {
        if ($special == "avatar")
            return theme_url('assets/img/user.jpg' );
        else
            return theme_url('assets/img/no-photo-available.jpg');
    }
}
function userfiles($uri, $special = false) {
    $CI = & get_instance();
    if (is_file('uploads/images/' . $uri) && file_exists('uploads/images/' . $uri))
        return $CI->config->base_url('uploads/images/' . $uri);
    else {
        if ($special == "avatar")
            return theme_url('assets/img/user.jpg' );
        else
            return theme_url('assets/img/no-photo-available.jpg');
    }
}
function uploads($uri){
$CI = & get_instance();
    if (is_file('uploads/' . $uri) && file_exists('uploads/' . $uri))
        return $CI->config->base_url('uploads/' . $uri);
    else {
            return theme_url('assets/img/no-photo-available.jpg');
    }
}
function productpicture($uri)
{
	$CI = & get_instance();
    if (is_file('uploads/products/' . $uri) && file_exists('uploads/products/' . $uri))
        return $CI->config->base_url('uploads/products/' . $uri);
    else {
		if (preg_match_all('/pdf|xls|doc|docs|xlsx/i', $uri,$matches))
		return theme_url('assets/img/file.png');
		else
		return theme_url('assets/img/no-photo-available.jpg');
    }
}
function primarypicture($files)
{
	 $files=json_decode($files); 
	 $i=0;
	 $found=false;
	 $primary=(object) array('filename'=>'');
	 if(is_array($files))
	 while(!$found and $i<sizeof($files))
	 {
		 if($files[$i]->type=='image'&& $files[$i]->primary)
		 {
			 $found=true;
			 $primary =$files[$i];
		 }
		 $i++;
	 }
	 
	 $CI = & get_instance();
    if (is_file('uploads/products/' . $primary->filename) && file_exists('uploads/products/' . $primary->filename))
        return $CI->config->base_url('uploads/products/' . $primary->filename);
    else 
		return theme_url('assets/img/no-photo-available.jpg');
   
}
function ambientpicture($Pfiles)
{
	 $files=json_decode($Pfiles); 
	 $i=0;
	 $found=false;
	 $primary=(object) array('filename'=>'');
	 if(is_array($files))
	 while(!$found and $i<sizeof($files))
	 {
		 if($files[$i]->type=='ambient_picture')
		 {
			 $found=true;
			 $primary =$files[$i];
		 }
		 $i++;
	 }
	 
	 $CI = & get_instance();
    if (is_file('uploads/products/' . $primary->filename) && file_exists('uploads/products/' . $primary->filename))
        return $CI->config->base_url('uploads/products/' . $primary->filename);
    else 
		 return primarypicture($Pfiles);
   
} 
function product_technical_file($files)
{
	 $files=json_decode($files); 
	 $i=0;
	 $found=false;
	 $primary=(object) array('filename'=>'');
	 if(is_array($files))
	 while(!$found and $i<sizeof($files))
	 {
		 if($files[$i]->type=='technicalfile'&& $files[$i]->primary)
		 {
			 $found=true;
			 $primary =$files[$i];
		 }
		 $i++;
	 }
	 
	 $CI = & get_instance();
    if (is_file('uploads/products/' . $primary->filename) && file_exists('uploads/products/' . $primary->filename))
        return $CI->config->base_url('uploads/products/' . $primary->filename);
    else 
		return false;
   
} 
function categoryppicture($files)
{
	 $files=json_decode($files); 
	 $i=0;
	 $found=false;
	 $primary=$files[0];
	 
	 $CI = & get_instance();
    if (is_file('uploads/categories/' . $primary) && file_exists('uploads/categories/' . $primary))
        return $CI->config->base_url('uploads/categories/' . $primary);
    else 
            return theme_url('assets/img/no-photo-available.jpg');
   
}
function categorypicture($uri)
{
	$CI = & get_instance();
    if (is_file('uploads/categories/' . $uri) && file_exists('uploads/categories/' . $uri))
        return $CI->config->base_url('uploads/categories/' . $uri);
    else {
            return theme_url('assets/img/no-photo-available.jpg');
    }
}
function albumpicture($uri)
{
	$CI = & get_instance();
    if (is_file('uploads/albums/' . $uri) && file_exists('uploads/albums/' . $uri))
        return $CI->config->base_url('uploads/albums/' . $uri);
    else 
		return theme_url('assets/img/no-photo-available.jpg');
    
}
function albumcover($Pfiles)
{
	 $files=json_decode($Pfiles); 
	 $i=0;
	 $found=false;
	 $primary=(object) array('filename'=>'');
	 if(is_array($files))
	 while(!$found and $i<sizeof($files))
	 {
		 if($files[$i]->cover)
		 {
			 $found=true;
			 $primary =$files[$i];
		 }
		 $i++;
	 }
	 
	 $CI = & get_instance();
    if (is_file('uploads/albums/' . $primary->filename) && file_exists('uploads/albums/' . $primary->filename))
        return $CI->config->base_url('uploads/albums/' . $primary->filename);
    else 
		 return albumpicture($files[0]->filename);
   
}

function documents_pdf($uri)
{
	$CI = & get_instance();
    if (is_file('uploads/documents/' . $uri) && file_exists('uploads/documents/' . $uri))
        return $CI->config->base_url('uploads/documents/' . $uri);
    else 
		return theme_url('assets/img/no-photo-available.jpg');
    
}
function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			'&.+?;'			=> '',
			'[^\w\d _-]'		=> '',
			'\s+'			=> $separator,
			'('.$q_separator.')+'	=> $separator
		);

		 $str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			 $str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		
		return trim(trim($str, $separator));
	}