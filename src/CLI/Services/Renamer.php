<?php

namespace Tonik\CLI\Services;

class Renamer
{
    function __construct($file)
    {
        $this->file = $file;
    }

    public function init($values)
    {
        foreach ($values as $replace => $to) {
            $this->replace($replace, $this->normalize($to));
        }
    }

    public function replace($replace, $to)
    {
        if ($this->file->getExtension() === 'json') {
            $replace = addslashes($replace);
        }

        file_put_contents(
            $this->file->getRealPath(),
            str_replace($replace, $to, $this->file->getContents())
        );
    }

    public function normalize($string)
    {
        if ($this->file->getExtension() !== 'json') {
            $string = stripslashes($string);
        }

        return $string;
    }
}