<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\CurrencyService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/currency")
 * Class CurrencyExchangeRate
 * @package App\Controller\Api
 */
class CurrencyExchangeRate extends AbstractFOSRestController
{
    private CurrencyService $currencyService;

    /**
     * CurrencyExchangeRate constructor.
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }


    /**
     * @Rest\Get("/exchange-rate-by-date/{idCurrency}/{date}", requirements={"idCurrency": "\d+", "date": "(19|20)[0-9][0-9]-[0-9][0-9]-[0-9][0-9]"})
     */
    public function getByCurrencyAndDate(int $idCurrency, string $date)
    {
        $jsonResponse = new JsonResponse('qqq');
        return $jsonResponse;

    }

}