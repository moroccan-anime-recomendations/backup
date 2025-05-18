// Script pour ajouter des animations au site

document.addEventListener('DOMContentLoaded', function() {
  // Animation de la page d'accueil
  if (window.location.pathname.endsWith('index.html') || window.location.pathname === '/' || window.location.pathname === '') {
    // Animation du titre de bienvenue
    const welcomeText = document.querySelector('.welcome-text');
    if (welcomeText) {
      welcomeText.style.opacity = '0';
      welcomeText.style.transform = 'translateY(50px)';
      
      setTimeout(() => {
        welcomeText.style.transition = 'opacity 1s ease, transform 1s ease';
        welcomeText.style.opacity = '1';
        welcomeText.style.transform = 'translateY(0)';
      }, 300);
    }
    
    // Animation des sections
    const sections = document.querySelectorAll('.categories-section, .trending-section, .recommended-section, .popular-section');
    
    if (sections.length > 0) {
      sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
          section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
          section.style.opacity = '1';
          section.style.transform = 'translateY(0)';
        }, 500 + (index * 200));
      });
    }
  }
  
  // Animation des pages de détail
  if (window.location.pathname.includes('animedetail.html') || window.location.pathname.includes('character-detail.html')) {
    // Animation de l'en-tête
    const header = document.querySelector('.anime-header, .character-header');
    if (header) {
      header.style.opacity = '0';
      header.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        header.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        header.style.opacity = '1';
        header.style.transform = 'translateY(0)';
      }, 300);
    }
    
    // Animation des sections de contenu
    const contentSections = document.querySelectorAll('.content-section');
    
    if (contentSections.length > 0) {
      contentSections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
          section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
          section.style.opacity = '1';
          section.style.transform = 'translateY(0)';
        }, 600 + (index * 150));
      });
    }
    
    // Animation de la barre latérale
    const sidebar = document.querySelector('.content-sidebar');
    if (sidebar) {
      sidebar.style.opacity = '0';
      sidebar.style.transform = 'translateX(20px)';
      
      setTimeout(() => {
        sidebar.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        sidebar.style.opacity = '1';
        sidebar.style.transform = 'translateX(0)';
      }, 800);
    }
  }
  
  // Animation de la page TOP 100
  if (window.location.pathname.includes('top100.html')) {
    // Animation du titre et description
    const pageHeader = document.querySelector('.page-header');
    if (pageHeader) {
      pageHeader.style.opacity = '0';
      pageHeader.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        pageHeader.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        pageHeader.style.opacity = '1';
        pageHeader.style.transform = 'translateY(0)';
      }, 300);
    }
    
    // Animation des filtres
    const filters = document.querySelector('.top100-filters');
    if (filters) {
      filters.style.opacity = '0';
      
      setTimeout(() => {
        filters.style.transition = 'opacity 0.8s ease';
        filters.style.opacity = '1';
      }, 600);
    }
    
    // Animation des éléments de la liste
    const animeItems = document.querySelectorAll('.anime-item');
    
    if (animeItems.length > 0) {
      animeItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
          item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
          item.style.opacity = '1';
          item.style.transform = 'translateY(0)';
        }, 800 + (index * 100));
      });
    }
  }
  
  // Animation au scroll pour tous les pages
  function fadeInOnScroll() {
    const elements = document.querySelectorAll('.fade-in-scroll');
    
    elements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const screenPosition = window.innerHeight;
      
      if (elementPosition < screenPosition - 100) {
        element.classList.add('visible');
      }
    });
  }
  
  // Ajouter la classe fade-in-scroll aux éléments à animer
  const scrollAnimElements = document.querySelectorAll('.section-title, .anime-item, .character-card, .trending-card, .category-card');
  
  scrollAnimElements.forEach(element => {
    element.classList.add('fade-in-scroll');
    
    // Ajouter des styles CSS pour l'animation
    element.style.opacity = '0';
    element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
    element.style.transform = 'translateY(20px)';
  });
  
  // Ajouter une classe pour les éléments visibles
  document.head.insertAdjacentHTML('beforeend', `
    <style>
      .fade-in-scroll.visible {
        opacity: 1 !important;
        transform: translateY(0) !important;
      }
    </style>
  `);
  
  // Événement pour détecter le scroll
  window.addEventListener('scroll', fadeInOnScroll);
  
  // Déclencher l'animation au chargement initial
  fadeInOnScroll();
}); 