Windows & Docker & Laravel

1 - Installation WSL
  - Ouvir une ligne de commande
  - `wsl --install`
2 - Installation Docker
  - Aller dans `Paramètres -> Ressource -> WSL INTEGRATION`
  -  Cocher la version choisi du WSL

3 - Lancer votre WSL
  - En ligne de commande (Terminal/Ubuntu)

4 - Installation Package
  - `sudo apt-get update`
  - `sudo apt-get upgrade`
  - `sudo apt-get install -y git openssh-client`

5 - Créer une clé SSH
  - Se placer dans son dossier home : `cd ~`
  - `ssh-keygen`
  - `cd .ssh/`
  - `ls -al`
  - `cat id_rsa.pub`
  - Copier votre clé pub

6 - Ajout clé SSH sur Git
  - Se connecter depuis le navigateur
  - Aller dans `settings -> SSH and GPG keys`
  - Cliquer sur `New SSH Key` pour ajouter votre clé pub

7 - Test de la clé SSH 
  - Retourner sur le terminal 
  - `cd ~`
  - `ssh-add`
  - Cloner un projet git en choisissant le lien SSH : `git  clone [lien.git]`

8 - Configuration des projet Laravel
  - Aller dans les dossier `api_gateway/src` et `email_service/src` pour ajouter vos fichier `.env` ou vous pouvez renommer les fichier `.env.example` en `.env`

9 - Lancement des containers 
  - Aller dans le dossier du projet là ou il y'a le fichier `docker-compose.yml`
  - Executer la commande : `docker-compose build` 
  - Executer la commande : `docker-compose up -d` 

10 - Installation des package du projet
  - Executer la commande : `docker exec -it api_gateway composer install`   
  - Executer la commande : `docker exec -it email_service composer install`   
  - Executer la commande : `docker exec -it email_service php artisan migrate`   