gw2leaderboard
==============

Guild Wars 2 PHP Custom Leaderboards

Welcome to my personal project, with this leaderboard you can filter Players by guild, server, or anything you want, you can also rank these players by your filter.
Fell free to fork or help-me with this project. It's from community for community.

An live production example can be accessed here:

Guild Wars 2 Brazil Community Leaderboard http://guildwars2brasil.com.br/leaderboards

This software needs to be hosted in a server with Mysql And PHP 5.4+ server.

Installation Instructions:

1- Place all files on you server and configure "Config.php" file.
2- Import to your mysql server the SQL files.
3- Setup an cronjob (if you want), because we need keep the data upgraded:

wget -q "http://APPURL/update.php" -O /dev/null

4- Access your URL (index.php) and let the players sign-up!

FAQ

1- Why the load is so slow?
For each registered player the server needs look for this player on all 40 ANet pages, because we still don't have an API.
After the first update, the database records last page where the player has been found, so the next time will be faster.

2- Why just not search all pages every X hours instead of this hard coded search algorithm?
After some research, I decided this way is faster, because we not have so much players to search, plus the ANet server have an DDOS protection, and you will get an 500 error if get all pages in a little time.

3- There is a way to debug?
Yep! Just put the debug param at end of your URL, like this "?debug=true"

4- Translate?
I am not using any system to translate the app, for while you can manually change the strings directly in the code, files: index.php, Leaderboard.php, newplayer.php

Any other question? Fell free to mail me: walker at praiseweb.com.br
