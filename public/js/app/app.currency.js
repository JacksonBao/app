// Currency JS 
var apiKey = 'n3lHV1gYzUWdSuq1zxxPe8QYWRlswSph';
var vault = {
    'from_amount' : 0,
    'to_amount' : 0,
    'from_currency' : 'USD',
    'to_currency' : 'CAD',
    'from_rate' : 0,
    'to_rate' : 0,
};
function recalculateRates( change ) {
    var form = new ValidateForm();
  form.inputs = [...[
    { name: 'from_amount', value: $('#_from_amount').val(), id: '_from_amount', meth: 'int', strict: false, min: 1, max: 255, message: 'Invalid from amount' },
    { name: 'to_amount', value: $('#_to_amount').val(), id: '_to_amount', meth: 'int', strict: false, min: 1, max: 255, message: 'Invalid to amount.' },
    { name: 'from', value: $('#_from_currency').val(), id: '_from_currency', meth: 'string', strict: false, min: 3, max: 4, message: 'Invalid from currency.' },
    { name: 'to', value: $('#_to_currency').val(), id: '_to_currency', meth: 'string', strict: false, min: 3, max: 4, message: 'Invalid to curerncy.' },
  ]];

  
  var result = form.sanitizeForm();
  if (form.hasError == false) {
      console.log(change, vault)
    if(result.from == vault.from_currency && result.to == vault.to_currency && vault.from_amount > 0){
        reCalculate(change);
    } else { // send request to get rates from the database
        result.key = apiKey;
        result.amount = 1;
        $.get(
            'http://v1.thanosapi.dv/currency/convert',
            result,
            (response) => {
                if(response.success == true){
                    vault.to_rate = response.rate;
                    vault.from_rate = (1 / response.rate);
                    // vault.from_rate = Math.round((1 / response.rate), 6);
                    vault.from_currency = result.from;
                    vault.to_currency = result.to;
                    vault.from_amount = result.from_amount;
                    vault.to_amount = result.to_amount;
                    reCalculate('from');
                } else {
                    snackBar(response.message, 'danger');
                }
            }).fail((e)=>{
            console.log(e);
            snackBar('Sorry could not process your request.');
        });
    }
  }  else {
  console.log('fasfasdddddd')
    snackBar(form.errorMessages);
    formErr(form.errorId, form.errorMessages);
  }
}

var currencies = []
function intCurrency() {
    if(Cookie.checkCookie('currencies') == false) {
    $.get(
        'http://v1.thanosapi.dv/currency/list',
        {key : apiKey},
        (result)=>{
            if(result.success == true){
                for (let index = 0; index < result.codes.length; index++) {
                    const element = result.codes[index];
                    currencies.push(element.code);
                }
                Cookie.setCookie('currencies', JSON.stringify(currencies), 30);
                assembleCurrencies();
            } else {
                snackBar(result.message, 'danger');
            }
        }).fail(function (e) {
            console.log(e);
        });
    } else {
        currencies = JSON.parse(Cookie.getCookie('currencies'));
        assembleCurrencies();
    }
}

jQuery(intCurrency);

function assembleCurrencies() {
    for (let index = 0; index < currencies.length; index++) {
        const element = currencies[index];
        
        $('#_from_currency').append(`<option value="${element}" ${(element == vault.from_currency ? 'selected' : '')}>${ element }</option>`);
        $('#_to_currency').append(`<option value="${element}" ${(element == vault.to_currency ? 'selected' : '')}>${ element }</option>`);
    }
    recalculateRates('from')

}

function reCalculate( base ) {
    if(base == 'from'){
        var amt = (vault.to_rate * $('#_from_amount').val()).toFixed(3);
        $('#_to_amount').val(amt);
    } else { // to
        var amt = (vault.from_rate * $('#_to_amount').val()).toFixed(3);
        $('#_from_amount').val(amt);
    }
    $('#_convertAmount').html($('#_to_amount').val() + '' + vault.to_currency);
    $('#_convertText').html(vault.from_amount + vault.from_currency + ' to ' + vault.to_currency);
}