<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\Core;

use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\CommandRunner;

abstract class BaseCommand extends \CodeIgniter\CLI\BaseCommand
{

    protected $autoFlush = true;

    /**
     * Command constructor.
     *
     * @param \Psr\Log\LoggerInterface       $logger
     * @param \CodeIgniter\CLI\CommandRunner $commands
     */
    public function __construct(LoggerInterface $logger, CommandRunner $commands)
    {
        parent::__construct($logger, $commands);

        if ($this->autoFlush)
        {
            while (ob_get_level() > 0)
            {
                ob_end_flush();
            }
        }
    }

}