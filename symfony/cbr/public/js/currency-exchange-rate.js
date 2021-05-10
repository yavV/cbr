function getCurrencyExchangeRate(f) {
    const date = document.getElementById('date');
    const infoBlock = document.getElementById('info_text');

    if (date.value === '') {
        infoBlock.innerText = "Введите дату!";
        return;
    }

    const currency = document.getElementById('currency');

    infoBlock.innerText = '';

    $.get("api/currency/exchange-rate-by-date/" + currency.value + "/" + date.value)
        .done(function (data) {
            if (data.hasOwnProperty('error')) {
                infoBlock.innerText = data.error;
            }

            if (data.hasOwnProperty('currentExchangeRate') && data.hasOwnProperty('previousExchangeRate')) {
                const diffRates = data.currentExchangeRate - data.previousExchangeRate;
                infoBlock.innerText = 'Курс валюты - ' + data.currentExchangeRate + ', разница с предыдущим днем - ' + diffRates.toFixed(4);
            }
        }).fail(function () {
        infoBlock.innerText = 'Произошла ошибка';
    });
}
