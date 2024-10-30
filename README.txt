=== Kartenlegen GPL ===
Plugin Version: 2.0.5
Contributors: Orakelsee
Donate link: https://orakelsee.com/
Tags: kartenlegen, future telling, cartomancy
Requires at least: 5.0.1
Tested up to: 5.6
Stable tag: 5.6
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== Description ==

Kartenlegen GPL is a free software as a service client. It is a client for everybody to use the automatic future 
telling stytem of the Orakelsee. Orakelsee is a sub-company of the Schamanenstube (schamanenstube.com) located in 
Switzerland.
It allows to select 3 cards, submit them to the Orakelsee system and receive answers in 3 sentences from the 
external system of orakelsee.com.

It allows to give your visitors the chance to use the algorithms of Orakelsee. Depending on the WordPress language
the answers are given in different languages. Per default, the answers are received in English. The system also reacts in
German and in Spanish.

Kartenlegen is a WordPress plugin, and will be fully supported and maintained until at least 2025, or as long as is necessary.



== Dependency on thrid party service ==

The plugin depends on the external system of the Orakelsee Wordpress REST service. It can only answer questions, 
if the external service is up. Otherwise it stops while showing "Asking the Orakelsee…"

Link to the service:
https://orakelsee.com/wp/wp-json/kartenlegen/v2/card/

Terms of use and privacy policies: 
https://orakelsee.com/wp/rest-api-service/



Data sent to the external system:

1. General:
The external system handles data sent to its WordPress REST API. The header of each communication consists of:
timeout, httpversion, useragent (your WordPress Version and your home-URL), blocking, headers (null), cookies (null), body (null),
compress, decompress, sslverify, stream, filename (null)

2. GetSpell - at the event of 3 selected cards

2.1. Answer request cards: This plugin sends to the Orakelsee-System a string of 6 letters indicating the selected cards. 
Every selected card consists of two letters. E.g. "h0e1b2": card heart0, spade1, hand2. With this information, the answer 
is built and returned to the plugin.

2.2. Answer request language: The language code of your WordPress installation is sent to the external system, e.g. "de_DE". This determines the
language of the result to receive. 

2.3. URL: the home URL of your WordPress installation. This is used to assure, only WordPress installations of the plugin can
communicate with the external server. The request is verified to the site registrations before creating answers.


3. RegisterSite - on plugin activation

3.1. URL: the home URL of your WordPress installation. It is stored in a database on the external system to verify each communication
origins at your site. This ensures a proper connection to the Orakelsee system.

3.2. Version: your installed WordPress Version at the time of plugin activation. This ensures you are using a WordPress version that
meets the requirments of the communication.


4. UnRegisterSite - on plugin deactivation and plugin uninstall event

4.1. URL: the home URL of your WordPress Installation to disable the communication.



Data received from the external system:

1. As result of a request after 3 selected cards 
The plugin receives a string of three sentences from the external system. This is the answer of the question done by selecting
three cards. The language of the string depends on the sent language-parameter. The default language is English. In case of any 
error, the plugin receives nothing and remains on waiting for the answer.

2. Registration
The plugin receives an answer-string of a successful or unsuccessful registration at the external service.



== Privacy Data ==

Cookies: 
Only one cookie is used for a 10 seconds lifetime. This is set on client side, so the Orakelsee system
doesn't have to log anything and will not get overloaded by too many requests. While the cookie exists, the cookie
content is shown instead of selecting new cards: the last answer from the system is stored in the cookie. 

External service: 
For debug reasons every generated answer of the service can be temporarly stored with timestamp on the external server. 
A counter for the generated answers is stored in the registration entry of each registered plugin. 
No other data are collected by the systems: nor to the WordPress installation, nor to the server.



== Installation ==

1. Upload `kartenlegengpl`-folder to the `/wp-content/plugins/` directory
2. Install and activate the plugin through the 'Kartenlegen GPL' menu in WordPress
3. Find the new Widget under Design-Widgets and add it to your sidebar with your own title


== Changelog ==

= 2.0.5 =
* Translation changes and bugfixing the settings for text-domain

= 2.0.3 =
* Translations did not work. Changed the text-domain to the Plugin Slug. From kartenlegengpl to kartenlegen-gpl.
* Changed the background of the cards to white

= 2.0.2 =
* README.txt: clearly documented third party service and privacy
* Renamed all function names
* All inputs, outputs and calls and answers to and from the remote system are sanitisized, escaped and validated

= 2.0.1 =
* 2020-03-19: Release for official WordPress

= 1.0 =
* 2019-07-16: Release on shop.schuschu.org

= 0.2 =
* Tested on Wordpress (shop.schuschu.org), buxfixes concerning the API access via AJAX
* Added user instructions

= 0.1 =
Initial release.


== Frequently Asked Questions ==

= Default settings =

The Plugin does not have settings. As it is used as a widget you can change the standard title.

