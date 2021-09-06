<?php

class UANM_Primary_Menu_Walker extends Walker_Nav_Menu {

	public function icons() {
		return [
			'twitter'    => $this->get_twitter_icon(),
			'letterboxd' => $this->get_letterboxd_icon(),
			'rss'        => $this->get_rss_icon(),
		];
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$object      = $item->object;
		$type        = $item->type;
		$title_orig  = $item->title;
		$permalink   = $item->url;

		$output .= '<li class="' . implode( " ", $item->classes ) . '">';
		$output .= '<a href="' . $permalink . '">';

		$title = strtolower( $item->title );
		$icons = $this->icons();

		if ( array_key_exists( $title, $icons ) ) {
			$output .= $icons[ $title ];
		} else {
			$output .= $title_orig;
		}

		$output .= '</a>';
		$g = '';
	}

	public function get_twitter_icon() {
		return '<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1408 610q-56 25-121 34 68-40 93-117-65 38-134 51-61-66-153-66-87 0-148.5 61.5t-61.5 148.5q0 29 5 48-129-7-242-65t-192-155q-29 50-29 106 0 114 91 175-47-1-100-26v2q0 75 50 133.5t123 72.5q-29 8-51 8-13 0-39-4 21 63 74.5 104t121.5 42q-116 90-261 90-26 0-50-3 148 94 322 94 112 0 210-35.5t168-95 120.5-137 75-162 24.5-168.5q0-18-1-27 63-45 105-109zm256-194v960q0 119-84.5 203.5t-203.5 84.5h-960q-119 0-203.5-84.5t-84.5-203.5v-960q0-119 84.5-203.5t203.5-84.5h960q119 0 203.5 84.5t84.5 203.5z"/></svg>';
	}

	public function get_letterboxd_icon() {
		return '<?xml version="1.0" encoding="UTF-8"?> <svg width="500px" height="500px" viewBox="0 0 500 500" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch --> <title>letterboxd-decal-dots-pos-rgb</title> <desc>Created with Sketch.</desc> <defs> <rect id="path-1" x="0" y="0" width="129.847328" height="141.389313"/> <rect id="path-3" x="0" y="0" width="129.847328" height="141.389313"/> </defs> <g id="letterboxd-decal-dots-pos-rgb" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <circle id="Circle" fill="#202830" cx="250" cy="250" r="250"/> <g id="dots-neg" transform="translate(61.000000, 180.000000)"> <g id="Dots"> <ellipse id="Green" fill="#00E054" cx="189" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> <g id="Blue" transform="translate(248.152672, 0.000000)"> <mask id="mask-2" fill="white"> <use xlink:href="#path-1"/> </mask> <g id="Mask"/> <ellipse fill="#40BCF4" mask="url(#mask-2)" cx="59.7686766" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> </g> <g id="Orange"> <mask id="mask-4" fill="white"> <use xlink:href="#path-3"/> </mask> <g id="Mask"/> <ellipse fill="#FF8000" mask="url(#mask-4)" cx="70.0786517" cy="69.9732824" rx="70.0786517" ry="69.9732824"/> </g> <path d="M129.539326,107.022244 C122.810493,96.2781677 118.921348,83.5792213 118.921348,69.9732824 C118.921348,56.3673435 122.810493,43.6683972 129.539326,32.9243209 C136.268159,43.6683972 140.157303,56.3673435 140.157303,69.9732824 C140.157303,83.5792213 136.268159,96.2781677 129.539326,107.022244 Z" id="Overlap" fill="#FFFFFF"/> <path d="M248.460674,32.9243209 C255.189507,43.6683972 259.078652,56.3673435 259.078652,69.9732824 C259.078652,83.5792213 255.189507,96.2781677 248.460674,107.022244 C241.731841,96.2781677 237.842697,83.5792213 237.842697,69.9732824 C237.842697,56.3673435 241.731841,43.6683972 248.460674,32.9243209 Z" id="Overlap" fill="#FFFFFF"/> </g> </g> </g></svg>';
	}

	public function get_rss_icon() {
		return '<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M640 1280q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm351 94q-13-232-177-396t-396-177q-14-1-24 9t-10 23v128q0 13 8.5 22t21.5 10q154 11 264 121t121 264q1 13 10 21.5t22 8.5h128q13 0 23-10t9-24zm384 1q-5-154-56-297.5t-139.5-260-205-205-260-139.5-297.5-56q-14-1-23 9-10 10-10 23v128q0 13 9 22t22 10q204 7 378 111.5t278.5 278.5 111.5 378q1 13 10 22t22 9h128q13 0 23-10 11-9 9-23zm289-959v960q0 119-84.5 203.5t-203.5 84.5h-960q-119 0-203.5-84.5t-84.5-203.5v-960q0-119 84.5-203.5t203.5-84.5h960q119 0 203.5 84.5t84.5 203.5z"/></svg>';
	}
}
