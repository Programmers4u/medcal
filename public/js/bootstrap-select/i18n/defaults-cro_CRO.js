!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){e.fn.selectpicker.defaults={noneSelectedText:"Odaberite stavku",noneResultsText:"Nema rezultata pretrage {0}",countSelectedText:function(e,t){return 1==e?"{0} stavka selektirana":"{0} stavke selektirane"},maxOptionsText:function(e,t){return[1==e?"Limit je postignut ({n} stvar maximalno)":"Limit je postignut ({n} stavke maksimalno)",1==t?"Grupni limit je postignut ({n} stvar maksimalno)":"Grupni limit je postignut ({n} stavke maksimalno)"]},selectAllText:"Selektiraj sve",deselectAllText:"Deselektiraj sve",multipleSeparator:", "}});