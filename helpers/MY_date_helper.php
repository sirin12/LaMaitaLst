<?php

setlocale(LC_TIME, 'fr_FR.utf-8', 'fr');
/*
  --------------------------------------------------------------------------------
  Functions for PHPMaker 2.0
  (C)2002-2004 e.World Technology Limited. All rights reserved.
  --------------------------------------------------------------------------------
 */

// PHPMaker DEFAULT_DATE_FORMAT:
/* "yyyy/mm/dd"(default)  or "mm/dd/yyyy" or "dd/mm/yyyy" */
define("DEFAULT_DATE_FORMAT", "dd/mm/yyyy");

// FormatDateTime
/*
  Format a timestamp, datetime, date or time field from MySQL
  $namedformat:
  0 - General Date,
  1 - Long Date,
  2 - Short Date (Default),
  3 - Long Time,
  4 - Short Time,
  5 - Short Date (yyyy/mm/dd),
  6 - Short Date (mm/dd/yyyy),
  7 - Short Date (dd/mm/yyyy)

 */
function FormatDateTime($ts, $namedformat) {
    $DefDateFormat = str_replace("yyyy", "%Y", DEFAULT_DATE_FORMAT);
    $DefDateFormat = str_replace("mm", "%m", $DefDateFormat);
    $DefDateFormat = str_replace("dd", "%d", $DefDateFormat);
    if (is_numeric($ts)) { // timestamp
        switch (strlen($ts)) {
            case 14:
                $patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
                break;
            case 12:
                $patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
                break;
            case 10:
                $patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
                break;
            case 8:
                $patt = '/(\d{4})(\d{2})(\d{2})/';
                break;
            case 6:
                $patt = '/(\d{2})(\d{2})(\d{2})/';
                break;
            case 4:
                $patt = '/(\d{2})(\d{2})/';
                break;
            case 2:
                $patt = '/(\d{2})/';
                break;
            default:
                return $ts;
        }
        if ((isset($patt)) && (preg_match($patt, $ts, $matches))) {
            $year = $matches[1];
            $month = @$matches[2];
            $day = @$matches[3];
            $hour = @$matches[4];
            $min = @$matches[5];
            $sec = @$matches[6];
        }
        if (($namedformat == 0) && (strlen($ts) < 10))
            $namedformat = 2;
    }
    elseif (is_string($ts)) {
        if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) { // datetime
            $year = $matches[1];
            $month = $matches[2];
            $day = $matches[3];
            $hour = $matches[4];
            $min = $matches[5];
            $sec = $matches[6];
        } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $ts, $matches)) { // date
            $year = $matches[1];
            $month = $matches[2];
            $day = $matches[3];
            if ($namedformat == 0)
                $namedformat = 2;
        }
        elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) { // time
            $hour = $matches[2];
            $min = $matches[3];
            $sec = $matches[4];
            if (($namedformat == 0) || ($namedformat == 1))
                $namedformat = 3;
            if ($namedformat == 2)
                $namedformat = 4;
        }
        else {
            return $ts;
        }
    } else {
        return $ts;
    }
    if (!isset($year))
        $year = 0; // dummy value for times
    if (!isset($month))
        $month = 1;
    if (!isset($day))
        $day = 1;
    if (!isset($hour))
        $hour = 0;
    if (!isset($min))
        $min = 0;
    if (!isset($sec))
        $sec = 0;
    $uts = @mktime($hour, $min, $sec, $month, $day, $year);
    if ($uts == -1) { // failed to convert
        $year = substr_replace("0000", $year, -1 * strlen($year));
        $month = substr_replace("00", $month, -1 * strlen($month));
        $day = substr_replace("00", $day, -1 * strlen($day));
        $hour = substr_replace("00", $hour, -1 * strlen($hour));
        $min = substr_replace("00", $min, -1 * strlen($min));
        $sec = substr_replace("00", $sec, -1 * strlen($sec));
        $DefDateFormat = str_replace("yyyy", $year, DEFAULT_DATE_FORMAT);
        $DefDateFormat = str_replace("mm", $month, $DefDateFormat);
        $DefDateFormat = str_replace("dd", $day, $DefDateFormat);

        switch ($namedformat) {
            case 0:
                return $DefDateFormat . " $hour:$min:$sec";
                break;
            case 1://unsupported, return general date
                return utf8_encode($DefDateFormat);
                break;
            case 2:
                return $DefDateFormat;
                break;
            case 3:
                if (intval($hour) == 0)
                    return "12:$min:$sec AM";
                elseif (intval($hour) > 0 && intval($hour) < 12)
                    return "$hour:$min:$sec AM";
                elseif (intval($hour) == 12)
                    return "$hour:$min:$sec PM";
                elseif (intval($hour) > 12 && intval($hour) <= 23)
                    return (intval($hour) - 12) . ":$min:$sec PM";
                else
                    return "$hour:$min:$sec";
                break;
            case 4:
                return "$hour:$min:$sec";
                break;
            case 5:
                return "$year/$month/$day";
                break;
            case 6:
                return "$day/$month/$year  $hour:$min:$sec";
                break;
            case 7:
                return "$day/$month/$year";
                break;

            case 8:
                return "$day";
                break;
        }
    } else {
        switch ($namedformat) {
            case 0:
                return strftime($DefDateFormat . " %H:%M:%S", $uts);
                break;
            case 1:
                return utf8_encode(strftime("%A %d %B  %Y ", $uts));
                break;
            case 2:
                return  strftime("%d %B  %Y ", $uts);
                break;
            case 3:
                return strftime("%I:%M:%S %p", $uts);
                break;
            case 4:
                return strftime("%H:%M:%S", $uts);
                break;
            case 5:
                return strftime("%Y/%m/%d", $uts);
                break;
            case 6:
                return strftime("%d/%m/%Y  %H:%M:%S", $uts);
                break;
            case 7:
                return strftime("%d/%m/%Y", $uts);
                break;
            case 8:
                return utf8_encode(strftime("%d %B  %Y ", $uts));
                break;
            case 9:
                return "$day";
                break;
            case 10:
                return strftime("%B", $uts);
                break;
            case 11:
                return strftime("%H", $uts);
                break;
            case 12:
                return strftime("%M", $uts);
                break;
            case 13:
                    return strftime("%Y ", $uts);
                    break;
            case 14:
                    return "$month";
                    break;
        }
    }
}

// Convert a date to MySQL format
function DateToMysqlFormat($dateStr) {
    @list($datePt, $timePt) = explode(" ", $dateStr);
    $arDatePt = explode("/", $datePt);
    if (count($arDatePt) == 3) {
        switch (DEFAULT_DATE_FORMAT) {
            case "yyyy/mm/dd":
                list($year, $month, $day) = $arDatePt;
                break;
            case "mm/dd/yyyy":
                list($month, $day, $year) = $arDatePt;
                break;
            case "dd/mm/yyyy":
                list($day, $month, $year) = $arDatePt;
                break;
        }
        return trim($year . "-" . $month . "-" . $day . " " . $timePt);
    } else {
        return $dateStr;
    }
}

function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber) {
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $dateArr = array();

    do {
        if (date("w", $startDate) != $weekdayNumber) {
            $startDate += (24 * 3600); // add 1 day
        }
    } while (date("w", $startDate) != $weekdayNumber);


    while ($startDate <= $endDate) {
        $dateArr[] = date('Y-m-d', $startDate);
        $startDate += (7 * 24 * 3600); // add 7 days
    }

    return($dateArr);
}

function format_date($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d = explode('-', $date);

        $m = Array(
            'January'
            , 'February'
            , 'March'
            , 'April'
            , 'May'
            , 'June'
            , 'July'
            , 'August'
            , 'September'
            , 'October'
            , 'November'
            , 'December'
        );

        return $m[$d[1] - 1] . ' ' . $d[2] . ', ' . $d[0];
    } else {
        return false;
    }
}

function reverse_format($date) {
    if (empty($date)) {
        return;
    }

    $d = explode('-', $date);

    return "{$d[1]}-{$d[2]}-{$d[0]}";
}

function format_ymd($date) {
    if (empty($date) || $date == '00-00-0000') {
        return '';
    } else {
        $d = explode('-', $date);
        return $d[2] . '-' . $d[0] . '-' . $d[1];
    }
}

function format_mdy($date) {
    if (empty($date) || $date == '0000-00-00') {
        return '';
    } else {
        return date('m-d-Y', strtotime($date));
    }
}

function format_dmy($date) {
    if (empty($date) || $date == '00-00-0000') {
        return '';
    } else {
        $date = substr($date, 0, 10);
        $d = explode('-', $date);
        return $d[2] . '/' . $d[1] . '/' . $d[0];
    }
}

function getFrenchDate($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d1 = explode(' ', $date);
		$d = explode('-', $d1[0]);
        $m = Array(
            "Janvier"
            , "Février"
            , "Mars"
            , 'Avril'
            , 'Mai'
            , 'Juin'
            , 'Juillet'
            , "Août"
            , "Septembre"
            , "Octobre"
            , "Novembre"
            , "Décembre"
        );

        return $d[2] . ' ' . $m[$d[1] - 1] . ' ' . $d[0];
    } else {
        return false;
    }
}

function getFrenchcreated($date) {
    if ($date != '' && $date != '0000-00-00') {
		$esp=explode(' ',$date);
        $d = explode('-', $esp[0]);

        $m = Array(
            "Janvier"
            , "Février"
            , "Mars"
            , 'Avril'
            , 'Mai'
            , 'Juin'
            , 'Juillet'
            , "Août"
            , "Septembre"
            , "Octobre"
            , "Novembre"
            , "Décembre"
        );

        return $d[2] . ' ' . $m[$d[1] - 1] . ' ' . $d[0];
    } else {
        return false;
    }
}
function getarabcreated($date) {
    if ($date != '' && $date != '0000-00-00') {
		$esp=explode(' ',$date);
        $d = explode('-', $esp[0]);

        $m = Array(
            "جانفي"
            , "فيفري"
            , "مارس"
            , 'أفريل'
            , 'ماي'
            , 'جوان'
            , 'جويلية'
            , "أوت"
            , "سبتمبر"
            , "أكتوبر"
            , "نوفمبر"
            , "ديسمبر"
        );

        return '<span style="float:right; padding-left:2px;"> '.$d[2].' </span> '.' ' .$m[$d[1] - 1] . ' ' . $d[0];
    } else {
        return false;
    }
}

function getFrenchMonth($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d = explode('-', $date);

        $m = Array(
            "Janvier"
            , "Février"
            , "Mars"
            , 'Avril'
            , 'Mai'
            , 'Juin'
            , 'Juillet'
            , "Août"
            , "Septembre"
            , "Octobre"
            , "Novembre"
            , "Décembre"
        );

        return $m[$d[1] - 1];
    } else {
        return false;
    }
}

function getFrenchMonthshort($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d = explode('-', $date);

        $m = Array(
            "Jan"
            , "Fév"
            , "Mar"
            , 'Avr'
            , 'Mai'
            , 'Juin'
            , 'Juil'
            , "Aoû"
            , "Sep"
            , "Oct"
            , "Nov"
            , "Déc"
        );

        return $m[$d[1] - 1];
    } else {
        return false;
    }
}
function getarabMonthshort($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d = explode('-', $date);

        $m = Array(
            "جانفي"
            , "فيفري"
            , "مارس"
            , 'أفريل'
            , 'ماي'
            , 'جوان'
            , 'جويلية'
            , "أوت"
            , "سبتمبر"
            , "أكتوبر"
            , "نوفمبر"
            , "ديسمبر"
        );

        return $m[$d[1] - 1];
    } else {
        return false;
    }
}

function getday($date) {
    if ($date != '' && $date != '0000-00-00') {
		$esp = explode(' ', $date);
        $d = explode('-', $esp[0]);


        return $d[2];
    } else {
        return false;
    }
}
function getyear($date) {
    if ($date != '' && $date != '0000-00-00') {
		$esp = explode(' ', $date);
        $d = explode('-', $esp[0]);


        return $d[0];
    } else {
        return false;
    }
}

function getFrenchDay($date) {
    if ($date != '' && $date != '0000-00-00') {
        $date = date_create_from_format('Y-m-d', $date);
        $d = $date->format('N');

        $day = Array(
            "Lundi"
            , "Mardi"
            , "Mercredi"
            , 'Jeudi'
            , 'Vendredi'
            , 'Samedi'
            , 'Dimanche'
        );

        return $day[$d - 1];
    } else {
        return false;
    }
}

function getTime($date) {
    if ($date != '' && $date != '0000-00-00') {
        $d = explode(' ', $date);
        $h = explode(':', $d[1]);
        return $h[0] . ':' . $h[1];
    } else {
        return false;
    }
}

function Age($date_naissance) {
    $now = new DateTime();
    $birthday = new DateTime($date_naissance);
    $interval = $now->diff($birthday);

    return $interval->format('%y ans %m mois  %d jours');
}
function yeardiff($date1, $date2)
{
	$date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $interval = $date1->diff($date2);
    return $interval->format('%y');
}
function interval($date) {
    $now = new DateTime();
    $date = new DateTime($date);
    $interval = $now->diff($date);
    //$interval->format('%d days, %H hours, %I minutes, %S seconds');
    if ($interval->format('%y'))
        return $interval->format('%y') . ' years';

    if ($interval->format('%m'))
        return $interval->format('%m') . ' months';

    if ($interval->format('%d') && $interval->format('%d') < 7)
        return $interval->format('%d') . ' days';
    elseif ($interval->format('%d') > 0)
        return round(($interval->format('%d') / 7)) . ' week';

    if ($interval->format('%h') && $interval->format('%h') > 0)
        return $interval->format('%h') . ' hours';

    if ($interval->format('%i') && $interval->format('%i') > 0)
        return $interval->format('%i') . ' minutes';

    if ($interval->format('%s') && $interval->format('%s') > 0)
        return $interval->format('%s') . ' seconds';
}

function dayinterval($date) {
    $now = new DateTime();
    $date = new DateTime($date);
    $interval = $now->diff($date);

    return $interval->format('%d');
}

function timeInterval($date, $date1) {
    $date1 = new DateTime($date1);
    $date = new DateTime($date);
    $interval = $date1->diff($date);

    if ($interval->format('%H') > 0)
        return $interval->format('%H h %i min');
    else
        return $interval->format('%i min');
}

/* End of file welcome.php */
/* Location: ./system/application/helpers/MY_date_helper.php */
