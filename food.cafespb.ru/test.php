<?
header('Content-Type: text/html; charset=windows-1251');
require_once 'config.php';
$objects = array();
$data = $_GET;
$a_search_params = array();
$offset = intval($data['offset']);
$master_str = (empty($data['p_master'])) ? '2' : implode(',', $data['p_master']);
if (empty($data['p_status'])) $data['p_status'][] = 1;
$status_str = implode(',', $data['p_status']);
$limit = 20;
$begin = $offset * $limit;
switch ($data['p_base']) {
    case 100 :
        $select = "select c.id";
        $from = "from object c, object_100 a, object_address d";
        $where = "where c.id=a.id and c.id=d.id";
        $order = "order by f_currency_convert(a.is_curr,4,a.f_c14), a.id desc";

        $where .= " and c.is_base=100 and d.is_region=" . intval($data['p_reg']);
        $where .= " and c.status in (" . $status_str . ")  ";

        $par = array('name' => 'База');
        $a_par = $dbh->GetCol("Select c_name from dict_master where id_master in (" . $master_str . ")");
        $par['value'] = implode(', ', $a_par);
        $a_search_params[] = $par;

        $par = array('name' => 'Статус');
        $a_par = array();
        if (in_array(1, $data['p_status'])) $a_par[] = 'Действующие';
        if (in_array(3, $data['p_status'])) $a_par[] = 'Удаленные';
        $par['value'] = implode(', ', $a_par);
        $a_search_params[] = $par;

        $where .= " and c.id_master in (" . $master_str . ")  ";
        $par = array('name' => 'Регион');
        $par['value'] = $dbh->GetOne("Select c_name from dict_region where id in (" . $data['p_reg'] . ")");
        $a_search_params[] = $par;

        $par = array('name' => 'Вид объекта');
        $par['value'] = $dbh->GetOne("Select c_name from dict_io where id in (" . $data['p_io'] . ")");
        $a_search_params[] = $par;
        $where .= " and a.is_io=" . $data['p_io'];

        if (!empty($data['p_dist'])) {
            $par = array('name' => 'Районы');
            $a_distr = $dbh->GetCol("Select c_name from dict_district where id in (" . implode(',', $data['p_dist']) . ")");
            $par['value'] = implode(', ', $a_distr);
            $a_search_params[] = $par;
            $where .= " and d.is_district IN (" . implode(',', $data['p_dist']) . ")";
        }

        if (!empty($data['p_a6n'])) {
            $par = array('name' => 'Метро');
            $a_par = $dbh->GetCol("Select c_name from dict_a6n where id in (" . implode(',', $data['p_a6n']) . ")");
            $par['value'] = implode(', ', $a_par);
            $a_search_params[] = $par;
            $where .= " and a.is_a6n IN (" . implode(',', $data['p_a6n']) . ")";
        }
        if (!empty($data['p_is_f5'])) {
            $par = array('name' => 'Форма собственности');
            $a_par = $dbh->GetCol("Select c_name from dict_f5 where id in (" . implode(',', $data['p_is_f5']) . ")");
            $par['value'] = implode(', ', $a_par);
            $a_search_params[] = $par;
            $where .= " and a.is_f5 IN (" . implode(',', $data['p_is_f5']) . ")";
        }
        if (!empty($data['p_14']['from']) || !empty($data['p_14']['to'])) {
            $par = array('name' => 'Цена');
            $p_str = '';
            if (!empty($data['p_14']['from'])) {
                $p_str .= 'от ' . $data['p_14']['from'] . ' ';
                $where .= " and f_currency_convert(a.is_curr,4,a.f_c14) >= " . intval($data['p_14']['from']);
            }
            if (!empty($data['p_14']['to'])) {
                $p_str .= 'до ' . $data['p_14']['to'] . ' ';
                $where .= " and f_currency_convert(a.is_curr,4,a.f_c14) <= " . intval($data['p_14']['to']);
            }
            $p_str .= 'тыс. руб.';
            $par['value'] = $p_str;
            $a_search_params[] = $par;
        }

        if (!empty($data['p_f1']['from']) || !empty($data['p_f1']['to'])) {
            $par = array('name' => 'Количество комнат');
            $p_str = '';
            if (!empty($data['p_f1']['from'])) {
                $p_str .= 'от ' . $data['p_f1']['from'] . ' ';
                $where .= " and a.i_f1 >= " . intval($data['p_f1']['from']);
            }
            if (!empty($data['p_f1']['to'])) {
                $p_str .= 'до ' . $data['p_f1']['to'] . ' ';
                $where .= " and a.i_f1 <= " . intval($data['p_f1']['to']);
            }
            $par['value'] = $p_str;
            $a_search_params[] = $par;
        }

        if (!empty($data['p_f_p4']['from']) || !empty($data['p_f_p4']['to'])) {
            $par = array('name' => 'Общая площадь');
            $p_str = '';
            if (!empty($data['p_f_p4']['from'])) {
                $p_str .= 'от ' . $data['p_f_p4']['from'] . ' ';
                $where .= " and a.f_p4 >= " . intval($data['p_f_p4']['from']);
            }
            if (!empty($data['p_f_p4']['to'])) {
                $p_str .= 'до ' . $data['p_f_p4']['to'] . ' ';
                $where .= " and a.f_p4 <= " . intval($data['p_f_p4']['to']);
            }
            $p_str .= 'м<sup>2</sup>';
            $par['value'] = $p_str;
            $a_search_params[] = $par;
        }

        if (!empty($data['p_f_p1']['from']) || !empty($data['p_f_p1']['to'])) {
            $par = array('name' => 'Жилая площадь');
            $p_str = '';
            if (!empty($data['p_f_p1']['from'])) {
                $p_str .= 'от ' . $data['p_f_p1']['from'] . ' ';
                $where .= " and a.f_p1 >= " . intval($data['p_f_p1']['from']);
            }
            if (!empty($data['p_f_p1']['to'])) {
                $p_str .= 'до ' . $data['p_f_p1']['to'] . ' ';
                $where .= " and a.f_p1 <= " . intval($data['p_f_p1']['to']);
            }
            $p_str .= 'м<sup>2</sup>';
            $par['value'] = $p_str;
            $a_search_params[] = $par;
        }
        if ((int) $data['large_podbor']) {

            if (!empty($data['p_f_p2']['from']) || !empty($data['p_f_p2']['to'])) {
                $par = array('name' => 'Площадь кухни');
                $p_str = '';
                if (!empty($data['p_f_p2']['from'])) {
                    $p_str .= 'от ' . $data['p_f_p2']['from'] . ' ';
                    $where .= " and a.f_p2 >= " . intval($data['p_f_p2']['from']);
                }
                if (!empty($data['p_f_p2']['to'])) {
                    $p_str .= 'до ' . $data['p_f_p2']['to'] . ' ';
                    $where .= " and a.f_p2 <= " . intval($data['p_f_p2']['to']);
                }
                $p_str .= 'м<sup>2</sup>';
                $par['value'] = $p_str;
                $a_search_params[] = $par;
            }
            if (!empty($data['p_f_p3']['from']) || !empty($data['p_f_p3']['to'])) {
                $par = array('name' => 'Площадь прихожей');
                $p_str = '';
                if (!empty($data['p_f_p3']['from'])) {
                    $p_str .= 'от ' . $data['p_f_p3']['from'] . ' ';
                    $where .= " and a.f_p3 >= " . intval($data['p_f_p3']['from']);
                }
                if (!empty($data['p_f_p3']['to'])) {
                    $p_str .= 'до ' . $data['p_f_p3']['to'] . ' ';
                    $where .= " and a.f_p3 <= " . intval($data['p_f_p3']['to']);
                }
                $p_str .= 'м<sup>2</sup>';
                $par['value'] = $p_str;
                $a_search_params[] = $par;
            }
            if (!empty($data['p_is_d4'])) {
                $par = array('name' => 'Тип дома');
                $a_par = $dbh->GetCol("Select c_name from dict_d4 where id in (" . implode(',', $data['p_is_d4']) . ")");
                $par['value'] = implode(', ', $a_par);
                $a_search_params[] = $par;
                $where .= " and a.is_d4 IN (" . implode(',', $data['p_is_d4']) . ")";
            }
            if (!empty($data['p_a7n'])) {
                $par = array('name' => 'Проезд');
                $a_par = $dbh->GetCol("Select c_name from dict_a7n where id in (" . implode(',', $data['p_a7n']) . ")");
                $par['value'] = implode(', ', $a_par);
                $a_search_params[] = $par;
                $where .= " and a.is_a7n IN (" . implode(',', $data['p_a7n']) . ")";
            }
            if (!empty($data['p_is_f3'])) {
                $par = array('name' => 'Санузел');
                $a_par = $dbh->GetCol("Select c_name from dict_f3 where id in (" . implode(',', $data['p_is_f3']) . ")");
                $par['value'] = implode(', ', $a_par);
                $a_search_params[] = $par;
                $where .= " and a.is_f3 IN (" . implode(',', $data['p_is_f3']) . ")";
            }
            if (!empty($data['p_is_f6'])) {
                $par = array('name' => 'Тип пола');
                $a_par = $dbh->GetCol("Select c_name from dict_f6 where id in (" . implode(',', $data['p_is_f6']) . ")");
                $par['value'] = implode(', ', $a_par);
                $a_search_params[] = $par;
                $where .= " and a.is_f6 IN (" . implode(',', $data['p_is_f6']) . ")";
            }
            if (!empty($data['p_is_f2'])) {
                $par = array('name' => 'Балкон');
                $a_par = $dbh->GetCol("Select c_name from dict_f2 where id in (" . implode(',', $data['p_is_f2']) . ")");
                $par['value'] = implode(', ', $a_par);
                $a_search_params[] = $par;
                $where .= " and a.is_f2 IN (" . implode(',', $data['p_is_f2']) . ")";
            }

            if (!empty($data['p_is_d1'])) {
                $par = array('name' => 'Этаж');
                $a_d1 = array(1 => 'Последний', 2 => 'Первый', 3 => 'Не крайние', 4 => 'Не первый');
                $par['value'] = $a_d1[$data['p_is_d1']];
                $a_search_params[] = $par;
                if ($data['p_is_d1'] == 1) $where .= " and a.i_d1=a.i_d2";
                else if ($data['p_is_d1'] == 2) $where .= " and a.i_d1=1";
                else if ($data['p_is_d1'] == 3) $where .= " and a.i_d1<>1 and a.i_d1<>a.i_d2";
                else if ($data['p_is_d1'] == 4) $where .= " and object_100.i_d1<>1";
            }
            if (!empty($data['p_b_d3'])) {
                $a_search_params[] = array('name' => 'Лифт', 'value' => 'есть');
                $where .= " and a.b_d3";
            }
// телефон
            if (!empty($data['p_b_f4'])) {
                $a_search_params[] = array('name' => 'Телефон', 'value' => 'есть');
                $where .= " and a.b_f4";
            }
        }
        $sql = $select . ' ' . $from . ' ' . $where . ' ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $begin . ';';
        _pr($sql);
        EP($a_search_params);
        break;
}
function getDictItemsByIds($name, $objects, $col) {
    global $dbh;

    foreach ($objects as $object) {
        if (!empty($object[$col])) {
            $ids[] = $object[$col];
        }
    }

    if (!empty($ids)) {
        return $dbh->GetAssoc("SELECT id, c_shortname FROM " . $name . " WHERE id IN (" . implode(', ', $ids) . ");");
    }

    return array();
}

function calculate_pages(&$total_rows, $rows_per_page, &$page_num) {
    $arr = array();
    // calculate last page
    $last_page = ceil($total_rows / $rows_per_page);
    // make sure we are within limits
    $page_num = (int) $page_num;
    if ($page_num < 1) {
        $page_num = 1;
    } elseif ($page_num > $last_page) {
        $page_num = $last_page;
    }
    $upto = ($page_num - 1) * $rows_per_page;
    $arr['limit'] = 'LIMIT ' . $upto . ',' . $rows_per_page;
    $arr['current'] = $page_num;
    if ($page_num == 1) {
        $arr['previous'] = $page_num;
    } else {
        $arr['previous'] = $page_num - 1;
    }
    if ($page_num == $last_page) {
        $arr['next'] = $last_page;
    } else {
        $arr['next'] = $page_num + 1;
    }
    $arr['last'] = $last_page;
    $arr['info'] = 'Page (' . $page_num . ' of ' . $last_page . ')';
    $arr['pages'] = get_surrounding_pages($page_num, $last_page, $arr['next']);

    return $arr;
}

function get_surrounding_pages($page_num, $last_page, $next) {
    $arr = array();
    $show = 5; // how many boxes
    // at first
    if ($page_num == 1) {
        // case of 1 page only
        if ($next == $page_num) return array(1);
        for ($i = 0; $i < $show; $i++) {
            if ($i == $last_page) break;
            array_push($arr, $i + 1);
        }

        return $arr;
    }

    // at last
    if ($page_num == $last_page) {
        $start = $last_page - $show;
        if ($start < 1) $start = 0;
        for ($i = $start; $i < $last_page; $i++) {
            array_push($arr, $i + 1);
        }

        return $arr;
    }

    // at middle
    $start = $page_num - $show;
    if ($start < 1) $start = 0;
    for ($i = $start; $i < $page_num; $i++) {
        array_push($arr, $i + 1);
    }

    for ($i = ($page_num + 1); $i < ($page_num + $show); $i++) {
        if ($i == ($last_page + 1)) break;
        array_push($arr, $i);
    }

    return $arr;
}

print json_safe_encode(array('success' => true, 'objects' => $objects, 'param' => $_GET));