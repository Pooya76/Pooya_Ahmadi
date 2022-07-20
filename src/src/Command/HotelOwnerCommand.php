<?php

namespace App\Command;

use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;

#[AsCommand(
    name: 'app:hotel:owner',
    description: 'Add a short description for your command',
)]
class HotelOwnerCommand extends Command
{
    private HotelRepository $hotelRepository;

    /**
     * @param HotelRepository $hotelRepository
     */
    public function __construct(HotelRepository $hotelRepository, string $name = null)
    {
        parent::__construct($name);

        $this->hotelRepository = $hotelRepository;

    }


    protected function configure(): void
    {
        $this
            ->setDescription("Hotel owners and their hotels");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $hotels = $this->hotelRepository->findAll();

        $section = $output->section();
        $table = new Table($section);
        $table->setHeaders(['Username', 'Hotel name']);
        foreach ($hotels as $hotel){
            $table->addRow(
                [ $hotel->getCreatedBy()->getEmail(), $hotel->getName()],
            );
        }
        $table->render();
        return Command::SUCCESS;
    }
}
