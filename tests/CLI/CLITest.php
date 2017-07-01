<?php

use Tonik\CLI\CLI;

class CLITest extends PHPUnit_Framework_TestCase
{
    protected $inputs = [
        '{{ theme.name }}' => 'Theme Name',
        '{{ theme.url }}' => 'Theme Website',
        '{{ theme.description }}' => 'Theme Description',
        '{{ theme.version }}' => 'Theme Version',
        '{{ theme.author }}' => 'Author',
        '{{ theme.author.url }}' => 'Author Website',
        '{{ theme.textdomain }}' => 'Theme Textdomain',
        'App\Theme' => 'Theme\New\Name',
    ];

    public function setUp()
    {
        $this->climate = Mockery::mock('League\CLImate\CLImate');
        $this->arguments = Mockery::mock('League\CLImate\Argument\Manager');

        $this->arguments->shouldReceive('add')->with([
            'help' => [
                'prefix' => 'h',
                'longPrefix' => 'help',
                'description' => 'Shake command help guide',
                'noValue' => true,
            ],
        ])->once();

        $this->climate->arguments = $this->arguments;
        $this->cli = new CLI($this->climate);
    }

    /**
     * @test
     */
    public function test_drawing_a_banner()
    {
        $this->climate->shouldReceive('addArt')->once();
        $this->climate->shouldReceive('draw')->once()->with('tonik');

        $this->cli->drawBanner();
    }

    /**
     * @test
     */
    public function test_asking_a_questions()
    {
        $input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');

        foreach ($this->cli->getQuestions() as $placeholder => $message) {
            $this->climate->shouldReceive('input')->once()->with($message)->andReturn($input);
            $input->shouldReceive('defaultTo')->once()->with($placeholder)->andReturn($input);
            $input->shouldReceive('prompt')->once()->withNoArgs()->andReturn($this->inputs[$placeholder]);
        }

        $this->cli->askQuestions();

        $this->assertEquals($this->inputs, $this->cli->getAnswers());
    }

    /**
     * @test
     */
    public function test_asking_for_a_confrimation_with_true_input()
    {
        $input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');

        $this->climate->shouldReceive('confirm')->once()->with(Mockery::any())->andReturn($input);

        $input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(true);
        $this->assertTrue($this->cli->askForConfirmation());
    }

    /**
     * @test
     */
    public function test_asking_for_a_confrimation_with_false_input()
    {
        $input = Mockery::mock('League\CLImate\TerminalObject\Dynamic\Input');

        $this->climate->shouldReceive('confirm')->once()->with(Mockery::any())->andReturn($input);

        $input->shouldReceive('confirmed')->once()->withNoArgs()->andReturn(false);
        $this->assertFalse($this->cli->askForConfirmation());
    }

    /**
     * @test
     */
    public function test_execution_run_with_help_argument()
    {
        $shake = Mockery::mock('Tonik\CLI\Command\Shake');

        $this->test_drawing_a_banner();

        $this->arguments->shouldReceive('parse')->once()->withNoArgs();
        $this->arguments->shouldReceive('defined')->once()->with('help')->andReturn(true);
        $this->climate->shouldReceive('usage')->once()->withNoArgs();

        $this->cli->run($shake);
    }

    /**
     * @test
     */
    public function test_proper_execution_run()
    {
        $shake = Mockery::mock('Tonik\CLI\Command\Shake');

        $this->arguments->shouldReceive('parse')->once()->withNoArgs();
        $this->arguments->shouldReceive('defined')->once()->with('help')->andReturn(false);

        $this->test_drawing_a_banner();
        $this->test_asking_a_questions();
        $this->test_asking_for_a_confrimation_with_true_input();

        $shake->shouldReceive('rename')->once();
        $this->climate->shouldReceive('backgroundLightGreen')->with(Mockery::any());

        $this->cli->run($shake);
    }

    /**
     * @test
     */
    public function test_abored_execution_run()
    {
        $shake = Mockery::mock('Tonik\CLI\Command\Shake');

        $this->arguments->shouldReceive('parse')->once()->withNoArgs();
        $this->arguments->shouldReceive('defined')->once()->with('help')->andReturn(false);

        $this->test_drawing_a_banner();
        $this->test_asking_a_questions();
        $this->test_asking_for_a_confrimation_with_false_input();

        $shake->shouldReceive('rename')->never();
        $this->climate->shouldReceive('backgroundRed')->with(Mockery::any());

        $this->cli->run($shake);
    }
}