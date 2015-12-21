<?php

/**
 * @file
 * Definition of hungarian strings for Admin UI.
 */

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_01', 'Settings');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_02', 'Web Property ID');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_03', 'Domains');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_04', 'User Classes');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_05', 'Links and Downloads');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_06', 'Advertising');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_07', 'Privacy');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_08', 'Save settings');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_09', 'Web Property ID');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_10', 'This ID is unique to each site you want to track separately, and is in the form of UA-xxxxxxx-yy. To get a Web Property ID, [link=http://www.google.com/analytics/]register your site with Google Analytics[/link], or if you already have registered your site, go to your Google Analytics Settings page to see the ID next to every site profile. [link=https://developers.google.com/analytics/resources/concepts/gaConceptsAccounts#webProperty]Find more information in the documentation[/link].');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_11', 'What are you tracking?');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_12', 'A single domain (default)');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_13', '[b]A single domain:[/b] example.com');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_14', 'One domain with multiple subdomains');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_15', '[b]One domain with multiple subdomains:[/b] www.example.com, app.example.com, shop.example.com');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_16', 'Multiple top-level domains');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_17', '[b]Multiple top-level domains:[/b] www.example.com, www.example.net, www.example.org');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_18', 'List of top-level domains');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_19', 'If you selected "Multiple top-level domains" above, enter all related top-level domains. Add one domain per line. By default, the data in your reports only includes the path and name of the page, and not the domain name. For more information see section Show separate domain names in [link=https://support.google.com/analytics/answer/1034342]Tracking Multiple Domains[/link].');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_20', 'Pages');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_21', 'Every page except the listed pages');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_22', 'The listed pages only');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_23', 'Enter one page per line. The "*" character is a wildcard. FRONTPAGE is the front page.');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_24', 'Add tracking to specific pages');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_25', 'Add tracking for specific class');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_26', 'Users');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_27', 'Track User ID');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_28', 'User ID enables the analysis of groups of sessions, across devices, using a unique, persistent, and non-personally identifiable ID string representing a user. [link=https://support.google.com/analytics/answer/3123663]Learn more about the benefits of using User ID[/link].');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_29', 'Track clicks on outbound links');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_30', 'Track clicks on mailto links');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_31', 'Track downloads (clicks on file links) for the following extensions');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_32', 'A file extension list separated by the | character that will be tracked as download when clicked. Regular expressions are supported. For example: 7z|aac|arc|arj|asf|asx|avi|bin|csv|doc(x|m)?|dot(x|m)?|exe|flv|gif|gz|gzip|hqx|jar|jpe?g|js|mp(2|3|4|e?g)|mov(ie)?|msi|msp|pdf|phps|png|ppt(x|m)?|pot(x|m)?|pps(x|m)?|ppam|sld(x|m)?|thmx|qtm?|ra(m|r)?|sea|sit|tar|tgz|torrent|txt|wav|wma|wmv|wpd|xls(x|m|b)?|xlt(x|m)|xlam|xml|z|zip');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_33', 'Track enhanced link attribution');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_34', 'Enhanced Link Attribution improves the accuracy of your In-Page Analytics report by automatically differentiating between multiple links to the same URL on a single page by using link element IDs. [link=https://support.google.com/analytics/answer/2558867]Enable enhanced link attribution[/link] in the Admin UI of your Google Analytics account.');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_35', 'Track changing URL fragments as pageviews');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_36', 'By default, the URL reported to Google Analytics will not include the "fragment identifier" (i.e. the portion of the URL beginning with a hash sign), and hash changes by themselves will not cause new pageviews to be reported. Checking this box will cause hash changes to be reported as pageviews (in modern browsers) and all pageview URLs to include the fragment where applicable.');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_37', 'Track AdSense ads');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_38', 'If checked, your AdSense ads will be tracked in your Google Analytics account.');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_39', 'Track display features');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_40', 'The display features plugin can be used to enable Display Advertising Features in Google Analytics, such as Remarketing, Demographics and Interest Reporting, and more. [link=https://support.google.com/analytics/answer/3450482]Learn more about Display Advertising Features in Google Analytics[/link]. If you choose this option you will need to [link=https://support.google.com/analytics/answer/2700409]update your privacy policy[/link].');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_41', 'Anonymize visitors IP address');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_42', 'Tell Google Analytics to anonymize the information sent by the tracker objects by removing the last octet of the IP address prior to its storage. Note that this will slightly reduce the accuracy of geographic reporting. In some countries it is not allowed to collect personally identifying information for privacy reasons and this setting may help you to comply with the local laws.');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_43', 'Universal web tracking opt-out');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_44', 'If enabled and your server receives the [link=http://donottrack.us/]Do-Not-Track[/link] header from the client browser, the Google Analytics module will not embed any tracking code into your site. Compliance with Do Not Track could be purely voluntary, enforced by industry self-regulation, or mandated by state or federal law. Please accept your visitors privacy. If they have opt-out from tracking and advertising, you should accept their personal decision. This feature is currently limited to logged in users and disabled page caching.');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_45', 'Advanced settings');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_46', 'Locally cache tracking code file');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_47', 'If checked, the tracking code file is retrieved from Google Analytics and cached locally. It is updated daily from Google\'s servers to ensure updates to tracking code are reflected in the local copy. Do not activate this until after Google Analytics has confirmed that site tracking is working!');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_48', 'Enable debugging');
define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_49', 'If checked, the Google Universal Analytics debugging script will be loaded. You should not enable your production site to use this version of the JavaScript. The analytics_debug.js script is larger than the analytics.js tracking code and it is not typically cached. Using it in your production site will slow down your site for all of your users. Again, this is only for your own testing purposes. Debug messages are printed to the window.console object.');

define('LAN_PLUGIN_GOOGLE_ANALYTICS_ADMIN_50', 'Settings have been saved successfully!');
