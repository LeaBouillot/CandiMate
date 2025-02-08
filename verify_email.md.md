VerifyEmailBundle: Love Confirming Emails
`https://github.com/SymfonyCasts/verify-email-bundle`

vos utilisateurs ont une adresse e-mail valide.

VerifyEmailBundle génère - et valide - une URL sécurisée et signée qui peut être envoyée par e-mail aux utilisateurs pour confirmer leur adresse e-mail. Il le fait sans nécessiter de stockage, vous pouvez donc utiliser vos entités existantes avec des modifications mineures. Ce bundle fournit :

Un générateur pour créer une URL signée qui doit être envoyée par e-mail à l'utilisateur.
Un validateur d'URL signé.
Tranquillité d'esprit sachant que cela est fait sans divulguer l'adresse e-mail de l'utilisateur dans les journaux de votre serveur (évitant les problèmes d'informations personnelles identifiables).
///
Installation
   composer require symfonycasts/verify-email-bundle
Usage
   bin/console make:registration-form

Setting Things Up Manually:
   // RegistrationController.php
   // src/Security/EmailVerifier.php

config/packages/verify_email.yaml config file:
   symfonycasts_verify_email:
    lifetime: 3600


