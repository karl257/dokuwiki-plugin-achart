jQuery(document).ready(function() {
    jQuery("[id*=__achart_]").each(function(i, div) {
		try {
			var id = jQuery(div).attr('id');
			var adata= jQuery(div).attr('data-achart');

/*Start localization
 *L’utilisation d’XMLHttpRequest de façon synchrone sur le fil d’exécution principal 
 *est obsolète à cause de son impact négatif sur la navigation de l’utilisateur final. 
 *Consulter http://xhr.spec.whatwg.org/ pour plus d’informations.
*/
jQuery.ajaxSetup({
    async: false
});
var jsonData= (function() {
    var result;
    jQuery.getJSON(DOKU_BASE+"lib/plugins/achart/assets/locales/"+ JSINFO.chartlang +".json", {}, function(data){
      result = data;
    });
    return result;
})();
var lang = JSON.parse(JSON.stringify([jsonData]));
Apex.chart= {
   locales: lang,
   defaultLocale: JSINFO.chartlang,
 };
//Ending localization

			var options  = jsyaml.load(decodeURIComponent(escape(atob(adata))));
			var chart    = new ApexCharts(document.getElementById(id), options);
            chart.render();

		} catch(err) {
			console.warn(err.message);
		}
	});
});
