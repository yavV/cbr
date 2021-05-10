function getCurrencyExchangeRate(f) {
    const date = document.getElementById('date');
    const infoBlock = document.getElementById('info_text');

    if (date.value === '') {
        infoBlock.innerText = "Введите дату!";
        return;
    }

    const currency = document.getElementById('currency');

    $.get("api/currency/exchange-rate-by-date/" + currency.value + "/" + date.value)
        .done(function (data) {
            if (data.hasOwnProperty('error')) {
                infoBlock.innerText = data.error;
            }

            if (data.hasOwnProperty('exchangeRate')) {
                infoBlock.innerText = 'Курс валюты - ' + data.exchangeRate;
            }
        }).fail(function () {
        infoBlock.innerText = 'Произошла ошибка';
    });
}
