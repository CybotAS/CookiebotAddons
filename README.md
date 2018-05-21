# Cookiebot Wordpress Addons


Cookiebot Addons are plugins for Wordpress that make other plugins compatible with Cookiebot. 
The addons hook into the original plugin and render the cookie setting tags as advised by the Cookiebot guidelines at https://www.cookiebot.com/goto/help/.

Concurrently we are working with WP Core on what we believe is the real solution. A framework in WP Core that can signal the consent state to other plugins,
so that they can handle their cookie setting code without explicit support for Cookiebot, or other cookie plugins. If and when this will be implemented is unknown.

https://core.trac.wordpress.org/ticket/44043 

# News on GADWP
GADWP is about to release a GDPR compliance addon, which supports Cookiebot. We'll provide a link here once the addon is released. 

# Installation
1. Copy the framework plugin to your WP plugins folder
2. Go to the admin page of your WP installation and activate the plugin
3. You are done, verify that it works

# Roadmap

Following plugins are in pipeline:
* MonsterInsights (https://www.monsterinsights.com/addon/eu-compliance/) (MonsterInsights released Cookiebot support)
* ~~GADWP (discontinued)~~
* GA Google Analytics (https://wordpress.org/plugins/ga-google-analytics/) (released and tested)
* Google Analyticator (https://wordpress.org/plugins/google-analyticator/) (released and tested)
* Jetpack by Wordpress.com (https://wordpress.org/plugins/jetpack/) (in development)
* HubSpot Tracking Code (https://wordpress.org/plugins/hubspot-tracking-code/) (released and tested)
* To be continued..

If you have a plugin that you would like integration for, please submit a request in the [Issues](https://github.com/CybotAS/CookiebotAddons/issues) section.

# Contributions
Everyone is welcome to make a pull request with new addon support, or to fix existing addons.
Shout out to @fschaeffler for the HubSpot Tracking Code integration. Way to go!


# How do I make my plugin support Cookiebot?
If you favourite plugins doesn’t support Cookiebot you are always welcome to ask the author to add support for Cookiebot.
Cookiebot provides a helper function to check if there is an active, working version of Cookiebot on the website.
The easiest way for at developer to implement Cookiebot support is to add a check for Cookiebot where tags are outputted to the visitor. 

This can be done following way:

```php
$scriptTag = ";
if(function_exists('cookiebot_active') && cookiebot_active()) {
$scriptTag = '<script'.cookiebot_assist('statistics').'>';
}
```

A users consent state can be be aquired through Cookiebots JS API.

The following properties are available on the Cookiebot object:

| Name                | Type | Default | Description                                                                                                                                                                                                            |
|---------------------|:----:|:-------:|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| consent.necessary   | bool | true    | True if current user has accepted necessary cookies. <br> The property is read only.                                                                                                                                        |
| consent.preferences | bool | false   | True if current user has accepted preference cookies. <br> The property is read only.                                                                                                                                       |
| consent.statistics  | bool | false   | True if current user has accepted statistics cookies. <br> The property is read only.                                                                                                                                       |
| consent.marketing   | bool | false   | True if current user has accepted marketing cookies. <br> The property is read only.                                                                                                                                        |
| consented           | bool | false   | True if the user has accepted cookies. <br> The property is read only.                                                                                                                                                      |
| declined            | bool | false   | True if the user has declined the use of cookies. <br> The property is read only.                                                                                                                                           |
| hasResponse         | bool | false   | True if the user has responded to the dialog with either 'accept' or 'decline'.                                                                                                                                        |
| doNotTrack          | bool | false   | True if the user has enabled the web browser's 'Do not track' (DNT) setting. <br> If DNT is enabled Cookiebot will not set the third party cookie CookieConsentBulkTicket used for bulk consent. <br> The property is read only. |

Callbacks

| Name                			| Description                                                                                                                                                                                                            |
|-------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| CookiebotCallback_OnLoad   	| The asynchronous callback is triggered when the cookie banner has loaded to get the user's consent.                                                                                                                                        |
| CookiebotCallback_OnAccept	| The asynchronous callback is triggered when the user clicks the accept-button of the cookie consent dialog and whenever a consented user loads a page.                                                                                     |                                                 |
| CookiebotCallback_OnDecline	| The asynchronous callback is triggered when the user declines the use of cookies by clicking the decline-button in the cookie consent dialog. The callback is also triggered whenever a user that has declined the use of cookies loads a page. |                                                                                                                                      |


And through PHP:

```php
if (isset($_COOKIE["CookieConsent"]))
{
    switch ($_COOKIE["CookieConsent"])
    {
        case "0":
            //The user has not accepted cookies - set strictly necessary cookies only
            break;

        case "-1":
            //The user is not within a region that requires consent - all cookies are accepted
            break;

        default: //The user has accepted one or more type of cookies
            
            //Read current user consent in encoded JavaScript format
            $valid_php_json = preg_replace('/\s*:\s*([a-zA-Z0-9_]+?)([}\[,])/', ':"$1"$2', preg_replace('/([{\[,])\s*([a-zA-Z0-9_]+?):/', '$1"$2":', str_replace("'", '"',stripslashes($_COOKIE["CookieConsent"]))));
            $CookieConsent = json_decode($valid_php_json);

            if (filter_var($CookieConsent->preferences, FILTER_VALIDATE_BOOLEAN))
            {
                //Current user accepts preference cookies
            }
            else
            {
                //Current user does NOT accept preference cookies
            }

            if (filter_var($CookieConsent->statistics, FILTER_VALIDATE_BOOLEAN))
            {
                //Current user accepts statistics cookies
            }
            else
            {
                //Current user does NOT accept statistics cookies
            }

            if (filter_var($CookieConsent->marketing, FILTER_VALIDATE_BOOLEAN))
            {
                //Current user accepts marketing cookies
            }
            else
            {
                //Current user does NOT accept marketing cookies
            }   
    }
}
else
{
    //The user has not accepted cookies - set strictly necessary cookies only
}
```
More details are available at https://www.cookiebot.com/goto/developer/

# Need to get in touch?

There are several ways you can get in touch with us. <br>
We are available on the Making Wordpress Slack workspace. <br>
Username: Kenan <br>
You can also reach us through our helpdesk at www.cookiebot.com/goto/helpdesk/