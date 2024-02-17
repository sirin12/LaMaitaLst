<?php

function format_address($fields, $br = false) {
    if (empty($fields)) {
        return;
    }

    // Default format
    $default = "{firstname} {lastname}\n{company}\n{address_1}\n{address_2}\n{city}, {zone} {zip}\n{country}";

    // Fetch country record to determine which format to use
    $CI = &get_instance();
    $CI->load->model('location_model');
    $c_data = $CI->location_model->get_country($fields['country_id']);

    if (empty($c_data->address_format)) {
        $formatted = $default;
    } else {
        $formatted = $c_data->address_format;
    }

    $keys = preg_split("/[\s,{}]+/", $formatted);
    foreach ($keys as $id => $key) {
        $formatted = array_key_exists($key, $fields) ? str_replace('{' . $key . '}', $fields[$key], $formatted) : str_replace('{' . $key . '}', '', $formatted);
    }

    // remove any extra new lines resulting from blank company or address line
    $formatted = preg_replace('`[\r\n]+`', "\n", $formatted);
    if ($br) {
        $formatted = nl2br($formatted);
    }
    return $formatted;
}

function format_currency($value, $symbol = true) {
    $format = number_format($value, 2);

    if ($symbol)
        return $format . '€';
    else
        return $format;
}

function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return( $output_file );
}

function jpeg_to_base64($path) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents(base_url($path));
    return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
function formatNumber($number){
	$units = array('', 'K', 'M', 'G', 'T');
  	$number = max($number, 0);
    $pow = floor(($number ? log($number) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $number /= pow(1000, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($number,2) . ' ' . $units[$pow];
}
