// Ce script crée et insère un footer unifié sur toutes les pages

document.addEventListener('DOMContentLoaded', function() {
  // Vérifier si on est sur la page login ou signup
  const currentPage = window.location.pathname.split('/').pop();
  if (currentPage === 'login.html' || currentPage === 'singup.html') {
    // Ne pas ajouter le footer sur ces pages
    return;
  }
  
  // Créer le footer
  const footer = document.createElement('footer');
  footer.className = 'main-footer';
  
  // Contenu du footer
  footer.innerHTML = `
    <div class="footer-content">
      <div class="footer-logo">
        <h2>بوابتكم المغربية للأنمي</h2>
      </div>
      <div class="footer-links">
        <div class="footer-section">
          <h3>روابط سريعة</h3>
          <ul>
            <li><a href="index.html">الرئيسية</a></li>
            <li><a href="top100.html">TOP 100</a></li>
            <li><a href="profile-overview.html">الملف الشخصي</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>التصنيفات</h3>
          <ul>
            <li><a href="top100.html?genre=Action">Action</a></li>
            <li><a href="top100.html?genre=Drama">Drama</a></li>
            <li><a href="top100.html?genre=Romance">Romance</a></li>
            <li><a href="top100.html?genre=Comedy">Comedy</a></li>
            <li><a href="top100.html?genre=Fantasy">Fantasy</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>تواصل معنا</h3>
          <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-discord"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>جميع الحقوق محفوظة © 2023 بوابتكم المغربية للأنمي</p>
    </div>
  `;
  
  // Ajouter le footer au body
  document.body.appendChild(footer);
}); 