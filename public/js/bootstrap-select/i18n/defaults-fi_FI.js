!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){e.fn.selectpicker.defaults={noneSelectedText:"Ei valintoja",noneResultsText:"Ei hakutuloksia {0}",countSelectedText:function(e,t){return 1==e?"{0} valittu":"{0} valitut"},maxOptionsText:function(e,t){return["Valintojen maksimimäärä ({n} saavutettu)","Ryhmän maksimimäärä ({n} saavutettu)"]},selectAllText:"Valitse kaikki",deselectAllText:"Poista kaikki",multipleSeparator:", "}});