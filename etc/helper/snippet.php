<?php

/**
 * Display human-readable information from a variable
 *
 * @param  mixed   $expression The expression to be displayed
 * @param  boolean $function   The function will use
 * @param  boolean $stop       Stop after displayed
 * @return void
 */
function debug($expression, $function = 'print_r', $stop = false)
{
    echo '<pre>';
    $function($expression);
    echo '</pre>';
    if ($stop) die();
}

/**
 * Format a local time/date in Bahasa Indonesia
 *
 * Modified from https://gist.github.com/Kristories/3509222
 *
 * @param  string  $format    The format of the outputted date string
 * @param  integer $timestamp Unix timestamp
 * @return string             Formatted date string
 */
function date_id($format, $timestamp = null)
{
    if (is_null($timestamp)) $timestamp = time();

    $F = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $M = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $l = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $D = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    $result = '';
    for ($i = 0, $len = strlen($format); $i < $len; $i++) {
        switch ($format[$i]) {
            case 'F':
                $result .= $F[date('n', $timestamp)];
                break;
            case 'M':
                $result .= $M[date('n', $timestamp)];
                break;
            case 'l':
                $result .= $l[date('w', $timestamp)];
                break;
            case 'D':
                $result .= $D[date('w', $timestamp)];
                break;

            default:
                $result .= date($format[$i], $timestamp);
                break;
        }
    }

    return $result;
}

/**
 * Format a human-readable formatted file size
 *
 * Originally from: https://jonlabelle.com/snippets/view/php/friendly-file-size-in-php
 *
 * @param  integer $file_size The number to format
 * @param  array   $options   The options
 * @return string  Formatted number
 */
function file_size_format($file_size, $options = [])
{
    isset($options['unit']) || $options['unit'] = 'byte';
    isset($options['standard']) || $options['standard'] = 'si';
    isset($options['width']) || $options['width'] = 'narrow';
    isset($options['prefix']) || $options['prefix'] = ' ';
    isset($options['decimals']) || $options['decimals'] = 2;
    isset($options['dec_point']) || $options['dec_point'] = '.';
    isset($options['thousands_sep']) || $options['thousands_sep'] = ',';

    $options['units'] = [
        'byte' => [
            'singular' => ['narrow' => 'B', 'wide' => 'byte'],
            'plural' => ['narrow' => 'B', 'wide' => 'bytes'],
        ],
        'bit' => [
            'singular' => ['narrow' => 'bit', 'wide' => 'bit'],
            'plural' => ['narrow' => 'bits', 'wide' => 'bits'],
        ],
    ];

    $options['standards'] = [
        'si' => [
            'narrow' => ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'],
            'wide' => ['', 'kilo', 'mega', 'giga', 'tera', 'peta', 'exa', 'zetta', 'yotta']
        ],
        'iec' => [
            'narrow' => ['', 'Ki', 'Mi', 'Gi', 'Ti', 'Pi', 'Ei', 'Zi', 'Yi'],
            'wide' => ['', 'kibi', 'mebi', 'gibi', 'tebi', 'pebi', 'exbi', 'zebi', 'yobi'],
        ],
    ];

    switch ($options['unit'] = strtolower($options['unit'])) {
        case 'bit':
        case 'bits':
        case 'b':
            $options['unit'] = 'bit';
            break;
        default:
            $options['unit'] = 'byte';
    }

    switch ($options['standard'] = strtolower($options['standard'])) {
        case 'i':
        case 'iec':
            $options['standard'] = 'iec';
            break;
        default:
            $options['standard'] = 'si';
    }

    switch ($options['width'] = strtolower($options['width'])) {
        case 'w':
        case 'wide':
            $options['width'] = 'wide';
            break;
        default:
            $options['width'] = 'narrow';
    }

    $factor = ($options['standard'] == 'si') ? 1000 : 1024;
    $i = 0;
    if ($options['unit'] == 'bit') {
        $file_size *= 8;
    }

    while ($file_size > $factor) {
        $file_size /= $factor;
        $i++;
    }

    $file_size = number_format($file_size, $options['decimals'], $options['dec_point'], $options['thousands_sep']);
    $n = $file_size == 0 || $file_size == 1 ? 'singular' : 'plural';
    $formatted_file_size = $file_size . $options['prefix'] . $options['standards'][$options['standard']][$options['width']][$i] . $options['units'][$options['unit']][$n][$options['width']];

    return $formatted_file_size;
}

/**
 * Check if request is an AJAX call
 *
 * BE careful!
 * Some headers can easily be spoofed. X-Requested-With is one of them as it's set by the client.
 *
 * @return boolean
 */
function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Create URL Slug from string
 *
 * Note: Taken from symfony's jobeet tutorial
 * http://symfony.com/legacy/doc/jobeet/1_4/en/08?orm=Doctrine
 *
 * @param  string $string
 * @return string
 */
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    if (function_exists('iconv'))
    {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('#[^-\w]+#', '', $text);

    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
}

/**
 * Create excerpt from string
 *
 * @param  String  $string
 * @param  integer $max_word
 * @param  integer $max_character
 * @return String
 */
function excerpt($string, $max_word = 0, $max_character = 0)
{
    // remove tags
    $string = strip_tags($string);

    // get first paragraph
    $string = preg_replace('~\R~u', "</p>", $string);
    $string = explode("</p>", $string)[0];

    // limit by word
    if ($max_word > 0)
        $string = implode(' ', array_slice(explode(' ', $string), 0, $max_word));

    // limit by character
    if ($max_character > 0)
        $string = substr($string, 0, strpos($string, ' ', $max_character));

    return $string;
}

/**
 * Forcing file to download using readfile
 *
 * Copied from: http://php.net/manual/en/function.readfile.php#example-2517
 *
 * @param  string $file The filename being read.
 */
function force_download($file)
{
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

/**
 * Get MIME Type
 *
 * Copied from: http://php.net/manual/en/function.finfo-file.php#example-2439
 *
 * @param  string $file File to be checked
 * @return string Mime Type
 */
function get_mime($file)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file);
    finfo_close($finfo);

    return $mime;
}

/**
 * Normalize a filesystem path.
 *
 * Replaces backslashes with forward slashes for Windows systems, and ensures
 * no duplicate slashes exist.
 *
 * Copied from: WORDPRESS/wp-includes/functions.php
 *
 * @param string $path Path to normalize.
 * @return string Normalized path.
 */
function normalize_path( $path )
{
    $path = str_replace( '\\', '/', $path );
    $path = preg_replace( '|/+|','/', $path );

    return $path;
}

/**
 * Convert seconds to something else :)
 *
 * This function requires PHP 5.3+
 * Copied from: http://stackoverflow.com/questions/8273804/convert-seconds-into-days-hours-minutes-and-seconds
 *
 * @param  Integer $seconds
 * @param  String  $format
 * @return String
 */
function second2time($seconds, $format)
{
    $date_1 = new DateTime("@0");
    $date_2 = new DateTime("@$seconds");

    return $date_1->diff($date_2)->format($format);
}

/**
 * Create Google-like Pagination
 *
 * Example:
 * $total_page = $totalPage;
 * $current_page = $currentPage;
 *
 * $pagination = pagination($current_page, $total_page);
 *
 * if ($pagination['start_page'] > 1) echo '&laquo; First';
 * for ($page = $pagination['start_page']; $page <= $pagination['end_page']; $page++) {
 *      if ($page == $current_page) {
 *          echo " <b>$page</b> ";
 *      } else {
 *          echo " $page ";
 *      }
 * }
 * if ($pagination['end_page'] < $total_page) echo 'Last &raquo;';
 *
 * @param  Integer $current_page
 * @param  Integer $total_page
 * @return Array of Integer
 */
function pagination($current_page, $total_page)
{
    $start_page = $current_page - 4;
    $end_page = $current_page + 4;

    if ($start_page <= 0) {
        $start_page = 1;
        $end_page -= ($current_page - 5);
    }

    if ($end_page > $total_page) {
        $end_page = $total_page;
    }

    $pagination = array(
        'start_page' => $start_page,
        'end_page' => $end_page,
    );

    return $pagination;
}

function baseurl()
{
    $baseurl  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    $baseurl .= '://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';

    return $baseurl;
}