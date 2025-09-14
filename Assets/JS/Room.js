// Assets/JS/Room.js
document.addEventListener('DOMContentLoaded', function() {
  // Smooth scrolling for room buttons
  const buttons = document.querySelectorAll('.btn-book, .btn-read, .btn-back, .btn-small');
  buttons.forEach(button => {
    button.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

  // Add hover effect for room cards
  const roomCards = document.querySelectorAll('.room-card, .related-card');
  roomCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transition = 'box-shadow 0.3s ease';
      this.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.15)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
    });
  });

  // Simple image carousel for related rooms (if multiple images are added later)
  const relatedCards = document.querySelectorAll('.related-card');
  if (relatedCards.length > 0) {
    relatedCards.forEach(card => {
      const img = card.querySelector('img');
      let imgIndex = 0;
      const altImages = [
        img.src, // Current image
        'https://themewagon.github.io/sogo/images/img_3.jpg', // Placeholder for additional images
        'https://themewagon.github.io/sogo/images/img_4.jpg'
      ];

      // Uncomment below to enable carousel (requires additional images in HTML or DB)
      /*
      setInterval(() => {
        imgIndex = (imgIndex + 1) % altImages.length;
        img.src = altImages[imgIndex];
      }, 5000);
      */
    });
  }
});