<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CurrencyExchangeRateDTO;
use App\Entity\Currency;
use App\Service\CurrencyService;
use DateTime;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/currency")
 * Class CurrencyExchangeRateController
 * @package App\Controller\Api
 */
class CurrencyExchangeRateController extends AbstractFOSRestController
{
    private CurrencyService $currencyService;

    /**
     * CurrencyExchangeRateController constructor.
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @Rest\Get("/exchange-rate-by-date/{id}/{date}", requirements={"id": "\d+", "date": "(19|20)[0-9][0-9]-[0-9][0-9]-[0-9][0-9]"})
     * @ParamConverter("Currency", class="App\Entity\Currency")
     * @param Currency $currency
     * @param string $date
     * @return CurrencyExchangeRateDTO|JsonResponse
     */
    public function getByCurrencyAndDate(Currency $currency, string $date)
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);

        $currencyExchangeRate = $this->currencyService->getCurrencyExchangeRateForDate($dateTime,
            $currency->getIsoCharCode());

        if ($currencyExchangeRate === null) {
            return new JsonResponse(['error' => 'Котировка не найдена']);
        }

        return new JsonResponse(['exchangeRate' => $currencyExchangeRate->getValue()]);
    }
}
