NitroXy - INFO
===================================================

Vad du behöver göra innan montering:

	* Fixa en burk med linux på (helst debian)
	* Installera valfri webbserver (apache?), samt mysql med lite andra saker

Monteringsguide:

	* Kopiera till lämplig mapp (ja, du måste vara åtminstone _lite_ kompetent för att göra detta)
	* Skapa en ny databas med namn "nfo"
	* Konfiguera databasinställningarna i "config.php" rätt
	* Gå in i mappen 'migrations' och kör "php update_migrations.php" för att få en fin databas
	* Skriv content ....
