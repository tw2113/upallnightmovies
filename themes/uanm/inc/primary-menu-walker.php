<?php

class UANM_Primary_Menu_Walker extends Walker_Nav_Menu {

	public function icons() {
		return [
			'twitter'    => $this->get_twitter_icon(),
			'letterboxd' => $this->get_letterboxd_icon(),
			'rss'        => $this->get_rss_icon(),
			'email'      => $this->get_email_icon(),
		];
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$object      = $item->object;
		$type        = $item->type;
		$title_orig  = $item->title;
		$permalink   = $item->url;

		$title = strtolower( $item->title );
		$icons = $this->icons();

		$output .= '<li class="' . implode( " ", $item->classes ) . '">';
		$output .= '<a href="' . $permalink . '">';

		if ( array_key_exists( $title, $icons ) ) {
			$output .= $icons[ $title ];
		} else {
			$output .= $title_orig;
		}

		$output .= '</a>';
		$g = '';
	}

	public function get_twitter_icon() {
		return '<span class="social-icon-text">twitter</span><svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1408 610q-56 25-121 34 68-40 93-117-65 38-134 51-61-66-153-66-87 0-148.5 61.5t-61.5 148.5q0 29 5 48-129-7-242-65t-192-155q-29 50-29 106 0 114 91 175-47-1-100-26v2q0 75 50 133.5t123 72.5q-29 8-51 8-13 0-39-4 21 63 74.5 104t121.5 42q-116 90-261 90-26 0-50-3 148 94 322 94 112 0 210-35.5t168-95 120.5-137 75-162 24.5-168.5q0-18-1-27 63-45 105-109zm256-194v960q0 119-84.5 203.5t-203.5 84.5h-960q-119 0-203.5-84.5t-84.5-203.5v-960q0-119 84.5-203.5t203.5-84.5h960q119 0 203.5 84.5t84.5 203.5z"/></svg>';
	}

	public function get_letterboxd_icon() {
		return '<?xml version="1.0" encoding="UTF-8"?> <svg width="500px" height="500px" viewBox="0 0 500 500" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch --> <title>letterboxd-decal-dots-pos-rgb</title> <desc>Created with Sketch.</desc> <defs> <rect id="path-1" x="0" y="0" width="129.847328" height="141.389313"/> <rect id="path-3" x="0" y="0" width="129.847328" height="141.389313"/> </defs> <g id="letterboxd-decal-dots-pos-rgb" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <circle id="Circle" fill="#202830" cx="250" cy="250" r="250"/> <g id="dots-neg" transform="translate(61.000000, 180.000000)"> <g id="Dots"> <ellipse id="Green" fill="#00E054" cx="189" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> <g id="Blue" transform="translate(248.152672, 0.000000)"> <mask id="mask-2" fill="white"> <use xlink:href="#path-1"/> </mask> <g id="Mask"/> <ellipse fill="#40BCF4" mask="url(#mask-2)" cx="59.7686766" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> </g> <g id="Orange"> <mask id="mask-4" fill="white"> <use xlink:href="#path-3"/> </mask> <g id="Mask"/> <ellipse fill="#FF8000" mask="url(#mask-4)" cx="70.0786517" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> </g> <path d="M129.539326,107.022244 C122.810493,96.2781677 118.921348,83.5792213 118.921348,69.9732824 C118.921348,56.3673435 122.810493,43.6683972 129.539326,32.9243209 C136.268159,43.6683972 140.157303,56.3673435 140.157303,69.9732824 C140.157303,83.5792213 136.268159,96.2781677 129.539326,107.022244 Z" id="Overlap" fill="#FFFFFF"/> <path d="M248.460674,32.9243209 C255.189507,43.6683972 259.078652,56.3673435 259.078652,69.9732824 C259.078652,83.5792213 255.189507,96.2781677 248.460674,107.022244 C241.731841,96.2781677 237.842697,83.5792213 237.842697,69.9732824 C237.842697,56.3673435 241.731841,43.6683972 248.460674,32.9243209 Z" id="Overlap" fill="#FFFFFF"/> </g> </g> </g></svg>';
	}

	public function get_rss_icon() {
		return '<span class="social-icon-text">feed</span><svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M640 1280q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm351 94q-13-232-177-396t-396-177q-14-1-24 9t-10 23v128q0 13 8.5 22t21.5 10q154 11 264 121t121 264q1 13 10 21.5t22 8.5h128q13 0 23-10t9-24zm384 1q-5-154-56-297.5t-139.5-260-205-205-260-139.5-297.5-56q-14-1-23 9-10 10-10 23v128q0 13 9 22t22 10q204 7 378 111.5t278.5 278.5 111.5 378q1 13 10 22t22 9h128q13 0 23-10 11-9 9-23zm289-959v960q0 119-84.5 203.5t-203.5 84.5h-960q-119 0-203.5-84.5t-84.5-203.5v-960q0-119 84.5-203.5t203.5-84.5h960q119 0 203.5 84.5t84.5 203.5z"/></svg>';
	}

	public function get_email_icon() {
		return '<span class="social-icon-text">Email</span><?xml version="1.0" encoding="UTF-8" standalone="no"?><!-- Created with Inkscape (http://www.inkscape.org/) --><svg height="84"id="svg1468"inkscape:version="1.1 (c68e22c387, 2021-05-23)"sodipodi:docname="Envelope_clip_art.svg"sodipodi:version="0.32"version="1.0"width="131"x="0.00000000"y="0.00000000"xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"xmlns="http://www.w3.org/2000/svg"xmlns:svg="http://www.w3.org/2000/svg"xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"xmlns:cc="http://creativecommons.org/ns#"xmlns:dc="http://purl.org/dc/elements/1.1/"><metadata id="metadata2"><rdf:RDF><cc:Work rdf:about=""><dc:title>envelope</dc:title><dc:description /><dc:subject><rdf:Bag><rdf:li>envelope mail symbol</rdf:li></rdf:Bag></dc:subject><dc:publisher><cc:Agent rdf:about="http://www.openclipart.org/"><dc:title>Jarno Vasamaa</dc:title></cc:Agent></dc:publisher><dc:creator><cc:Agent><dc:title>Jarno Vasamaa</dc:title></cc:Agent></dc:creator><dc:rights><cc:Agent><dc:title>Jarno Vasamaa</dc:title></cc:Agent></dc:rights><dc:date /><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /><cc:license rdf:resource="http://web.resource.org/cc/PublicDomain" /><dc:language>en</dc:language></cc:Work><cc:License rdf:about="http://web.resource.org/cc/PublicDomain"><cc:permits rdf:resource="http://web.resource.org/cc/Reproduction" /><cc:permits rdf:resource="http://web.resource.org/cc/Distribution" /><cc:permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" /></cc:License></rdf:RDF></metadata><sodipodi:namedview bordercolor="#666666"borderopacity="1.0"id="base"inkscape:current-layer="svg1468"inkscape:cx="37.745275"inkscape:cy="50.554142"inkscape:pageopacity="0.0"inkscape:pageshadow="2"inkscape:window-height="854"inkscape:window-width="1631"inkscape:zoom="3.6693334"pagecolor="#ffffff"inkscape:pagecheckerboard="0"showgrid="false"width="144.5px"inkscape:window-x="0"inkscape:window-y="0"inkscape:window-maximized="0" /><defs id="defs1470" /><g id="layer1"transform="translate(-28.715539,-49.505694)"><g id="g2423"transform="matrix(0.810875,0,0,0.810875,5.90968,-403.3576)"><rect height="100"id="rect2398"rx="3"ry="3"style="opacity:1;fill:#ffffff;fill-opacity:1;stroke:#000000;stroke-width:3.75;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1"width="158"x="30"y="560.36218" /><path d="m 32,658.36218 76,-56 80,58"id="path2400"style="fill:none;fill-opacity:0.75;fill-rule:evenodd;stroke:#000000;stroke-width:3.75;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" /><path d="M 31.935135,561.05047 107.7045,621.01804 186,560.39461 Z"id="path2402"style="fill:#ffffff;fill-opacity:1;fill-rule:evenodd;stroke:#000000;stroke-width:3.75;stroke-linecap:butt;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" /></g></g></svg>';
	}
}
