<?php

class DueDate {

    protected $turnaroundtime;
    protected $timestamp;

    public function __construct($pTurnaroundTime, $timestamp) {
        if (empty($pTurnaroundTime) || empty($timestamp) || $this->validateDate($timestamp) == false) {
            throw new Exception('Params are  not valid');
        }

        /* 1.get the day is in work day
         * 2. check the hour is between range 
         * if the time is larger than 16:59 get the next time
         */
        $this->ttime = $pTurnaroundTime;
        $this->timestamp = $timestamp;
        $this->init();
    }

    public function init() {
        $params = $this->getHourAndDayAsName();
     
        if ( $this->isInWorkday($params[0]) && $this->isWorktime($params[1])) {
            $enoughTime = $this->enoughttime($params[1],$params[2]);
        }
    }

    protected function enoughttime($hour,$minute)
    {
       
    }
    
    
    protected function getHourAndDayAsName() {

        $Day = date('D', strtotime($this->timestamp));
        $hour = date('H', strtotime($this->timestamp));
        $minute = date('i', strtotime($this->timestamp));
        return array($Day, $hour, $minute);
    }

    public static function isWorktime($hour) {
        $range = range(9, 17);
        return in_array(intval($hour), $range);
    }

    public static function Isworkdays() {
        return array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');
    }

    public static function isInWorkday($day) {
        return in_array($day, self::Isworkdays());
    }

    protected function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}

