# Plugin MineWeb | Shop-beta

## Description
Le plugin Shop ajoute une boutique en ligne sur votre site, permettant à vos joueurs d'acheter des choses contre de l'argent réel (VotreSite/shop).
Cette version permet de rajouter les sous catégories

## Modification SQL
Pour utiliser le plugin il faut sois supprimer et mettre ce plugin shop sauf que la bdd sera vide, OU sinon il suffit d'entrer ces lignes sur votre phpmyadmin ou votre terminal :

-   Premiere commande, il faut cependant changer mineweb par votre base de donnée
    -   ```CREATE TABLE `mineweb`.`shop__sections` ( `id` INT(20) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , PRIMARY KEY     (`id`)) ENGINE = InnoDB;```

-   ```ALTER TABLE `shop__categories` ADD `section` INT(1) NOT NULL AFTER `section_id`, ADD `section_id` INT(8) NOT NULL AFTER `section`;```
Et ensuite il suffit de vider app/tmp et de changer les fichiers app/Plugin, faites une sauvegarde de la bdd avant !

## Installation | FTP
1. Cliquez sur "Clone or download" sur la page "https://github.com/nivcoo/Plugin-Shop-beta".
2. Téléchargez et enregistrez le ZIP, puis extrayez le.
3. Renommez le fichier "Plugin-Shop-beta-master" par "Shop".
4. Déplacez le fichier dans votre FTP à l'adresse "/app/Plugin".
5. Supprimez tous les fichiers dans le "/app/tmp/cache" de votre FTP.
6. Installation effectuée.

## Installation | Site - NON DISPONIBLE
1. Rendez-vous à l'adresse "VotreSite/admin/plugin".
2. Cherchez le plugin "Shop" dans le tableau "Plugins gratuits et achetés disponibles".
3. Cliquez sur "Installer" pour installer le plugin sur votre site.
4. Supprimez tous les fichiers dans le "/app/tmp/cache" de votre FTP.
5. Installation effectuée.
