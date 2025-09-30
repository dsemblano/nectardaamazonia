import Alpine from 'alpinejs'
import focus from '@alpinejs/focus' // For better accessibility

// Initialize Alpine
window.Alpine = Alpine
Alpine.start()

// Wait for the page to load (including LCP)
// document.addEventListener('DOMContentLoaded', () => {
//   const sections = document.querySelectorAll('.animate_scroll');

//   // Configure Intersection Observer
//   const observer = new IntersectionObserver((entries) => {
//     entries.forEach((entry) => {
//       if (entry.isIntersecting) {
//         // Step 1: Make element visible (remove opacity:0)
//         entry.target.classList.add('animated');
        
//         // Step 2: Apply Animate.css effect after a tiny delay
//         setTimeout(() => {
//           entry.target.classList.add('animate__animated', 'animate__fadeInLeft');
//         }, 10); // Short delay ensures CSS transition applies
        
//         observer.unobserve(entry.target);
//       }
//     });
//   }, { threshold: 0.1 });

//   // Observe all target sections
//   sections.forEach((section) => {
//     observer.observe(section);
//   });
// });

// cd top
// document.addEventListener("DOMContentLoaded", function() {
//     //hide or show the "back to top" link

//     //smooth scroll to top
//     document.querySelector('.cd-top').addEventListener('click', function(event) {
//         event.preventDefault();
//         window.scrollTo({top: 0, behavior: 'smooth'});
//     });
// });

// animate
const element = document.querySelector('h1');
element.classList.add('animate__animated', 'animate__flipInX');

// run on load and resize (debounce in production)
function setVh() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}
setVh();
window.addEventListener('resize', setVh);


import.meta.glob([
  '../images/**',
  '../fonts/**',
]);
