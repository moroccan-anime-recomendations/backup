// Fonctions pour gérer les sliders/carousels
function initSliders() {
  const sliders = document.querySelectorAll('.categories-grid, .trending-grid, .recommended-grid');
  const prevButtons = document.querySelectorAll('.nav-arrow.prev');
  const nextButtons = document.querySelectorAll('.nav-arrow.next');
  
  // Associer les boutons de navigation aux sliders correspondants
  for (let i = 0; i < prevButtons.length; i++) {
    if (prevButtons[i] && nextButtons[i] && sliders[i]) {
      prevButtons[i].addEventListener('click', () => {
        sliders[i].scrollBy({
          left: -300,
          behavior: 'smooth'
        });
        updateProgressIndicator(i);
      });
      
      nextButtons[i].addEventListener('click', () => {
        sliders[i].scrollBy({
          left: 300,
          behavior: 'smooth'
        });
        updateProgressIndicator(i);
      });
    }
  }
}

// Mettre à jour les indicateurs de progression
function updateProgressIndicator(sliderIndex) {
  const indicators = document.querySelectorAll('.progress-indicator');
  const indicator = indicators[sliderIndex];
  
  if (indicator) {
    const spans = indicator.querySelectorAll('span');
    const activeIndex = [...spans].findIndex(span => span.classList.contains('active'));
    
    spans.forEach(span => span.classList.remove('active'));
    
    const newIndex = (activeIndex + 1) % spans.length;
    spans[newIndex].classList.add('active');
  }
}

// Fonction pour gérer les filtres
function initFilters() {
  const filterSelects = document.querySelectorAll('.filter-select');
  
  filterSelects.forEach(select => {
    select.addEventListener('change', () => {
      // Simuler un filtrage (à implémenter avec de vraies données)
      console.log('Filtre changé:', select.value);
      // Une implémentation réelle filtrerait les éléments ici
    });
  });
}

// Fonction pour ajouter une classe active au lien de navigation actuel
function setActiveNavLink() {
  const currentPage = window.location.pathname.split('/').pop();
  const navLinks = document.querySelectorAll('.main-nav a');
  
  navLinks.forEach(link => {
    link.classList.remove('active');
    const linkPage = link.getAttribute('href');
    
    if (currentPage === linkPage || 
        (currentPage === '' && linkPage === 'index.html') || 
        (currentPage === '/' && linkPage === 'index.html')) {
      link.classList.add('active');
    }
  });
}

// Animation pour les cartes d'anime
function animateAnimeCards() {
  const animeCards = document.querySelectorAll('.trending-card, .category-card, .anime-item');
  
  animeCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'translateY(-5px)';
      card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
    });
    
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });
}

// Initialiser tout lors du chargement de la page
document.addEventListener('DOMContentLoaded', function() {
  setActiveNavLink();
  initSliders();
  initFilters();
  animateAnimeCards();
}); 