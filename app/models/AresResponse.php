<?php


namespace App\Models;


class AresResponse
{
    /** @var integer */
    private $ico;
    /** @var string */
    private $name;
    /** @var string */
    private $city;
    /** @var string */
    private $street;
    /** @var integer */
    private $psc;
    /** @var string */
    private $dic;

    /**
     * @return int
     */
    public function getIco()
    {
        return $this->ico;
    }

    /**
     * @param int $ico
     */
    public function setIco($ico)
    {
        $this->ico = (int)$ico;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getPsc()
    {
        return $this->psc;
    }

    /**
     * @param int $psc
     */
    public function setPsc($psc)
    {
        $this->psc = $psc;
    }

    /**
     * @return string
     */
    public function getDic()
    {
        return $this->dic;
    }

    /**
     * @param string $dic
     */
    public function setDic($dic)
    {
        $this->dic = $dic;
    }

    /**
     * @param int $ico
     * @param string $dic
     * @param int $psc
     * @param string $name
     * @param string $city
     * @param string $street
     */
    public function setValues($ico, $dic, $psc, $name, $city, $street)
    {
        $this->setIco($ico);
        $this->setDic($dic);
        $this->setPsc($psc);
        $this->setName($name);
        $this->setCity($city);
        $this->setStreet($street);
    }
}