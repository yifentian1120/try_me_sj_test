<?php

use Google\Cloud\BigQuery\BigQueryClient;

// setup Composer autoloading
require_once __DIR__ . '/vendor/autoload.php';

$sql = "SELECT theme, COUNT(*) as count
    FROM (
        select SPLIT(V2Themes,';') theme
        from [gdelt-bq:gdeltv2.gkg]
        where DATE>20150302000000 and DATE < 20150304000000 and AllNames like '%Netanyahu%' and TranslationInfo like '%srclc:heb%'
    )
    group by theme
    ORDER BY 2 DESC
    LIMIT 300
";

$bigQuery = new BigQueryClient([
    'keyFilePath' => __DIR__ . '/path/to/your/google/cloud/account/key.json',
]);

// Run a query and inspect the results.
$queryResults = $bigQuery->runQuery($sql);

foreach ($queryResults->rows() as $row) {
    print_r($row);
}

?>