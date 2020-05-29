<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Util\ColorManipulator;
use Symfony\Contracts\Translation\TranslatorInterface;


class ToolExtension extends AbstractExtension
{
    private $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('asStar', array($this, 'asStar'), array('is_safe' => array('html'))),
            new TwigFilter('freshnessColor', array($this, 'freshnessColor'), array()),
            new TwigFilter('freshnessPercent', array($this, 'freshnessPercent'), array()),
            new TwigFilter('daysFromDate', array($this, 'daysFromDate'), array()),
            new TwigFilter('minutesFromDate', array($this, 'minutesFromDate'), array()),
            new TwigFilter('colorValue', array($this, 'colorValue'), array('is_safe' => array('html'))),
            new TwigFilter('bgColorValue', array($this, 'bgColorValue'), array('is_safe' => array('html'))),
            new TwigFilter('formatPercent', array($this, 'formatPercent'), array('is_safe' => array('html'))),
            new TwigFilter('formatHour', array($this, 'formatHour'), array('is_safe' => array('html'))),
            new TwigFilter('statusDate', array($this, 'statusDate'), array('is_safe' => array('html'))),
            new TwigFilter('yesNo', array($this, 'yesNo'), array('is_safe' => array('html'))),
            new TwigFilter('ext', array($this, 'ext'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param $value
     * @param $availableValues
     * @param string $type
     *
     * @return int
     */
    public function asStar($value, $availableValues, $type = 'full')
    {
        if($value === null) return '<i class="fa fa-question-circle-o" aria-hidden="true"></i>';
        $maxStars = count($availableValues);
        $nbStars = in_array($value, $availableValues) ? array_flip($availableValues)[$value] : 0;
        $result = array();
        for($i = 0; $i < $maxStars; $i++){
            $result[] = ($i < $nbStars) ? '<i class="fa fa-star"></i>': '<i class="fa fa-star-o"></i>';
        }
        return implode('',$result);
    }

    /**
     * @param null|\DateTime $datetime
     * @param int $maxDays Le maximum de jour (>1)
     * @param float $saturation (range 0% - 100%)
     * @param float $brightness (range 0% - 100%)
     * @param float $hue_min (range 0 - 360)
     * @param float $hue_max (range 0 - 360)
     * @param string $format (rgb|rgba|hsl|hsb|)
     * @return string
     */
    public function freshnessColor($datetime = null, $default = '#333333', $maxDays = 14, $saturation = 1, $brightness = 0.65, $hue_min = 0, $hue_max = 0.425){
        if($datetime === null) return $default;
        $percent = self::freshnessPercent($datetime, $maxDays);
        $fresness = $percent === 0 ? $hue_min : (float)( (self::freshnessPercent($datetime, $maxDays)/100) * ($hue_max - $hue_min)  + $hue_min );
        return ColorManipulator::hsl2hex(array($fresness, $saturation, $brightness));
    }

    /**
     * @param null|\DateTime $datetime
     * @param int $maxDays Le maximum de jour (>1)
     * @return float (%)
     */
    public function freshnessPercent($datetime = null, $maxDays = 14){
        if($datetime === null) return null;
        $days = self::daysFromDate($datetime);
        return $days > $maxDays ? 0 : (float)(100 - ($days / $maxDays) * 100);
    }

    /**
     * @param null|\DateTime $datetime
     * @param int $maxDays Le maximum de jour (>1)
     * @return float (%)
     */
    public function daysFromDate($datetime = null, $from = 'now'){
        if($datetime === null) return null;
        $now = new \DateTime($from);
        return (int)$now->diff($datetime)->format('%a');
    }

    /**
     * @param null|\DateTime $datetime
     * @param int $maxDays Le maximum de jour (>1)
     * @return float (%)
     */
    public function minutesFromDate($datetime = null, $from = 'now'){
        if($datetime === null) return null;
        $now = new \DateTime($from);
        return $now->diff($datetime);
    }

    /**
     * @param null|\DateTime $datetime
     * @param int $maxDays Le maximum de jour (>1)
     * @return string
     */
    public function statusDate($datetime = null, $from = 'now'){
        if($datetime === null) return null;
        $from = new \DateTime($from);
        $diff = $from->diff($datetime)->days;
        if( $diff == 0 ){
            return '<span class="badge badge-success">'.ucfirst($this->translator->trans('to day')).'</span>';
        } else if( $diff > 0 ){
            return '<span class="badge badge-warning">'.ucfirst($this->translator->trans('forthcoming')).'</span>';
        } else {
            return '<span class="badge badge-danger">'.ucfirst($this->translator->trans('completed')).'</span>';
        }
    }

    /**
     * @param null|int
     * @param float
     * @return string
     */
    public function yesNo($value){
        if($value) return '<span class="badge badge-success">'.ucfirst($this->translator->trans('yes')).'</span>';
        else return '<span class="badge badge-danger">'.ucfirst($this->translator->trans('no')).'</span>';
    }

    /**
     * @param null|string
     * @return string
     */
    public function ext($filepath){
        $ext = pathinfo($filepath, PATHINFO_EXTENSION);
        return $ext;
    }

    /**
     * @param null|int
     * @param float
     * @return string
     */
    public function colorValue($number, $max = 0){
        if($number < $max) return '<span class="text-red">' . $number . '</span>';
        else return '<span class="text-green">' . $number . '</span>';
    }

    /**
     * @param null|int
     * @param float
     * @return string
     */
    public function bgColorValue($number, $max = 0){
        if(!empty($number)){
            if($number < $max) return 'bg-red';
            elseif($number >= $max) return 'bg-green';
            else return '';
        }
        else return 'bg-gray';
    }


    /**
     * @param null|int
     * @param float
     * @return string
     */
    public  function formatPercent($number)
    {
        if($number === null) return '';
        return number_format($number*100,2, '.', ' ').'%';
    }

    /**
     * @param null|int
     * @param float
     * @return string
     */
    public  function formatHour($duration)
    {
        if ($duration === null) return '';

        $hours = floor($duration / 3600);
        $duration -= $hours * 3600;
        $minutes = floor($duration / 60);
        $duration -= $minutes * 60;

        return sprintf("%02d", $hours).":".sprintf("%02d", $minutes).":".sprintf("%02d", $duration);
    }


    public function getName()
    {
        return 'tool_extension';
    }


}