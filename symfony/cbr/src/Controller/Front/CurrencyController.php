<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Currency
 * @package App\Controller\Front
 */
class CurrencyController extends AbstractController
{
    private CurrencyRepository $currencyRepository;

    /**
     * CurrencyController constructor.
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @Route("/")
     * @return Response
     */
    public function index(): Response
    {
        $currenciesEntity = $this->currencyRepository->findAll();

        $currencies = [];

        if (count($currenciesEntity) > 0) {

            /**
             * @var Currency $currencyEntity
             */
            foreach ($currenciesEntity as $currencyEntity) {
                $currency = ['id' => $currencyEntity->getId(), 'name' => $currencyEntity->getIsoCharCode()];
                $currencies[] = $currency;
            }
        }

        return $this->render('currency/index.html.twig', [
            'currencies' => $currencies
        ]);
    }
}
