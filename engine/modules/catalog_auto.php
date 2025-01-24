<?php

$url = explode('/', $_REQUEST['url']);
$segments = [];
foreach ($url as $segment)
    if (!empty($segment))
        $segments[] = $segment;

//Марки
if (count($segments) == 0) {
    $page_auto_type = 'makes';

    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name
FROM mark 
SQL;

    $rows = $db->super_query($sql, true);
    if (count($rows) > 0) {
        $tpl->load_template('/catalog_auto/makes_row.tpl');
        foreach ($rows as $row) {
            foreach ($row as $field => $value)
                $tpl->set('{' . $field . '}', $value);
            //foreach ($City as $suf => $val)
            //    $tpl->set("{city_{$suf}}", $val);
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/catalog_auto/makes.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else
        $tpl->load_template('/info_closed.tpl');
    $tpl->compile('content');
}
//модели
if (count($segments) == 1) {

    $page_auto_type = 'models';

    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       model.`year-from` as year_from,
       model.`year-to` as year_to
FROM mark 
JOIN model ON mark.id = model.mark_id
WHERE mark.id = '{$segments[0]}'
SQL;
    $rows = $db->super_query($sql, true);
    if (count($rows) > 0) {
        $tpl->load_template('/catalog_auto/models_row.tpl');
        foreach ($rows as $row) {
            if (!$row['year_to'])
                $row['year_to'] = 'произв.';
            foreach ($row as $field => $value)
                $tpl->set('{' . $field . '}', $value);
            //foreach ($City as $suf => $val)
            //    $tpl->set("{city_{$suf}}", $val);
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/catalog_auto/models.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else
        $tpl->load_template('/info_closed.tpl');
    $tpl->compile('content');
}
//генерации (поколение)
if (count($segments) == 2) {

    $page_auto_type = 'generation';

    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       generation.`year-start` as year_from,
       generation.`year-stop` as year_to,
       generation.id as generation_id,
       generation.name as generation_name
FROM mark 
JOIN model ON mark.id = model.mark_id
JOIN generation ON model.id = generation.model_id 
WHERE mark.id = '{$segments[0]}' and model.id = '{$segments[1]}'
SQL;
    $rows = $db->super_query($sql, true);
    if (count($rows) > 0) {
        $tpl->load_template('/catalog_auto/generation_row.tpl');
        foreach ($rows as $row) {
            if (!$row['year_to'])
                $row['year_to'] = 'произв.';
            foreach ($row as $field => $value)
                $tpl->set('{' . $field . '}', $value);
            //foreach ($City as $suf => $val)
            //    $tpl->set("{city_{$suf}}", $val);
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/catalog_auto/generation.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else
        $tpl->load_template('/info_closed.tpl');
    $tpl->compile('content');
}
//конфигурации (по факту кузова)
if (count($segments) == 3) {

    $page_auto_type = 'configuration';

    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       generation.`year-start` as year_from,
       generation.`year-stop` as year_to,
       generation.id as generation_id,
       generation.name as generation_name,
       configuration.`id` as configuration_id, 
       configuration.`body-type` as body_type,
       configuration.`doors-count` as doors_count,
       configuration.`configuration-name` as configuration_name
FROM mark 
JOIN model ON mark.id = model.mark_id
JOIN generation ON model.id = generation.model_id 
JOIN configuration ON generation.id = configuration.generation_id 
WHERE mark.id = '{$segments[0]}' and model.id = '{$segments[1]}' and generation.id = '{$segments[2]}'
SQL;

    $rows = $db->super_query($sql, true);
    if (count($rows) > 0) {
        $tpl->load_template('/catalog_auto/configuration_row.tpl');
        foreach ($rows as $row) {
            if (!$row['year_to'])
                $row['year_to'] = 'произв.';
            foreach ($row as $field => $value)
                $tpl->set('{' . $field . '}', $value);
            //foreach ($City as $suf => $val)
            //    $tpl->set("{city_{$suf}}", $val);
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/catalog_auto/configuration.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else
        $tpl->load_template('/info_closed.tpl');
    $tpl->compile('content');
}
//модификации
if (count($segments) == 4) {
    $page_auto_type = 'modification';
    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       generation.`year-start` as year_from,
       generation.`year-stop` as year_to,
       generation.id as generation_id,
       generation.name as generation_name,
       configuration.`id` as configuration_id, 
       configuration.`body-type` as body_type,
       configuration.`doors-count` as doors_count,
       configuration.`configuration-name` as configuration_name,
       modification.`complectation-id` as complectation_id,
       specifications.*
FROM mark 
JOIN model ON mark.id = model.mark_id
JOIN generation ON model.id = generation.model_id 
JOIN configuration ON generation.id = configuration.generation_id
JOIN modification ON configuration.id = modification.configuration_id
JOIN specifications ON modification.`complectation-id` = specifications.complectation_id
WHERE mark.id = '{$segments[0]}' and model.id = '{$segments[1]}' and generation.id = '{$segments[2]}' and configuration.id = '{$segments[3]}'
SQL;
    $rows = $db->super_query($sql, true);
    if (count($rows) > 0) {
        $tpl->load_template('/catalog_auto/modification_row.tpl');
        foreach ($rows as $row) {
            if (!$row['year_to'])
                $row['year_to'] = 'произв.';
            foreach ($row as $field => $value)
                $tpl->set('{' . $field . '}', $value);
            //foreach ($City as $suf => $val)
            //    $tpl->set("{city_{$suf}}", $val);
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/catalog_auto/modification.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else
        $tpl->load_template('/info_closed.tpl');
    $tpl->compile('content');
}
//полная страница модификации
if (count($segments) == 5) {
    $page_auto_type = 'auto_full';
    $sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       generation.`year-start` as year_from,
       generation.`year-stop` as year_to,
       generation.id as generation_id,
       generation.name as generation_name,
       configuration.`id` as configuration_id, 
       configuration.`body-type` as body_type,
       configuration.`doors-count` as doors_count,
       configuration.`configuration-name` as configuration_name,
       modification.`complectation-id` as complectation_id,
       specifications.*
FROM mark 
JOIN model ON mark.id = model.mark_id
JOIN generation ON model.id = generation.model_id 
JOIN configuration ON generation.id = configuration.generation_id
JOIN modification ON configuration.id = modification.configuration_id
JOIN specifications ON modification.`complectation-id` = specifications.complectation_id
WHERE mark.id = '{$segments[0]}' and model.id = '{$segments[1]}' 
  and generation.id = '{$segments[2]}' and configuration.id = '{$segments[3]}' and modification.`complectation-id` = '{$segments[4]}'
SQL;
    $row = $db->super_query($sql);
    $tpl->load_template('/catalog_auto/auto.tpl');

    if (!$row['year_to'])
        $row['year_to'] = 'произв.';
    foreach ($row as $field => $value)
        $tpl->set('{' . $field . '}', $value);
    //foreach ($City as $suf => $val)
    //    $tpl->set("{city_{$suf}}", $val);
    $tpl->compile('content');

}

$AutoFullInfo = $row;


//echo $tpl->result['content'];

//$AutoFullInfo = [123123];