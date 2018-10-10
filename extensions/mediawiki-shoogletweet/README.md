#shoogle tweet

mediawiki-shoogletweet is a mediawiki extension which useses OAuth2 for authentication. it displays the current tweets of a given screen name.

## Retrieving oAuth2 access

To use this extension you have to create an oAuth2 application on the [twitter "my application" page](https://dev.twitter.com/apps). If you've created the application, you'll retrieve a "Consumer Key" and "Consumer Key Secret" which is needed later.

## Installing the extension

- Navigate to your mediawiki extension directory ($IP/extensions)
- git clone https://github.com/schinken/mediawiki-shoogletweet
- change inside that directory (mediawiki-shoogletweet)
- git submodule init
- git submodule update
- Enable the extension by adding the follwing lines to your LocalSettings.php-File inside your mediawiki directory

```PHP
require_once("$IP/extensions/mediawiki-shoogletweet/ShoogleTweet.php");
$wgShoogleTweetConsumerKey = '#YOUR_CONSUMER_KEY#';
$wgShoogleTweetConsumerKeySecret = '#YOUR_CONSUMER_KEY_SECRET#';
```

## Usage

Just add
```HTML
<ShoogleTweet limit="6">b4ckspace</ShoogleTweet>
```

to you wikipage

You can also enable ShoogleTweet to display @-replies:
```HTML
<ShoogleTweet limit="6" display_replies="true">b4ckspace</ShoogleTweet>
```

## Style

The HTML result can be simply styled with this piece of css

```CSS
#tw-list {
    margin:0;
    padding: 0;
}
#tw-list li{
    list-style:none;
    margin-bottom: 2px;
    padding: 4px;
}
#tw-list li.even{
    background-color:#f8f8f8;
}
```

## Misc

page(s) using this extension:

* http://hackerspace-bamberg.de
