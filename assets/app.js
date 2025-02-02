import './bootstrap.js';

// Importer les styles si ce n'est pas encore fait
import './styles/app.css';

// Script pour le menu mobile
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        // Gestionnaire pour le bouton du menu
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Empêcher la fermeture lors du clic sur le menu lui-même
        mobileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});

// document.addEventListener('DOMContentLoaded', () => {
//     const mobileMenuButton = document.getElementById('mobile-menu-button');
//     const mobileMenu = document.getElementById('mobile-menu');

//     if (mobileMenuButton) {
//         mobileMenuButton.addEventListener('click', () => {
//             mobileMenu.classList.toggle('hidden'); // Ajoute/retire la classe hidden
//         });
//     }
// });

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
