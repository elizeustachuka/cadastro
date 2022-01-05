$(document).ready(function() {
    $("input.money").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false, numeralMaxLength: true});
});