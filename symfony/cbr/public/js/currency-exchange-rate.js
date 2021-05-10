function getCurrenciesExchangeRate(f) {
    const date = document.getElementById('date');
    const infoElement = document.getElementById('infoText');

    if (date.value === '') {
        infoElement.innerText = "Введите дату!";
        return;
    }

    const currency = document.getElementById('currency');

    const currencyBase = document.getElementById('currencyBase');

    if (currency.value === currencyBase.value) {
        infoElement.innerText = "Введите отличные валюты!";
        return;
    }

    infoElement.innerText = '';
    $.ajax({
        type: "POST",
        url: "api/currency/exchange-rate-by-date",
        data: JSON.stringify({
            currency: currency.value,
            currencyBase: currencyBase.value,
            date: date.value
        }),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: function (data) {
            if (data.hasOwnProperty('error')) {
                infoElement.innerText = data.error;
            }
            if (data.hasOwnProperty('currentExchangeRate') && data.hasOwnProperty('previousExchangeRate')) {
                const diffRates = (data.currentExchangeRate - data.previousExchangeRate)/10000;
                const currentExchangeRate = data.currentExchangeRate/10000;
                infoElement.innerText = 'Курс валюты : ' + currentExchangeRate + ', разница с предыдущим днем : ' + diffRates;
            }
        },
        error: function () {
            infoElement.innerText = 'Произошла ошибка';
        }
    });
}
