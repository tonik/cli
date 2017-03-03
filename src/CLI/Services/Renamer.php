<?php

namespace Tonik\CLI\Services;

class Renamer
{
    /**
     * File instance.
     *
     * @var \Symfony\Component\Finder\SplFileInfo
     */
    protected $file;

    /**
     * Construct renamer.
     *
     * @param \Symfony\Component\Finder\SplFileInfo $file
     */
    function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Inits renaming process.
     *
     * @param  array $values  Values map to replace.
     *
     * @return void
     */
    public function init(array $values)
    {
        foreach ($values as $replace => $to) {
            $this->replace($replace, $this->normalize($to));
        }
    }

    /**
     * Replaces strings in file content.
     *
     * @param  string $replace
     * @param  string $to
     *
     * @return void
     */
    protected function replace($replace, $to)
    {
        if ($this->file->getExtension() === 'json') {
            $replace = addslashes($replace);
        }

        file_put_contents(
            $this->file->getRealPath(),
            str_replace($replace, $to, $this->file->getContents())
        );
    }

    /**
     * Normalizes answer.
     *
     * @param  string $string
     *
     * @return string
     */
    protected function normalize($answer)
    {
        if ($this->file->getExtension() !== 'json') {
            $answer = stripslashes($answer);
        }

        return $answer;
    }
}