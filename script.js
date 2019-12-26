jQuery(document).ready(function() {
    jQuery("[id*=__achart_]").each(function(i, div) {
		try {
			var id = jQuery(div).attr('id');
			var adata= jQuery(div).attr('data-achart');

//Start localization

Apex.chart = {
  locales: [
    {
    name: "en",
    options: {
      months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      shortMonths: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      shortDays: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      toolbar: {
        download: "Download SVG",
        selection: "Selection",
        selectionZoom: "Selection Zoom",
        zoomIn: "Zoom In",
        zoomOut: "Zoom Out",
        pan: "Panning",
        reset: "Reset Zoom"
        }
      }
    },
{
  name: "fr",
  options: {
    months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
    shortMonths: ["janv.", "févr.", "mars", "avr.", "mai", "juin", "juill.", "août", "sept.", "oct.", "nov.", "déc."],
    days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
    shortDays: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
    toolbar: {
      exportToSVG: "Télécharger au format SVG",
      exportToPNG: "Télécharger au format PNG",
      menu: "Menu",
      selection: "Sélection",
      selectionZoom: "Sélection et zoom",
      zoomIn: "Zoomer",
      zoomOut: "Dézoomer",
      pan: "Navigation",
      reset: "Réinitialiser le zoom"
    }
  }
}
  ],

  defaultLocale: "en"
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
