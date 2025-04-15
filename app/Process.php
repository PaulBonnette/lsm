<?php

namespace App;

class Process
{
    protected bool $showCommand = false;
    protected bool $showOutput = false;
    protected string $returnTrueIfFound = '';

    function __construct(protected string $command) 
    {
    }
    static function Command (string $command) {
        return new Process($command);
    }
    function showCommand() {
        $this->showCommand=true;
        return $this;
    }
    function showOutput() {             // chown may not work with proc_open
        $this->showOutput=true;
        return $this;
    }
    function find($str) {
        $this->returnTrueIfFound=$str;
        return $this;
    }
    function Run()
    {
        if ($this->showCommand) 
            echo Helper::Out('Command',$this->command);
        if (!$this->showOutput) {       // sudo commands run better with exec(). chown certainly does!
            exec($this->command);
            return;
        }
        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );
        flush();
        $process = proc_open($this->command, $descriptorspec, $pipes, realpath('./'), array());
        if (is_resource($process)) {
            while ($s = fgets($pipes[1])) {
                if ($this->showOutput)  echo Helper::Out('Output',$s);
                if ($this->returnTrueIfFound!='' and strpos($s, $this->returnTrueIfFound)) {
                    return true;
                }
                flush();
            }
        }
        return false;
    }
    function DontRun(string $returnTrueIfFound='')
    {
        if ($this->showCommand) echo Helper::Out('Command',$this->command);
        return false;
    }
}