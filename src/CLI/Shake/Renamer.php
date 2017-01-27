<?php

namespace Tonik\CLI\Shake;

use Symfony\Component\Finder\Finder;

class Renamer
{
    /**
     * Directories to ignore on files finding.
     *
     * @var array
     */
    protected $ignore = [
        "node_modules",
        "vendor",
    ];

    function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function init($dir, $answers, $callback = null)
    {
        foreach ($this->files($dir) as $file) {
            $this->replaceMocksWithAnswers($file, $answers);

            if (isset($callback)) {
                call_user_func($callback);
            }
        }
    }

    public function replaceMocksWithAnswers($file, $answers)
    {
        foreach ($answers as $key => $answer) {
            if ($file->getExtension() !== 'json') {
                $answer = stripslashes($answer);
            }

            file_put_contents(
                $file->getRealPath(),
                str_replace("{{ {$key} }}", $answer, $file->getContents())
            );
        }
    }

    public function files($dir)
    {
        return $this->finder->files()
            ->name('*.php')
            ->name('*.css')
            ->name('*.json')
            ->exclude($this->ignore)
            ->in($dir);
    }

    /**
     * Gets the Directories to ignore on files finding.
     *
     * @return array
     */
    public function getIgnored()
    {
        return $this->ignore;
    }
}