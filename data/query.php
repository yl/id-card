<?php

use QL\QueryList;

require_once 'vendor/autoload.php';

$urls = [
    'http://www.mca.gov.cn/article/sj/xzqh/2019/2019/201911250933.html', // 2019-10
    'http://www.mca.gov.cn/article/sj/xzqh/2019/2019/201911051008.html', // 2019-9
    'http://www.mca.gov.cn/article/sj/tjyb/qgsj/2019/201909291543.html', // 2019-8
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201908/201908271607.html', // 2019-7
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201908050812.html', //2019-6
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201906211421.html', //2019-5
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201905271424.html', // 2019-4
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201904301434.html', // 2019-3
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201903221437.html', // 2019-2
    'http://www.mca.gov.cn/article/sj/xzqh/2019/201901-06/201902061442.html', // 2019-1
    'http://www.mca.gov.cn/article/sj/xzqh/1980/201903/201903011447.html', // 2018
    'http://www.mca.gov.cn/article/sj/xzqh/1980/201803/201803131454.html', // 2017
    'http://www.mca.gov.cn/article/sj/xzqh/1980/201705/201705311652.html', // 2016
    'http://www.mca.gov.cn/article/sj/tjbz/a/2015/201706011127.html', // 2015
    'http://files2.mca.gov.cn/cws/201502/20150225163817214.html', // 2014
    'http://files2.mca.gov.cn/cws/201404/20140404125552372.htm', // 2013
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201707271556.html', // 2012
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201707271552.html', // 2011
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220946.html', // 2010
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220943.html', // 2009
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220941.html', // 2008
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220939.html', // 2007
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220936.html', // 2006
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220935.html', // 2005
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220930.html', // 2004
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220928.html', // 2003
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220927.html', // 2002
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220925.html', // 2001
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220923.html', // 2000
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220921.html', // 1999
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220918.html', // 1998
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220916.html', // 1997
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220914.html', // 1996
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220913.html', // 1995
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220911.html', // 1994
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708041023.html', // 1993
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220910.html', // 1992
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708041020.html', // 1991
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708041018.html', // 1990
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708041017.html', // 1989
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220903.html', // 1988
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220902.html', // 1987
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220859.html', // 1986
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220858.html', // 1985
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708220856.html', // 1984
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708160821.html', // 1983
    'http://www.mca.gov.cn/article/sj/tjbz/a/1980-2000/201707141125.html', // 1982
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708041004.html', // 1981
    'http://www.mca.gov.cn/article/sj/tjbz/a/201713/201708040959.html', // 1980
];

$data = [];

echo 'Updating...'.PHP_EOL;
foreach (array_reverse($urls) as $i => $url) {
    echo $url.PHP_EOL;
    $table = QueryList::get($url)->find('table');
    $table->find('span')->remove();

    foreach ($table->find('tr')->texts() as $item) {
        if (preg_match('/^\d{6}/', $item)) {
            $item = preg_replace('/\s/', '', $item);
            $code = mb_substr($item, 0, 6);
            $area = mb_substr($item, 6);
            $data[$code] = $area;
        }
    }
}
echo 'Done!'.PHP_EOL;

ksort($data);

file_put_contents('./data/codes.php', sprintf("<?php\n\nreturn %s;\n", var_export($data, true)));
