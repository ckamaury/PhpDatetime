<?php


namespace CkAmaury\PhpDatetime;

class Timer{

    private ?float $start;
    private array $steps;
    private ?float $end;

    public function __construct(){
        $this->clean();
    }

    public function start(): void{
        $this->start = microtime(true);
    }
    public function step(): void{
        $this->steps[] = microtime(true);
    }
    public function stop(): float{
        $this->end = microtime(true);
        $this->steps[] = $this->end;
        return $this->end - $this->start;
    }
    public function clean(): void{
        $this->start = null;
        $this->steps = array();
        $this->end = null;
    }

    public function getData(): array{
        $data = array();
        $previous = $this->start;
        foreach($this->steps as $step){
            $data[] = [
                'diff_start' => round($step - $this->start,4),
                'diff_previous' => round($step - $previous,4)
            ];
        }
        return $data;
    }
}