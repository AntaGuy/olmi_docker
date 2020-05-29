<?php
namespace App\Utils;

class SanitizeText
{
    /**
     * @param $string
     *
     * @return string
     */
    public  function removeAccents($string)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    }

    /**
     * @param null $string
     *
     * @return null|string|void
     */
    public  function cleanString($string = null)
    {
        if($string === null) return;
        $string = trim($string);
        $string = str_replace(" ","",$string);
        $string = $this->removeAccents($string);
        return $string;
    }

    /**
     * @param null $phone
     *
     * @return mixed|null|string|void
     */
    public  function formatPhone($phone = null)
    {
        if($phone === null) return;
        $phone = $this->cleanString($phone);
        $phone = str_replace(" ","",$phone);
        $phone = str_replace(".","",$phone);
        $phone = trim($phone);
        return $phone;
    }

    /**
     * @param null $email
     *
     * @return mixed|null|string|void
     */
    public  function formatEmail($email = null)
    {
        if($email === null) return;
        $email = str_replace(" ","",$email);
        $email = str_replace(",",".",$email);
        $email = str_replace(".","",$email);
        $email = trim($email);
        return $email;
    }
}
