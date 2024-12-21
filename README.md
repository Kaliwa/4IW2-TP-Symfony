TP Noté Symfony
Objectif :
Créer un projet Symfony avec un thème donné et des features à implémenter pour valider le TP. Le but est de montrer que vous avez compris les bases de Symfony et que vous êtes capable de créer un projet complet avec des features de base.

Pas besoin que le site soit une oeuvre d'art, par contre il faut que ce soit un minimum présentable et que ça fonctionne.

TP :
8 - Exercices -> Matières, Chapitres, Exercices, Commentaires
Vous devez travailler sur le thème imposé. Si vous ne respectez pas le thème, ce sera 0.

Features à faire sur les projets :
Créer les entités et faire les relations (minimum 4 entités)
Créer des fixtures (PHP ou YAML)
Faire l'authentification
login
mdp oublié, reset mdp
Avoir 3 roles différents (ADMIN, USER, BANNED)
Afficher du contenu dynamiquement en fonction de si l'utilisateur est connecté ou non
Si connecté, afficher son nom et prénom
Si non connecté, afficher un bouton pour se connecter
Si connecté, afficher un bouton pour se déconnecter
Afficher du contenu dynamiquement en fonction de si l'utilisateur à certains roles ou non
Si ADMIN, afficher un bouton pour accéder à l'admin
Si USER, afficher un bouton pour accéder à son profil
Si BANNED, afficher un message pour dire qu'il est banni et ne pas lui afficher les pages
Faire les pages pour lire/créer/modifier/supprimer les différentes entités
Pensez à sécuriser les formulaires et les routes

Autre infos
Toute chose qui n'est pas demandé fera des points en +

Plus d'entités = Pts en +
Feature pas demandé = Pts en +
Techno en + = Pts en +
etc ...
Pour les plus déters :
Exemples de features avancées pour taper le 21/20 :

Brancher une API SMS
Brancher une API de paiement
Faire un système de recherche
Faire un système de filtres
Brancher ChatGPT pour simplfier la rédaction de contenu pour vos entités
Faire un système de notifications
Faire du temps réel avec Mercure
Faire de l'async avec RabbitMQ

```uml
@startuml

entity "users" as users {
  +id : int
  email : string
  password : string
  prenom : string
  nom : string
  roles : string
  classe_id : int
}

entity "classroom" as classroom {
  +id : int
  nom : string
  niveau : string
}

entity "subject" as subject {
  +id : int
  nom : string
  description : string
}

entity "classroom_subject" as classroom_subject {
  +id : int
  matiere_id : int
  classe_id : int
}

entity "chapter" as chapter {
  +id : int
  titre : string
  description : string
  matiere_id : int
}

entity "exercise" as exercise {
  +id : int
  question : string
  reponse : string
  chapitre_id : int
}

entity "comment" as comment {
  +id : int
  contenu : string
  user_id : int
  exercice_id : int
  created_at : datetime
}

' Relationships
users -- classroom : "1..n"
subject -- chapter : "1..n"
chapter -- exercise : "1..n"
exercise -- comment : "1..n"
users -- comment : "1..n"
classroom_subject -- subject : "n..1"
classroom_subject -- classroom : "n..1"

@enduml
```
