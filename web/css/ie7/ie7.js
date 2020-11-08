/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'bpone_bi\'">' + entity + '</span>' + html;
	}
	var icons = {
		'bp-arrow-up': '&#xe92b;',
		'bp-arrow-down': '&#xe92c;',
		'bp-arrow-left': '&#xe92d;',
		'bp-arrow-right': '&#xe92e;',
		'bp-chart--funel': '&#xe927;',
		'bp-chart--grid': '&#xe928;',
		'bp-chart--area': '&#xe91f;',
		'bp-chart--bar': '&#xe920;',
		'bp-chart--colum_line': '&#xe921;',
		'bp-chart--colum': '&#xe922;',
		'bp-chart--donut': '&#xe923;',
		'bp-chart--kpi': '&#xe924;',
		'bp-chart--line': '&#xe925;',
		'bp-chart--pie': '&#xe926;',
		'bp-plus': '&#xe929;',
		'bp-plus--circle': '&#xe91b;',
		'bp-close--circle-o': '&#xe91c;',
		'bp-close': '&#xe91d;',
		'bp-calendar': '&#xe91e;',
		'bp-Folder--open': '&#xe91a;',
		'bp-Folder': '&#xe90c;',
		'bp-chart-type': '&#xe90d;',
		'bp-data-grid': '&#xe90e;',
		'bp-formula': '&#xe90f;',
		'bp-location': '&#xe910;',
		'bp-edit': '&#xe911;',
		'bp-gridStrucutre--1': '&#xe912;',
		'bp-gridStrucutre--3': '&#xe913;',
		'bp-gridStrucutre--SPLIT2': '&#xe914;',
		'bp-file': '&#xe915;',
		'bp-filter--plus': '&#xe92a;',
		'bp-filter': '&#xe916;',
		'bp-print': '&#xe917;',
		'bp-link': '&#xe918;',
		'bp-share': '&#xe919;',
		'bp-config-gear': '&#xe90b;',
		'bp-consulta--new': '&#xe906;',
		'bp-consulta': '&#xe907;',
		'bp-painel': '&#xe908;',
		'bp-search': '&#xe909;',
		'bp-menu-dots': '&#xe90a;',
		'bp-arrow_left--circle': '&#xe904;',
		'bp-arrow_right--circle': '&#xe905;',
		'bp-notify': '&#xe901;',
		'bp-notify--badge': '&#xe902;',
		'bp-badge': '&#xe903;',
		'bp-exclamation-circle': '&#xe900;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/bp-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
