function questions(numero)
{
	var chaine="";
	switch(numero)
	{
		case 1:
		chaine="Quel est le doctype d'un document  --------HTML5?.*DOCTYPE html5*<!DOCTYPE html>*<!DOCTYPE html PUBLIC>*mm*2";		break;
		case 2:
		chaine="Quelle nouvelle balise de section permet de regrouper un contenu tangentiel au contenu principal --------du document ?.*<section id=sidebar>*<sidebar>*<aside>*<details>*3";		break;
		case 3:
		chaine="Comment peut-on définir un même gestionnaire d'événement au clic et au focus sur une image ?*$(img).click().focus().function() { ... };*$(img).bind(focus click,function() { ... });*$(img).event(focus,click, { ... });*$(img).bind(focus).bind(click, { ... });*1";		break;
		case 4:
		chaine="Quelle fonction retourne le nombre de secondes écoulées depuis le 1er janvier 1970.*time*timestamp*mktime*microtime*1";		break;
		case 5:
		chaine="Dans quel tableau de données retrouve-t-on les cookies du visiteur ?.*$SETCOOKIE*$COOKIES*$HTTP_COOKIES* $_COOKIE*2";		break;
		case 6:
		chaine="Quelle fonction permet d'effacer un fichier ?.*delete()*unlink()*remove()*clearfile()*3";		break;
		

	}
	
	return chaine;
}