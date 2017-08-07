<?php

namespace Leonis\IDCard;

class IDCard
{
    /**
     * 身份证号.
     *
     * @var string
     */
    protected $id;

    /**
     * 行政区划代码
     *
     * @var array
     */
    protected $areaCodes;

    public function __construct($id)
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
        return $this->checkAreaCode() && $this->checkBirthday() && $this->checkCode();
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
        $validate = substr($this->id, 0, 17);
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $sum += substr($validate, $i, 1) * $weight[$i];
        }

        return $codes[$sum % 11] == substr($this->id, 17, 1);
    }

    /**
     * 获取地址
     *
     * @param string $separator
     *
     * @return string
     */
    public function address($separator = '')
    {
        return $this->province().$separator.$this->city().$separator.$this->zone();
    }

    /**
     * 获取省
     *
     * @return string
     */
    public function province()
    {
        return $this->areaCodes[substr($this->id, 0, 2).'0000'];
    }

    /**
     * 获取市
     *
     * @return string
     */
    public function city()
    {
        return $this->areaCodes[substr($this->id, 0, 4).'00'];
    }

    /**
     * 获取区.
     *
     * @return string
     */
    public function zone()
    {
        return $this->areaCodes[substr($this->id, 0, 6)];
    }

    /**
     * 获取生日.
     *
     * @param string $format
     *
     * @return string
     */
    public function birthday($format = 'Y-m-d')
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
     * @return int
     */
    public function age()
    {
        $year = $this->year();
        $month = $this->month();
        $day = $this->day();

        $nowYear = (int) date('Y');
        $nowMonth = (int) date('n');
        $nowDay = (int) date('j');

        $age = $nowYear > $year ? $nowYear - $year - 1 : 0;
        if ($nowMonth > $month || ($nowMonth === $month && $nowDay >= $day)) {
            $age++;
        }

        return $age;
    }

    /**
     * 获取性别.
     *
     * @return string
     */
    public function sex()
    {
        return substr($this->id, 16, 1) % 2 ? '男' : '女';
    }

    /**
     * 获取星座.
     *
     * @return string
     */
    public function constellation()
    {
        $constellation = ['水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '魔羯座'];
        $constellationDays = [21, 20, 21, 20, 21, 22, 23, 23, 23, 24, 22, 21];

        $month = $this->month() - 1;
        $day = $this->day();

        if ($day < $constellationDays[$month]) {
            $month--;
        }

        return $month >= 0 ? $constellation[$month] : $constellation[11];
    }

    /**
     * 获取属相.
     *
     * @return string
     */
    public function zodiac()
    {
        $zodiac = ['牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪', '鼠'];
        $index = abs($this->year() - 1901) % 12;

        return $zodiac[$index];
    }
}
