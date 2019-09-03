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

    protected $isTrue;

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
    public function check(): bool
    {
        if ($this->isTrue === null) {
            $this->isTrue = $this->checkAreaCode() && $this->checkBirthday() && $this->checkCode();
        }

        return $this->isTrue;
    }

    /**
     * 验证行政区划代码
     *
     * @return bool
     */
    public function checkAreaCode(): bool
    {
        $areaCode = substr($this->id, 0, 6);

        return array_key_exists($areaCode, $this->areaCodes);
    }

    /**
     * 验证生日.
     *
     * @return bool
     */
    public function checkBirthday(): bool
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
    public function checkCode(): bool
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
     * @throws BadIDCardException
     *
     * @return string
     */
    public function address(string $separator = ''): string
    {
        return $this->province().$this->city($separator).$this->zone($separator);
    }

    /**
     * 获取省
     *
     * @throws BadIDCardException
     *
     * @return string
     */
    public function province(): string
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return $this->areaCodes[substr($this->id, 0, 2).'0000'];
    }

    /**
     * 获取市
     *
     * @param string $separator
     *
     * @throws BadIDCardException
     *
     * @return string
     */
    public function city(string $separator = ''): string
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return $separator.$this->areaCodes[substr($this->id, 0, 4).'00'];
    }

    /**
     * 获取区.
     *
     * @param string $separator
     *
     * @throws BadIDCardException
     *
     * @return string
     */
    public function zone(string $separator = ''): string
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return $separator.$this->areaCodes[substr($this->id, 0, 6)];
    }

    /**
     * 获取生日.
     *
     * @param string $format
     *
     * @throws BadIDCardException
     *
     * @return string
     */
    public function birthday(string $format = 'Y-m-d'): string
    {
        return date($format, strtotime($this->year().'-'.$this->month().'-'.$this->day()));
    }

    /**
     * 获取年.
     *
     * @throws BadIDCardException
     *
     * @return int
     */
    public function year(): int
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return (int) substr($this->id, 6, 4);
    }

    /**
     * 获取月.
     *
     * @throws BadIDCardException
     *
     * @return int
     */
    public function month(): int
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return (int) substr($this->id, 10, 2);
    }

    /**
     * 获取日.
     *
     * @throws BadIDCardException
     *
     * @return int
     */
    public function day(): int
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return (int) substr($this->id, 12, 2);
    }

    /**
     * 获取年龄.
     *
     * @throws BadIDCardException
     *
     * @return int
     */
    public function age(): int
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
     * @throws BadIDCardException
     *
     * @return string
     */
    public function sex(): string
    {
        if ($this->check() === false) {
            throw new BadIDCardException();
        }

        return substr($this->id, 16, 1) % 2 ? '男' : '女';
    }

    /**
     * 获取星座.
     *
     * @throws BadIDCardException
     *
     * @return string
     */
    public function constellation(): string
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
     * @throws BadIDCardException
     *
     * @return string
     */
    public function zodiac(): string
    {
        $zodiac = ['牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪', '鼠'];
        $index = abs($this->year() - 1901) % 12;

        return $zodiac[$index];
    }
}
