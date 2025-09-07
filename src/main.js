import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Mobile menu functionality
document.addEventListener('alpine:init', () => {
  Alpine.data('mobileMenu', () => ({
    isOpen: false,
    
    toggle() {
      this.isOpen = !this.isOpen;
      document.body.classList.toggle('overflow-hidden', this.isOpen);
    },
    
    close() {
      this.isOpen = false;
      document.body.classList.remove('overflow-hidden');
    }
  }));
  
  Alpine.data('header', () => ({
    isScrolled: false,
    
    init() {
      window.addEventListener('scroll', () => {
        this.isScrolled = window.scrollY > 50;
      });
    }
  }));
  
  Alpine.data('searchModal', () => ({
    isOpen: false,
    
    open() {
      this.isOpen = true;
      this.$nextTick(() => {
        this.$refs.searchInput.focus();
      });
    },
    
    close() {
      this.isOpen = false;
    }
  }));
});

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
  const links = document.querySelectorAll('a[href^="#"]');
  
  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});