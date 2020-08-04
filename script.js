/* DOKUWIKI:include_once assets/js-yaml.min.js */
/* DOKUWIKI:include_once assets/apexcharts.min.js */

jQuery(document).ready(function() {
    jQuery("[id*=__achart_]").each(function(i, div) {
		try {
			var id = jQuery(div).attr('id');
			var adata= jQuery(div).attr('data-achart');

	//Starting localization
	var lang = JSON.parse(JSINFO.chartlocale);
	Apex.chart= {
	   locales: [lang],
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
