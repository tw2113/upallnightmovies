# Cord
Location: https://theseoframework.com/extensions/cord/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This extension helps you connect your website to third-party services, like Google Analytics and Facebook pixel.

## Overview

### Quick and easy

Manage third-party services for your WordPress website with ease. Activate the extension, fill in the connection keys, and you're done. Cord takes care of the rest.

Cord supports the Google Analytics and Facebook pixel services. For these, you require a "Google Analytics" and "Facebook for Business" accounts, respectively.

### Sensical Google Analytics

Cord provides only the critical scripts to set up the Google Analytics connection. No data is stored or processed on your website. Google Analytics already provides the interface via their website.

Moreover, Cord automatically fixes the search query URLs in WordPress before relaying them, so that Google Analytics knows how to sort these&mdash;without losing any data.

### Simplified Facebook pixel

Cord provides exactly one field for Facebook pixel tracking. When you've filled that in, you can start tracking visitors right away for remarketing.

## Usage

[tsfep-bundled]

### Activate Cord

First, you'll need to activate the Cord extension.

### Extension settings

Underneath the extension description, you should see a settings-link appear. You can also find the link to "Extension Settings" under "SEO" in the admin sidebar, but you may need to refresh the page first.

On the Extension Settings page, you can set up the required connection information for Google Analytics and Facebook pixel.

### Enabling Google Analytics

To get started with Google Analytics, follow these steps:

1. Go to [Google Analytics](https://www.google.com/analytics/). Sign up with Google or log into your existing account.
2. Set up a property. The property will represent your website.
3. You will now see your Tracking ID at the top of the page. It should start with `UA-`.

[tsfep-image id="1"]

4. Copy that ID and paste it in Cord's corresponding field on the Extension Settings page. Don't forget to hit save.

[tsfep-image id="2"]

When fully set up, Google Analytics will start tracking visitors and provide you event, performance, and other insights.

### Enabling Facebook pixel

To get started with Facebook pixel, you first need a Facebook for Business account.

1. Go to Facebook's [Event Manager](https://www.facebook.com/ads/manager/pixel/facebook_pixel). Sign up with Facebook or log into your existing account tied to the business.
2. Select "Get Started" with Facebook pixel.
3. Provide the pixel name. The other fields are optional.
4. Close or cancel the installation dialog--Cord isn't listed there.
5. At the top of the page, you should see your pixel ID.

[tsfep-image id="3"]

6. Click on the ID to copy it, and paste it in Cord's corresponding field on the Extension Settings page. Don't forget to hit save.

[tsfep-image id="4"]

When fully set up, Facebook pixel will start tracking visitors and provide you with various insights for advertising.

### Privacy

Your website and visitors may be subject to General Data Protection Regulation (GDPR), California Consumer Privacy Act (CCPA), or other legislations. Under these regulations, you may be required to inform your visitors about cookies, data collection, and data processing. You may also be required to anonymize the IP address.

## FAQ

### Where does Cord output the analytical scripts?

Cord outputs the scripts on every non-administrative WordPress page of your website.

The login, server-error, REST, feed, and WordPress-admin pages aren't tracked.

### Where can I view the analytical data?

You can find live and aggregated data visualized on the provider's website. Follow the links below to view your dashboard. Make sure you're logged into the right account.

- [Visit Google Analytics dashboard](https://analytics.google.com/analytics/web/).
- [Visit Facebook pixel analytics dashboard](https://www.facebook.com/analytics/).

### Why can't I just view this data in my WordPress dashboard?

The analytics providers have created a dashboard that works perfectly well. We can't just take that as-is, and we see no use in recreating something else from scratch. Cord is an elegant and simple solution without any bulk. There are other solutions out there that visualize the data into your dashboard, might you fancy that.

### Does Cord track everyone?

Cord outputs the tracking script for all users--including logged-in users. However, there are browser extensions and services, like uBlock Origin and Pi-hole, which can halt the scripts. They make these visitors invisible for these tracking services.

### Can we bypass that?

Yes. But we won't tell you how. Privacy is sacred.

### Why isn't gtag used instead of Google Analytics?

The global site tag (gtag) is a solution that requires an on-site developer to tailor. Although extremely powerful, the overhead required is enormous. We can't predict which actions you'd want to record. On the other hand, Google Analytics does almost everything you require for analytics out of the box--even page speed insights. And, through advanced settings in your Google Analytics dashboard, you can achieve roughly the same results.

### What's Enhanced Link Attribution for Google Analytics?

Some pages have multiple links that lead to the same page. When Enhanced Link Attribution is enabled, Google Analytics tries to find the nearest HTML element ID of each link that's clicked. This way, Google Analytics can approximate which link is clicked, without requiring advanced tagging.

To inspect these findings, you require the [Page Analytics Chromium browser extension](https://chrome.google.com/webstore/detail/page-analytics-by-google/fnbdnhhicmebfgdgglcdacdapkcihcoh). Please note that this extension is no longer maintained. We are yet unaware of alternative solutions.

### Why would I choose this extension over Facebook's official plugin?

[Facebook's official pixel plugin](https://wordpress.org/plugins/official-facebook-pixel/) provides advanced integration for some other plugins that can help you with advertisement campaigns. If you see no use in that, and you just want a simple integration, then this extension provides a lightweight alternative--as is such with all our solutions.

### What about cookie consent?

There is no cookie-consent control in the Cord extension. However, there are ways to implement these [via filters](#developers/filters).

The extension does not create cookies itself. However, the third-party scripts Cord integrates, do. These cookies are:

| Option           | Cookie name | Purpose     | Privacy                                                            | Expiry     |
|:---------------- |:----------- |:----------- |:------------------------------------------------------------------ |:---------- |
| Google Analytics | `_ga`       | Analytics   | [View policy](https://support.google.com/analytics/answer/6004245) | 2 years    |
| Google Link ID   | `_gali`     | Analytics   | [View policy](https://support.google.com/analytics/answer/6004245) | 30 seconds |
| Facebook pixel   | `_fbp`      | Remarketing | [View policy](https://www.facebook.com/about/privacy)              | Session    |

Whether this information is useful to you depends on the laws you must (or should) follow. We're not lawyers, so we're not going to provide you a most annoying cookie consent banner. Integrate it yourself, and please make it small enough for us to ignore easily. Thank you.

## Developers

### Filters

Here you can find the available filters for Cord.

#### Disable scripts until cookie consent is granted

N.B. This does not work with page-caching plugins. When a page-caching plugin is used, this script may lead to sporadic disabling or enabling tracking for all visitors. Some caching plugins can provide different pages based on the cookies provided, however.

```php
add_action( 'init', function() {

	// This is an arbitrary example cookie.
	$consented = ! empty( $_COOKIE['_example_cookie_consent'] );

	if ( ! $consented ) {
		// No Cookie consent has been given. Disable tracking.
		add_filter( 'the_seo_framework_cord_ga_enabled', '__return_false' );
		add_filter( 'the_seo_framework_cord_fbp_enabled', '__return_false' );
	}
}, 9 );
```

#### Specify Enhanced Link Attribution element levels

Specify the maximum number of levels in the DOM to look to find an existing ID. When no element ID is found after bubbling up to the set levels, the link will be measured globally. Setting this value too high may impact browser performance when a link is clicked.

```php
add_filter( 'the_seo_framework_cord_ga_ela_id_levels', function( $levels = 5 ) {
	return 3;
} );
```

## Changelog

### 1.0.0

[tsfep-release time="December 18th, 2019"]

* Initial extension release.
