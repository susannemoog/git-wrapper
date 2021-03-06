<?php declare(strict_types=1);

namespace GitWrapper\Test;

use GitWrapper\GitCommand;

final class GitCommandTest extends AbstractGitWrapperTestCase
{
    public function testCommand(): void
    {
        $command = $this->randomString();
        $argument = $this->randomString();
        $flag = $this->randomString();
        $optionName = $this->randomString();
        $optionValue = $this->randomString();

        $git = new GitCommand($command);
        $git->addArgument($argument);
        $git->setFlag($flag);
        $git->setOption($optionName, $optionValue);

        $expected = [$command, "--${flag}", "--${optionName}", $optionValue, $argument];
        $commandLine = $git->getCommandLine();

        $this->assertSame($expected, $commandLine);
    }

    public function testOption(): void
    {
        $optionName = $this->randomString();
        $optionValue = $this->randomString();

        $git = new GitCommand();
        $git->setOption($optionName, $optionValue);

        $this->assertSame($optionValue, $git->getOption($optionName));

        $git->unsetOption($optionName);
        $this->assertNull($git->getOption($optionName));
    }

    public function testMultiOption(): void
    {
        $git = new GitCommand('test-command');
        $git->setOption('test-arg', [true, true]);

        $expected = ['test-command', '--test-arg', '--test-arg'];
        $commandLine = $git->getCommandLine();

        $this->assertSame($expected, $commandLine);
    }
}
