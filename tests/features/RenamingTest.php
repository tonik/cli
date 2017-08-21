<?php

use League\CLImate\CLImate;
use Symfony\Component\Finder\Finder;
use Tonik\CLI\CLI;
use Tonik\CLI\Command\Shake;
use Tonik\CLI\Renaming\Renamer;

class RenamingTest extends PHPUnit_Framework_TestCase
{
    private $fixturesDir;
    private $renamingDir;
    private $tempDir;
    protected $answers = [
        '{{ theme.name }}' => 'Theme Name',
        '{{ theme.url }}' => 'Theme URI',
        '{{ theme.description }}' => 'Theme Description',
        '{{ theme.version }}' => 'Theme Version',
        '{{ theme.author }}' => 'Author',
        '{{ theme.author.url }}' => 'Author Website',
        '{{ theme.textdomain }}' => 'Theme Textdomain',
        'App\Theme' => 'My\\\\New\\\\Theme',
    ];

    protected function setUp()
    {
        $this->fixturesDir = dirname(__DIR__).'/fixtures';
        $this->renamingDir = "{$this->fixturesDir}/renaming";
        $this->tempDir = "{$this->fixturesDir}/.temp";

        $test = escapeshellarg($this->renamingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("cp -R $test $temp");
    }

    protected function tearDown()
    {
        $test = escapeshellarg($this->renamingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("rm -rf $test");
        exec("mv $temp $test");
    }

    /**
     * @test
     */
    public function test_renaming_a_theme()
    {
        (new Renamer($this->renamingDir))->replace($this->answers);

        $this->assertContains('My\New\Theme\Rest\Of\Name', file_get_contents("$this->renamingDir/namespace.php"));
        $this->assertContains('My\\\\New\\\\Theme\\\\Rest\\\\Of\\\\Name', file_get_contents("$this->renamingDir/namespace.json"));

        $this->assertContains("add_action('init', 'My\New\Theme\Rest\Of\Name');", file_get_contents("$this->renamingDir/hooks.php"));
        $this->assertContains("add_filter('excerpt', 'My\New\Theme\Rest\Of\Name');", file_get_contents("$this->renamingDir/hooks.php"));

        $this->assertContains("'textdomain' => 'Theme Textdomain'", file_get_contents("$this->renamingDir/config.php"));

        $this->assertContains('Theme Name: Theme Name', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Theme URI: Theme URI', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Description: Theme Description', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Version: Theme Version', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Author: Author', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Author URI: Author Website', file_get_contents("$this->renamingDir/style.css"));
        $this->assertContains('Text Domain: Theme Textdomain', file_get_contents("$this->renamingDir/style.css"));
    }
}
