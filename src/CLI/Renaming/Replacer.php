<?php

namespace Tonik\CLI\Renaming;

use Symfony\Component\Finder\SplFileInfo;

class Replacer
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
    function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /**
     * Inits renaming process.
     *
     * @param  array $replacements  Values map to replace.
     *
     * @return void
     */
    public function swap(array $replacements)
    {
        foreach ($replacements as $from => $to) {
            $this->replace($from, $this->normalize($to));
        }
    }

    /**
     * Replaces strings in file content.
     *
     * @param  string $from
     * @param  string $to
     *
     * @return void
     */
    protected function replace($from, $to)
    {
        if ($this->file->getExtension() === 'json') {
            $from = addslashes($from);
        }

        file_put_contents(
            $this->file->getRealPath(),
            str_replace($from, $to, $this->file->getContents())
        );
    }

    /**
     * Normalizes replacement.
     *
     * @param  string $string
     *
     * @return string
     */
    protected function normalize($replacement)
    {
        if ($this->file->getExtension() !== 'json') {
            $replacement = stripslashes($replacement);
        }

        return $replacement;
    }
}
