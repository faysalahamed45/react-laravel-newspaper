<?php
//url with query string
if ( ! function_exists('qUrl')) {
    function qUrl($queryArr = null, $route = null)
    {
        $route = $route ?? url()->current();
        return $route.qString($queryArr);
    }
}

//Search string get and set an url
if ( ! function_exists('qString')) {
    function qString($queryArr = null)
    {
        if (!empty($queryArr)) {
            $query = '';

            if (!empty($_GET)) {
                $getArray = $_GET;
                unset($getArray['page']);

                foreach ($queryArr as $qk => $qv) {
                    unset($getArray[$qk]);
                }

                $x = 0;
                foreach ($getArray as $gk => $gt) {
                    $query .= ($x != 0) ? '&' : '';
                    $query .= $gk.'='.$gt;
                    $x++;
                }
            }
            
            $y = 0;
            foreach ($queryArr as $qk => $qv) {
                if ($qv != null) {
                    $query .= ($y != 0 || $query != '') ? '&' : '';
                    $query .= $qk.'='.$qv;
                    $y++;
                }
            }

            return '?'.$query;

        } elseif (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != null) {
            return '?'.$_SERVER['QUERY_STRING'];
        }
    }
}

//Search Aray get to route redirect with get param
if ( ! function_exists('qArray')) {
    function qArray()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            return $_GET;
        } else {
            return null;
        }
    }
}

//Pagination per page
if ( ! function_exists('paginations')) {
    function paginations()
    {
        return ['15', '25', '50', '100'];
    }
}

//Pagination Message...
if ( ! function_exists('pagiMsg')) {
    function pagiMsg($data)
    {
        $msg = 'Showing ';
        $msg .= (($data->currentPage()*$data->perPage())-$data->perPage())+1;
        $msg .= ' to ';
        $msg .= ($data->currentPage()*$data->perPage()>$data->total()) ? $data->total() : $data->currentPage()*$data->perPage().' of '.$data->total();
        $msg .= ' row(s)';

        return $msg;
    }
}

//Date Format
if ( ! function_exists('dateFormat')) {
    function dateFormat($date, $time = null)
    {
        if ($time) {
            return date('d M, Y h:i A', strtotime($date));
        } else {
            return date('d M, Y', strtotime($date));
        }
    }
}

//Time Format
if ( ! function_exists('timeFormat')) {
    function timeFormat($date)
    {
        return date('h:i A',(strtotime($date)));
    }
}

//Two Digit Number Format Function
if ( ! function_exists('numberFormat')) {
    function numberFormat($amount = 0, $coma = null)
    {
        if ($coma) {
            if ($amount == 0)
                return '-';
            else
                return number_format($amount, 2);
        } else {
            return number_format($amount, 2, '.', '');
        }
    }
}

//Showing limited text with '...'
if ( ! function_exists('excerpt')) {
    function excerpt($text, $limit = 200)
    {
        if (strlen(strip_tags($text)) > $limit) {
            return substr(strip_tags($text), 0, $limit).'...';
        } else {
            return strip_tags($text);
        }
    }
}

// For image view if image exists with lightbox (yes/no).
// ['thumb' => 1, 'popup' => 1, 'class' => '', 'style' =>'', 'fake' => 'avatar']
if ( ! function_exists('viewImg')) {
    function viewImg($path, $name, $array = null)
    {
        $path = 'storage/'.$path;
        $thumb = (isset($array['thumb']))?'thumb/':'';
        $class = (isset($array['class']))?'class="'.$array['class'].'"':'';
        $id = (isset($array['id']))?'id="'.$array['id'].'"':'';
        $style = (isset($array['style']))?'style="'.$array['style'].'"':'';
        $title = (isset($array['title']))?$array['title']:'';
        if ($name!= '' && file_exists($path.'/'.$thumb.$name)) {
            $path = url('/'.$path).'/';
            if (isset($array['popup'])) {
                return '<a href="'.$path.$name.'" data-fancybox="group" data-fancybox data-caption="'.$title.'" class="lytebox" data-lyte-options="group:vacation"><img src="'.$path.$thumb.$name.'" alt="'.$title.'" '.$class.$id.' '.$style.'></a>';
            } else {
                return '<img src="'.$path.$thumb.$name.'" alt="'.$title.'" '.$class.$id.' '.$style.'>';
            }
        } else {
            if (isset($array['fake'])) {
                return '<img src="'.url('/admin-assets/images/'.$array['fake']).'.png" alt="'.$array['fake'].'" '.$class.$id.' '.$style.'>';
            } else {
                return '';
            }
        }
    }
}

//For file view
if ( ! function_exists('viewFile')) {
    function viewFile($path, $name)
    {
        $path = 'storage/'.$path;
        if ($name != null && file_exists($path.'/'.$name)) {
            return '<a href="'.url('/'.$path.'/'.$name).'" class="link" target="_blank">'.$name.'</a>';
        } else {
            return '';
        }
    }
}
