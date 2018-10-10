<?php

namespace App\Command;

use App\Entity\EntryCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendCodeCommand extends Command
{
    protected static $defaultName = 'app:send-code';

    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * SendCodeCommand constructor.
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     */
    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer)
    {
        parent::__construct();
        $this->em = $em;
        $this->mailer = $mailer;
    }


    protected function configure()
    {
        $this
            ->setDescription('Send Email to all winners')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $codes = $this->em->getRepository(EntryCode::class)->findAll();

        foreach($codes as $code){
            if ($code instanceof EntryCode){
                $io->comment($code->getEmail());
                $message = (new \Swift_Message('Test Email'))
                    ->setFrom('send@example.com')
                    ->setTo($code->getEmail())
                    ->setBody("Test");

                $this->mailer->send($message);
            }
        }



        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
