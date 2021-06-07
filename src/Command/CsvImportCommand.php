<?php

namespace Command;

use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CsvImportCommand
 * @package ConsoleCommand
 */
class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
//php bin/console csv:import;
        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports the mock CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/MOCK_DATA.csv');

        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();

        foreach ($results as $row) {

            // create new film
            $work = (new Film())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setYearOfCopyright($row['year_of_copyright'])
                ->setStatus("New")
            ;

            $this->em->persist($work);

           /* // create new Competitor
            $competitor = (new Competitor())
                ->setCategory($row['category'])
                ->setCompetition($row['competition'])
            ;

            $this->em->persist($competitor);

            $athlete->setCompetitor($competitor);*/ 
        }

        $this->em->flush();

        $io->success('Command exited cleanly!');
    }
}