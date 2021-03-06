<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CurrencyExchangeRateDTO;
use App\Repository\CurrencyRepository;
use App\Request\CurrencyExchangeRateRequest;
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

    private CurrencyRepository $currencyRepository;

    /**
     * CurrencyExchangeRateController constructor.
     * @param CurrencyService $currencyService
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyService $currencyService, CurrencyRepository $currencyRepository)
    {
        $this->currencyService = $currencyService;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @Rest\Post("/exchange-rate-by-date")
     * @ParamConverter("currencyExchangeRateRequest", class="App\Request\CurrencyExchangeRateRequest", converter="fos_rest.request_body")
     * @return CurrencyExchangeRateDTO|JsonResponse
     */
    public function getByCurrencyAndDate(CurrencyExchangeRateRequest $currencyExchangeRateRequest)
    {
        $currency = $this->currencyRepository->findOneBy(['id' => $currencyExchangeRateRequest->getCurrency()]);

        if ($currency === null) {
            return new JsonResponse(['error' => 'Валюта не найдена']);
        }

        $currencyBase = $this->currencyRepository->findOneBy(['id' => $currencyExchangeRateRequest->getCurrencyBase()]);

        if ($currencyBase === null) {
            return new JsonResponse(['error' => 'Базовая валюта не найдена']);
        }

        $date = DateTime::createFromFormat(DATE_ATOM, $currencyExchangeRateRequest->getDate()->format(DATE_ATOM));

        $currencyExchangeRates = $this->currencyService->getCurrencyExchangeRatesForDate($date,
            $currency, $currencyBase);

        if ($currencyExchangeRates === null) {
            return new JsonResponse(['error' => 'Котировки не найдены']);
        }

        return new JsonResponse([
            'currentExchangeRate' => $currencyExchangeRates[0]->getValue(),
            'previousExchangeRate' => $currencyExchangeRates[1]->getValue()
        ]);
    }
}
