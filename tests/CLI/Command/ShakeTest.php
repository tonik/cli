<?php

use League\CLImate\CLImate;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\CLI;
use Tonik\CLI\Command\Shake;

class ShakeTest extends PHPUnit_Framework_TestCase
{
    private $fixturesDir;
    private $testDir;
    private $tempDir;

    /**
     * List of questions.
     *
     * @var array
     */
    protected $answers = [
        'Tonik Theme' => 'Theme Name',
        'https://github.com/tonik/tonik' => 'Theme URI',
        'Modern Starter Theme' => 'Theme Description',
        '2.0.0' => 'Theme Version',
        'Tonik' => 'Author',
        'http://tonik.pl' => 'Author Website',
        'tonik' => 'Theme Textdomain',
        'App\Theme' => 'Theme Namespace',
    ];

    protected function setUp()
    {
        $this->fixturesDir = dirname(__DIR__).'/../fixtures';
        $this->testDir = "{$this->fixturesDir}/test";
        $this->tempDir = "{$this->fixturesDir}/temp";

        exec("cp -R $this->testDir $this->tempDir");
    }

    protected function tearDown()
    {
        exec("rm -rf $this->testDir");
        exec("mv $this->tempDir $this->testDir");
    }

    function test_command()
    {
        $shake = (new Shake(new Finder))->dir($this->testDir);

        $shake->rename($this->answers);

        $this->assertEquals('Theme Name
Theme URI
Theme Description
Theme Version
Author
Author Website
Theme Textdomain
Theme Namespace', file_get_contents("$this->testDir/replace.php"));
    }
}