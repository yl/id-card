[![StyleCI](https://styleci.io/repos/98876454/shield?branch=master)](https://styleci.io/repos/98876454)
[![Build Status](https://travis-ci.org/yangliulnn/id-card.svg?branch=master)](https://travis-ci.org/yangliulnn/id-card)
[![Build Status](https://scrutinizer-ci.com/g/yangliulnn/id-card/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yangliulnn/id-card/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yangliulnn/id-card/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yangliulnn/id-card/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yangliulnn/id-card/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yangliulnn/id-card/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/leonis/id-card/v/stable)](https://packagist.org/packages/leonis/id-card)
[![Total Downloads](https://poser.pugx.org/leonis/id-card/downloads)](https://packagist.org/packages/leonis/id-card)
[![License](https://poser.pugx.org/leonis/id-card/license)](https://packagist.org/packages/leonis/id-card)

# IDCard
身份证号校验及信息获取

## 安装
```
$ composer require leonis/id-card
```

## 使用
```php
$idCard = new \Leonis\IDCard\IDCard($idCardNumber);

$idCard->check();           // 验证身份号 return true or false
$idCard->checkAreaCode();   // 验证行政区划代码 return true or false
$idCard->checkBirthday();   // 验证生日 return true or false
$idCard->checkCode();       // 验证校验码 return true or false
$idCard->address();         // 获取地址 return string
$idCard->province();        // 获取省 return string
$idCard->city();            // 获取市 return string
$idCard->zone();            // 获取区 return string
$idCard->birthday();        // 获取生日 return string
$idCard->year();            // 获取年 return int
$idCard->month();           // 获取月 return int
$idCard->day();             // 获取日 return int
$idCard->age();             // 获取年龄 return int
$idCard->sex();             // 获取性别 return string
$idCard->constellation();   // 获取星座 return string
$idCard->zodiac();          // 获取属相 return string
```
 
## License
MIT
