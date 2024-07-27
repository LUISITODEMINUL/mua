
function getFlashMovieObject(movieName)
{if(window.document[movieName])
{return window.document[movieName];}
if(navigator.appName.indexOf("Microsoft Internet")==-1)
{if(document.embeds&&document.embeds[movieName])
return document.embeds[movieName];}
else
{return document.getElementById(movieName);}}
function fingerprint_userlang()
{var lang;(typeof(navigator.userLanguage)!="undefined")?lang=navigator.userLanguage:((typeof(navigator.language)!="undefined")?lang=navigator.language:lang="");return lang;}