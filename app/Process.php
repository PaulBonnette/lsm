<?php

namespace App;

class Process
{
    protected bool $showCommand = false;
    protected bool $showOutput = false;
    function __construct(protected string $command) 
    {
    }
    static function Command() {

    }
    function showCommand() {
        $this->showCommand=true;
        return $this;
    }
    function showOutput() {
        $this->showOutput=true;
        return $this;
    }
    function Run(string $returnTrueIfFound='')
    {
        if ($this->showCommand) echo Helper::Out('Command',$this->command);
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
                if ($returnTrueIfFound!='' and strpos($s, $returnTrueIfFound)) {
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
