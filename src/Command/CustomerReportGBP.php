<?php

namespace Report\Command;

use Report\Report;
use Report\Exceptions\TransactionNotFound;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CustomerReportGBP extends Command
{
    private $report;

    protected static $defaultName = 'report:GBP';

    public function __construct(Report $report)
    {
        parent::__construct();
        $this->report = $report;
    }

    protected function configure() : void
    {
        $this
            ->setDescription('Insert customerId')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('customerId', 'c', InputOption::VALUE_REQUIRED)
                ])
            );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {       
        try {
            $customerId = (int) $input->getOption('customerId');
            $convertReport = $this->report->convertTransacionByCustomerId($customerId, 'GBP');
            $table = new Table($output);
            $table->setHeaders(["Customer ID","Data","Valore"]);
            $tableRows = [];
            foreach ($convertReport as $chunkReport) {
                $tableRows[] = [
                    $chunkReport['customer'],
                    $chunkReport['data']->format('d/m/Y'),
                    \sprintf('£ %s', $chunkReport['convertValue']),
                ];
            }

            $table->setRows($tableRows);
            $table->render();

            return Command::SUCCESS;
        } catch (TransactionNotFound $th) {
            $output->writeln(\sprintf('<fg=red>%s</>', $th->getMessage()));
            return Command::FAILURE;
        }
    }
}