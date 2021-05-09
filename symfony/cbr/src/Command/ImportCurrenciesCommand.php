<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CurrencyDTO;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCurrenciesCommand extends Command
{
    private CurrencyRepository $currencyRepository;

    private CurrencyService $currencyService;

    /**
     * ImportCurrenciesCommand constructor.
     * @param CurrencyRepository $currencyRepository
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyRepository $currencyRepository, CurrencyService $currencyService)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
        $this->currencyService = $currencyService;
    }

    protected function configure(): void
    {
        $this->setName('app:currencies:import');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $returnValue = 0;

        $currencies = $this->currencyRepository->findAll();
var_dump($currencies);
        if (count($currencies) === 0){
            foreach ($currencies as $currency){
                $this->currencyRepository->remove($currency);
            }
        }

        $newCurrencies = $this->currencyService->getCurrenciesVocabulary();

        $count = 0;
        /**
         * @var CurrencyDTO $newCurrency
         */
        foreach ($newCurrencies as $newCurrency){
            $currencyEntity = new Currency();
            $currencyEntity
                ->setName($newCurrency->getName())
                ->setEngName($newCurrency->getEngName())
                ->setNominal($newCurrency->getNominal())
                ->setIsoCharCode($newCurrency->getIsoCharCode())
                ->setIsoNumCode($newCurrency->getIsoNumCode())
            ;
            var_dump($currencyEntity);
            $this->currencyRepository->save($currencyEntity);
        $count++;
        }

        echo "Imported - $count currencies\n";

        return $returnValue;
    }

}