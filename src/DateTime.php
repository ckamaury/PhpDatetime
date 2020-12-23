<?php


namespace CkAmaury\PhpDatetime;


use DateInterval;
use DateTimeInterface;
use DateTimeZone;

class DateTime extends \DateTime {

    public function init(DateTimeInterface $datetime) : self{
        $this->setTimestamp($datetime->getTimestamp());
        return $this;
    }
    public function clone(){
        return clone $this;
    }

    //######### YEARS #########
    public function addYears(int $year): self{
        $this->add($this->getYearInterval($year));
        return $this;
    }
    public function subYears(int $year): self{
        $this->sub($this->getYearInterval($year));
        return $this;
    }
    public function setYear(int $year): self{
        $this->setDate($year,$this->getMonth(),$this->getDay());
        return $this;
    }
    public function nextYear(): self{
        $this->addYears(1);
        return $this;
    }
    public function previousYear(): self{
        $this->subYears(1);
        return $this;
    }
    public function getYear(): int {
        return intval($this->format('Y'));
    }
    public function getYearInterval(int $year): DateInterval{
        return $this->getInterval('P'.$year.'Y');
    }

    //######### MONTHS #########
    public function addMonths(int $month): self{
        $this->add($this->getMonthInterval($month));
        return $this;
    }
    public function subMonths(int $month): self{
        $this->sub($this->getMonthInterval($month));
        return $this;
    }
    public function setMonth(int $month): self{
        $this->setDate($this->getYear(),$month,$this->getDay());
        return $this;
    }
    public function nextMonth(bool $strict = false): self{
        if($strict){
            $month_expected = $this->getMonth() + 1;
            $month_expected = ($month_expected > 12) ? 1 : $month_expected;
            $this->addMonths(1);
            if($month_expected != $this->getMonth()){
                $this->modifyLastDayOfPreviousMonth();
            }
        }
        else{
            $this->addMonths(1);
        }
        return $this;
    }
    public function previousMonth(bool $strict = false): self{
        if($strict){
            $month_expected = $this->getMonth() - 1;
            $month_expected = ($month_expected < 1) ? 12 : $month_expected;
            $this->subMonths(1);
            if($month_expected != $this->getMonth()){
                $this->modifyLastDayOfPreviousMonth();
            }
        }
        else{
            $this->subMonths(1);
        }
        return $this;
    }
    public function getMonth(): int {
        return intval($this->format('m'));
    }
    public function getMonthName(?string $language = null): string {
        if(is_null($language)){
            $name = ucfirst(utf8_encode(strftime("%B",$this->getTimestamp())));
        }
        else{
            $old = $this->getLocale()['LC_TIME'];
            setlocale(LC_TIME, $language);
            $name = ucfirst(utf8_encode(strftime("%B",$this->getTimestamp())));
            setlocale(LC_TIME, $old);
        }
        return $name;

    }
    public function getMonthInterval(int $month): DateInterval{
        return $this->getInterval('P'.$month.'M');
    }

    //######### DAYS #########
    public function addDays(int $day): self{
        $this->add($this->getDayInterval($day));
        return $this;
    }
    public function subDays(int $day): self{
        $this->sub($this->getDayInterval($day));
        return $this;
    }
    public function nextDay(): self{
        $this->addDays(1);
        return $this;
    }
    public function previousDay(): self{
        $this->subDays(1);
        return $this;
    }
    public function setDay(int $day): self{
        $this->setDate($this->getYear(),$this->getMonth(),$day);
        return $this;
    }
    public function getDay(): int{
        return intval($this->format('d'));
    }
    public function getDayString() {
        return $this->format('d');
    }
    public function getDayInWeek() {
        return intval($this->format('N'));
    }
    public function getDayInterval(int $day): DateInterval{
        return $this->getInterval('P'.$day.'D');
    }

    //######### HOURS #########
    public function addHours(int $hour): self{
        $this->add($this->getHourInterval($hour));
        return $this;
    }
    public function subHours(int $hour): self{
        $this->sub($this->getHourInterval($hour));
        return $this;
    }
    public function nextHour(): self{
        return $this->addHours(1);
    }
    public function previousHour(): self{
        return $this->subHours(1);
    }
    public function setHour(int $hour): self{
        $this->setTime($hour,$this->getMinute(),$this->getSecond());
        return $this;
    }
    public function getHour(bool $with_minutes = false): float{
        if($with_minutes){
            return round(intval($this->format('H')) + intval($this->format('i'))/60,4);
        }
        else{
            return intval($this->format('H'));
        }

    }
    public function getHourInterval(int $hour): DateInterval{
        return $this->getInterval('PT'.$hour.'H');
    }

    //######### MINUTES #########
    public function addMinutes(int $minute): self{
        $this->add($this->getMinuteInterval($minute));
        return $this;
    }
    public function subMinutes(int $minute): self{
        $this->sub($this->getMinuteInterval($minute));
        return $this;
    }
    public function nextMinute(): self{
        return $this->addMinutes(1);
    }
    public function previousMinute(): self{
        return $this->subMinutes(1);
    }
    public function setMinute(int $minute): self{
        $this->setTime($this->getHour(),$minute,$this->getSecond());
        return $this;
    }
    public function getMinute(): int {
        return intval($this->format('i'));
    }
    public function getMinuteInterval(int $minute): DateInterval{
        return $this->getInterval('PT'.$minute.'M');
    }

    //######### SECONDS #########
    public function addSeconds(int $second): self{
        $this->add($this->getSecondInterval($second));
        return $this;
    }
    public function subSeconds(int $second): self{
        $this->sub($this->getSecondInterval($second));
        return $this;
    }
    public function nextSecond(): self{
        return $this->addSeconds(1);
    }
    public function previousSecond(): self{
        return $this->subSeconds(1);
    }
    public function setSecond(int $second): self{
        $this->setTime($this->getHour(),$this->getMinute(),$second);
        return $this;
    }
    public function getSecond(): int {
        return intval($this->format('i'));
    }
    public function getSecondInterval(int $second): DateInterval{
        return $this->getInterval('PT'.$second.'S');
    }

    //######### MODIFY #########
    public function modifyLastDayOfThisMonth(): self{
        $this->modify('last day of this month');
        return $this;
    }
    public function modifyLastDayOfNextMonth(): self{
        $this->modify('last day of next month');
        return $this;
    }
    public function modifyLastDayOfPreviousMonth(): self{
        $this->modify('last day of previous month');
        return $this;
    }
    public function modifyFirstDayOfThisMonth() : self{
        $this->modify('first day of this month');
        return $this;
    }
    public function modifyFirstDayOfNextMonth() : self{
        $this->modify('first day of next month');
        return $this;
    }
    public function modifyFirstDayOfPreviousMonth() : self{
        $this->modify('first day of previous month');
        return $this;
    }

    //######### COMPARISON #########
    public function isSupOrEqual($date){
        if(is_null($date)){
            return FALSE;
        }
        return $this >= $date;
    }
    public function isInfOrEqual($date){
        if(is_null($date)){
            return FALSE;
        }
        return $this <= $date;
    }
    public function isBetween($start,$end) {
        return $this->isSupOrEqual($start)
            && ((!is_null($end)) ? $this->isInfOrEqual($end) : TRUE);
    }
    public function isSameMonthAndYear(DateTime $date) : bool{
        return
                ($this->getMonth() == $date->getMonth())
            &&  ($this->getYear() == $date->getYear());
    }

    //######### OUTPUT FORMAT #########
    public function formatDB() {
        return $this->format('Y-m-d H:i:s');
    }
    public function formatDate() {
        return $this->format('Y-m-d');
    }
    public function formatDateFrench() {
        return $this->format('d/m/Y');
    }
    public function formatDateTime() {
        return $this->format('Y-m-d H:i:s');
    }
    public function formatGoogle() {
        return $this->format('Y-m-d').'T'.$this->format('H:i:s');
    }
    public function formatDateTimeFile() {
        return $this->format('Y-m-d-His');
    }

    //######### INTERVAL #########
    public function interval(DateTimeInterface $date): DateInterval{
        return $this->diff($date);
    }
    public function intervalYear(DateTimeInterface $date): int{
        return $this->interval($date)->y;
    }
    public function intervalMonth(DateTimeInterface $date): int{
        return $this->interval($date)->m;
    }
    public function intervalDay(DateTimeInterface $date): int{
        return $this->interval($date)->d;
    }
    public function intervalHour(DateTimeInterface $date): int{
        return $this->interval($date)->h;
    }
    public function intervalMinute(DateTimeInterface $date): int{
        return $this->interval($date)->i;
    }
    public function intervalSecond(DateTimeInterface $date): int{
        return $this->interval($date)->s;
    }
    public function intervalFullDays(DateTimeInterface $date): float{
        return $this->intervalFullHours($date) / 24;
    }
    public function intervalFullHours(DateTimeInterface $date): float{
        return $this->intervalFullMinutes($date) / 60;
    }
    public function intervalFullMinutes(DateTimeInterface $date): float{
        return $this->intervalFullSeconds($date) / 60;
    }
    public function intervalFullSeconds(DateTimeInterface $date): int{
        $interval = $this->interval($date);
        return $interval->days * 24 * 60 * 60
            + $interval->h * 60 * 60
            + $interval->i * 60
            + $interval->s;
    }

    //######### OTHERS #########
    public function getInterval($interval_spec): DateInterval{
        return new DateInterval($interval_spec);
    }
    public function getLocale(): array{
        $locale = setlocale(LC_ALL, 0);
        $locale_vars = array();
        foreach(explode(';',$locale) as $item){

            $item = explode('=',$item);
            $key = $item[0];
            $value = $item[1];
            $locale_vars[$key] = $value;
        }
        return $locale_vars;
    }
    public function eraseTime(): self{
        $this->setTime(0,0,0);
        return $this;
    }
    public function getMicroTimestamp(): int{
        return $this->getTimestamp() * 1000;
    }
    public function setMicroTimestamp(int $microtimestamp): self{
        $this->setTimestamp($microtimestamp / 1000);
        return $this;
    }

    /**
     * @param DateTimeZone|string|null $timezone
     */
    public function setTimezone($timezone = null): self{
        if(is_null($timezone)){
            parent::setTimezone(new DateTimeZone('UTC'));
        }
        elseif(is_object($timezone)){
            parent::setTimezone($timezone);
        }
        else{
            parent::setTimezone(new DateTimeZone($timezone));
        }
        return $this;
    }
}