<?php

namespace Leonis\IDCard;

class IDCard
{
    /**
     * 身份证号.
     *
     * @var string
     */
    private $id;

    /**
     * 行政区划代码
     *
     * @var array
     */
    private $areaCodes;

    public function __construct(string $id)
    {
        $this->id = strtoupper($id);
        $this->areaCodes = (array) require __DIR__.'/../data/codes.php';
    }

    /**
     * 验证身份号.
     *
     * @return bool
     */
    public function check()
    {
        return ($this->checkAreaCode() and $this->checkBirthday() and $this->checkCode()) ? true : false;
    }

    /**
     * 验证行政区划代码
     *
     * @return bool
     */
    public function checkAreaCode()
    {
        $areaCode = substr($this->id, 0, 6);

        return array_key_exists($areaCode, $this->areaCodes);
    }

    /**
     * 验证生日.
     *
     * @return bool
     */
    public function checkBirthday()
    {
        $year = substr($this->id, 6, 4);
        $month = substr($this->id, 10, 2);
        $day = substr($this->id, 12, 2);

        return checkdate($month, $day, $year);
    }

    /**
     * 验证校验码
     *
     * @return bool
     */
    public function checkCode()
    {
        $weight = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $codes = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
        $code = substr($this->id, 17, 1);
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $sum += substr(substr($this->id, 0, 17), $i, 1) * $weight[$i];
        }

        return $code == $codes[$sum % 11];
    }

    /**
     * 获取地址
     *
     * @param string $separator
     *
     * @return bool|string
     */
    public function address(string $separator = '')
    {
        return $this->check() ? $this->province().$separator.$this->city().$separator.$this->zone() : false;
    }

    /**
     * 获取省
     *
     * @return bool|mixed
     */
    public function province()
    {
        $provinceCode = substr($this->id, 0, 2).'0000';

        return $this->check() ? $this->areaCodes[$provinceCode] : false;
    }

    /**
     * 获取市
     *
     * @return bool|mixed
     */
    public function city()
    {
        $cityCode = substr($this->id, 0, 4).'00';

        return $this->check() ? $this->areaCodes[$cityCode] : false;
    }

    /**
     * 获取区.
     *
     * @return bool|mixed
     */
    public function zone()
    {
        $areaCode = substr($this->id, 0, 6);

        return $this->check() ? $this->areaCodes[$areaCode] : false;
    }

    /**
     * 获取生日.
     *
     * @param string $format
     *
     * @return bool|string
     */
    public function birthday(string $format)
    {
        return date($format, strtotime($this->year().'-'.$this->month().'-'.$this->day()));
    }

    /**
     * 获取年.
     *
     * @return int
     */
    public function year()
    {
        return (int) substr($this->id, 6, 4);
    }

    /**
     * 获取月.
     *
     * @return int
     */
    public function month()
    {
        return (int) substr($this->id, 10, 2);
    }

    /**
     * 获取日.
     *
     * @return int
     */
    public function day()
    {
        return (int) substr($this->id, 12, 2);
    }

    /**
     * 获取年龄.
     *
     * @return false|int|string
     */
    public function age()
    {
        if (!$this->check()) {
            return false;
        }

        $year = substr($this->id, 6, 4);
        $month = substr($this->id, 10, 12);
        $day = substr($this->id, 12, 14);

        $age = 0;
        if (date('Y') > $year) {
            $age = date('Y') - $year - 1;
            if (date('m') > $month) {
                $age++;
            } elseif (date('m') == $month) {
                if (date('d') >= $day) {
                    $age++;
                }
            }
        }

        return $age;
    }

    /**
     * 获取性别.
     *
     * @return bool|string 身份证号未通过验证返回 false
     */
    public function sex()
    {
        return $this->check() ? (substr($this->id, 16, 1) % 2 === 0 ? '女' : '男') : false;
    }

    /**
     * 获取星座.
     *
     * @return bool|mixed
     */
    public function constellation()
    {
        if (!$this->check()) {
            return false;
        }

        $constellation = ['水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '魔羯座'];
        $constellationDays = [21, 20, 21, 20, 21, 22, 23, 23, 23, 24, 22, 21];

        $month = $this->month() - 1;
        $day = $this->day();

        if ($day < $constellationDays[$month - 1]) {
            $month--;
        }

        if ($month > 0) {
            return $constellation[$month];
        }

        return $constellation[11];
    }

    /**
     * 获取属相.
     *
     * @return bool|string
     */
    public function zodiac()
    {
        if (!$this->check()) {
            return false;
        }

        $year = $this->year();
        $index = $year > 1901 ? ($year - 1901) % 12 : (1901 - $year) % 12;
        $zodiac = ['牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪', '鼠'];

        return $zodiac[$index];
    }
}
