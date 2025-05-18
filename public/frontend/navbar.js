// Ce script crée et insère une navbar unifiée sur toutes les pages

document.addEventListener('DOMContentLoaded', function() {
  // Vérifier si on est sur la page login ou signup
  const currentPage = window.location.pathname.split('/').pop();
  if (currentPage === 'login.html' || currentPage === 'singup.html') {
    // Ne pas ajouter la navbar sur ces pages
    return;
  }
  
  // Vérifier si une navbar existe déjà
  const existingHeader = document.querySelector('.main-header');
  if (existingHeader) {
    // Remplacer la navbar existante
    existingHeader.remove();
  }
  
  // Créer la nouvelle navbar
  const header = document.createElement('header');
  header.className = 'main-header';
  
  // Contenu de la navbar
  header.innerHTML = `
    <div class="logo">
      <h1>بوابتكم المغربية للأنمي</h1>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="index.html">الرئيسية</a></li>
        <li><a href="top100.html">TOP 100</a></li>
        <li><a href="profile-overview.html">الملف الشخصي</a></li>
        <li class="auth-links">
          <a href="login.html">تسجيل الدخول</a>
          <a href="singup.html">إنشاء حساب</a>
        </li>
      </ul>
    </nav>
  `;
  
  // Insérer la navbar au début du body
  const body = document.body;
  body.insertBefore(header, body.firstChild);
  
  // Mettre en évidence le lien actif
  const links = header.querySelectorAll('.main-nav a');
  links.forEach(link => {
    if (link.getAttribute('href') === currentPage || 
        (currentPage === '' && link.getAttribute('href') === 'index.html') ||
        (currentPage === '/' && link.getAttribute('href') === 'index.html') ||
        (currentPage === 'profile.html' && link.getAttribute('href') === 'profile-overview.html')) {
      link.classList.add('active');
    }
  });
}); 