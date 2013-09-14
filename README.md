gw2leaderboard
==============

Guild Wars 2 PHP Custom Leaderboards

Welcome to my personal project, with this leaderboard you can filter Players by guild, server, or anything you want, you can also rank these players by your filter.
Fell free to fork or help-me with this project. It's from community for community.

An live production example can be accessed here:

Guild Wars 2 Brasil solo leaderboard http://guildwars2brasil.com.br/?page_id=4940
Guild Wars 2 Brasil team leaderboard: http://guildwars2brasil.com.br/?page_id=5022

This software needs to be hosted in a server with Mysql And PHP 5.3+ server.

Installation Instructions:

1- Place all files on you server
2- Import to your mysql server the SQL files.
3- Setup an cronjob (if you want) for both leaderboards, solo and team, because we need keep the data upgraded:

wget "http://mysite/leaderboard/?leaderboard=soloarena" -O /dev/null >/dev/null 2>&1; wget "http://mysite/leaderboard/?leaderboard=teamarena" -O /dev/null >/dev/null 2>&1

4- Access your URL and let the players sign-up!
