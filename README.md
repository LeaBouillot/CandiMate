Redeme.md

CREATING A CandiMate 
    symfony new candimate --webapp
    symfony server:start -d
    symfony server:stop
    

INSTALLING TAILWIND
    composer require symfonycasts/tailwind-bundle
    php bin/console tailwind:init
    php bin/console tailwind:build --watch


ENTITY
    symfony console make:User
        -id int not null unique
        -email varchar120 not null 
        -password varchar120 not null
        -firstName varchar120 not  null
        -lastName varchar120 not null
        -createdAt datetimeimmutable not null
        -updatedAt datetimeimmutable not null
        -image varchar255 nullable 
        -roles array not null


    symfony console make:entity JobOffer
        -id int not null unique 
        -title varchar180 not null
        -company varchar180 not null
        -link varchar120 nullable 
        -location varchar255 nullable
        -salary varchar180 nullable
        -contactPerson varchar120 nullable 
        -contactEmail varchar120 nullable 
        -applicationDate date not null 
        -status ennum('A postuler, En attente, Entretien, Refusé, Accepté) not null
        -app_user M21 with User not null orphan removal yes 


    symfony console make:entity LinkedInMessage
        -id int not null unique 
        -content text not null 
        -createdAt datetimeimmutable not null 
        -updatedAt datetimeimmutable not null 
        -jobOffer M21 with JobOffer not null orphan removal yes
        -app_user M21 with User not null orphan removal yes


    symfony console make:entity CoverLetter
        -id int not null unique 
        -content text not null
        -createdAt datetimeimmutable not null 
        -updatedAt datetimeimmutable not null 
        -jobOffer M21 with JobOffer not null  orphan removal yes
        -app_user M21 with User not null orphan removal yes




CONTROLLER
    symfony console make:controller Home
    symfony console make:controller JobOffer
    symfony console make:controller LinkedInMessage
    symfony console make:controller CoverLetter



FIXTURES 
    composer require orm-fixtures --dev
    composer require fakerphp/faker



CREATION BDD
    create.env.local and change the necessary BDD
    symfony console d:d:c
    symfony console make:migration
    symfony console d:m:m  


LOADED THE FIXTURES 
    symfony console d:f:l


CREATING SECURITY CONTROLLER AND REGISTRATION FORM
    symfony console make:security:form-login 
        SecurityController with /logout and no phpUnit test
    symfony console make:registration-form
         composer require symfonycasts/verify-email-bundle 

Configuring Symfony Mailer
    `https://mailtrap.io/blog/send-emails-in-symfony/`
    composer require symfony/mailer
    src/Controller/MailerController.php

INSTALLED UX ICON FROM SYMFONY 
    composer require symfony/ux-twig-component
    composer require symfony/ux-icon


KANBAN controller 
    symfony console make:controller Kanban

ApiJobOfferController
    symfony console make:controller ApiJobOffer

    composer require symfony/security-bundle

ADMIN

composer require easycorp/easyadmin-bundle
    composer req easycorp/easyadmin-bundle
    symfony console make:admin:dashboard    
    symfony console make:admin:crud 



GEMINI API

composer require google-gemini-php/symfony  : verifies in the vendor

Create a key Geminini API:
`https://makersuite.google.com/app/apikey`
configuration: service.yaml
.env.local GEMINI_API_KEY="key here"

Create a Controller for accessing the Geminini API or in the CoverletterController:
curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=GEMINI_API_KEY" \
-H 'Content-Type: application/json' \
-X POST \
-d '{
  "contents": [{
    "parts":[{"text": "Explain how AI works"}]
    }]
   }'


GENERATION LinkedInMessage




PAGINATION (knp paginator bundle) 
    composer require knplabs/knp-paginator-bundle
    
    copy from vendor\knplabs\knp-pagination-bundle\templates\pagination\tailwindcss to template\components\pagination.html.twig
    created paginator.yaml with contents already given and change    << pagination: "components/pagination.html.twig">>

AI

KANBAN
