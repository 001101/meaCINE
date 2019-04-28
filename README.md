# Installation

Before proceeding with the installation you will need:

* a WEB server with PHP (local or distant) where you can install meaCINE.
* at least one premium subscription to Uptobox or 1fichier services (but ideally both).

To start, download the meaCINE archive and unpack it on your hard drive. Edit the **meacine/config.php** file to indicate Uptobox and/or 1fichier API keys values that are normally available with your premium account. Indicate for example:
```
$uptobox_api_key = "d41d8cd98f00b204e9800998ecf8427e99109";
$fichier_api_key = "MM2NmQ5OTEwOTI2NmZmY2QyNzQxOWVhN";
```
You will find your API key corresponding to your Uptobox premium account [here](https://uptobox.com/?op=my_account) (it's the Token), and the one corresponding to your 1fichier premium account [here](https://1fichier.com/console/params.pl) (you will have to activate it). Save the file **meacine/config.php** after modification and transfer the **meacine** directory and its contents to your WEB server.

meaCINE also has a function to check, at regular intervals, whether the Uptobox and 1fichiers sources are still active or not. For this you need to define a cron job and point it to the **cron_check_sources.php** file. For example, to run every half hour, the cron job command will be:
```
/usr/bin/php -q /home/mywebsite/public_html/meacine/cron_check_sources.php >/dev/null 2>&1
```
where /home/mywebsite/public_html/meacine/ is the path where meaCINE is hosted.

# Kodi configuration

For the rest of this tutorial, we will keep as example that meaCINE is installed at this URL **http://www.mysite.com/meacine**.

Start Kodi. Go to the menu System > Media Settings > Media Library > Source Management > Videos... > Add Video Source... Enter the path **http://www.mysite.com/meacine/kodi** and specify a source name (for example meaCINE). Click OK. In the New Content > Folder Category window, choose the Movies option. Then choose the settings according to your preferences, but keep the content options by default. Click OK. Finally, confirm the update of the information of all the elements of this path.

# meaCINE use

To use the meaCINE WEB interface, with a browser, go to **http://www.mysite.com/meacine**. The site offers by default to add a movie. For example, enter *Bohemian Rhapsody* as the title, *2018* as the release year, and *https://1fichier.com/?xomgy2dil1j94tk4dhl9* as the video source, and click the add button. The movie was added to meaCINE and linked to the video source hosted on 1fichier. You can add as many movies as you want.

To update your movie list into Kodi, go to the menu System > Media Settings > Media Library > Source Management > Videos... > Options> Update Media Library. You can now watch video sources of movies directly in Kodi.

meaCINE interface allows you to manage your movie list. To edit and delete a movie, simply click on its title. The interface has a search engine to quickly find a movie or video source. Finally, you can view movies by title or by year. meaCINE is also coupled to [TMDB] (https://www.themoviedb.org) services to more easily manage your movies list. 
