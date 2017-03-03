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
    protected $answers = [
        'Tonik Theme' => 'Theme Name',
        'https://github.com/tonik/tonik' => 'Theme URI',
        'Modern Starter Theme' => 'Theme Description',
        '2.0.0' => 'Theme Version',
        'Tonik' => 'Author',
        'http://tonik.pl' => 'Author Website',
        'tonik' => 'Theme Textdomain',
        'App\Theme' => 'My\\\\New\\\\Theme',
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

    /**
     * @test
     */
    public function test_shaking_a_theme()
    {
        $shake = (new Shake(new Finder))->dir($this->testDir);

        $shake->rename($this->answers);

        $this->assertContains('My\New\Theme\Rest\Of\Namespace', file_get_contents("$this->testDir/namespace.php"));
        $this->assertContains('My\\\\New\\\\Theme\\\\Rest\\\\Of\\\\Namespace', file_get_contents("$this->testDir/namespace.json"));

        $this->assertContains("add_action('init', 'My\New\Theme\Rest\Of\Namespace');", file_get_contents("$this->testDir/hooks.php"));
        $this->assertContains("add_filter('excerpt', 'My\New\Theme\Rest\Of\Namespace');", file_get_contents("$this->testDir/hooks.php"));

        $this->assertContains("'textdomain' => 'Theme Textdomain'", file_get_contents("$this->testDir/config.php"));

        $this->assertContains('Theme Name: Theme Name', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Theme URI: Theme URI', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Description: Theme Description', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Version: Theme Version', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Author: Author', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Author URI: Author Website', file_get_contents("$this->testDir/style.css"));
        $this->assertContains('Text Domain: Theme Textdomain', file_get_contents("$this->testDir/style.css"));
    }
}