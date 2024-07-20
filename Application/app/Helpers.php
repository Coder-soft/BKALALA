<?php

// Format Bytes for uploads size
function formatBytes($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

// get file icon
function fileIcon($type)
{
    $types = array('jpeg', 'png', 'jpg', 'gif', 'pdf', 'doc', 'docx', 'xlx', 'xlsx', 'csv', 'txt', 'mp4', 'm4v', 'wmv', 'mp3', 'm4a', 'wav', 'apk', 'zip', 'rar');
    if (in_array($type, $types)) {
        return asset('images/icons/' . $type . '.png');
    } else {
        return asset('images/icons/unknown.png');
    }

}

// Short text
function shortertext($text, $chars_limit)
{
    if (strlen($text) > $chars_limit) {
        $new_text = substr($text, 0, $chars_limit);
        $new_text = trim($new_text);
        return $new_text . "...";
    } else {
        return $text;
    }
}
