import Alpine from 'alpinejs'
import focus from '@alpinejs/focus' // For better accessibility

// Initialize Alpine
window.Alpine = Alpine
Alpine.start()

// Wait for the page to load (including LCP)
document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('.animate_scroll');

  // Configure Intersection Observer
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        // Step 1: Make element visible (remove opacity:0)
        entry.target.classList.add('animated');
        
        // Step 2: Apply Animate.css effect after a tiny delay
        setTimeout(() => {
          entry.target.classList.add('animate__animated', 'animate__fadeInLeft');
        }, 10); // Short delay ensures CSS transition applies
        
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  // Observe all target sections
  sections.forEach((section) => {
    observer.observe(section);
  });
});

// Animation canvas home
(() => {
  const cnv = document.querySelector(`canvas`);
  const ctx = cnv.getContext(`2d`);
  let cw, ch, cx, cy;

  function init() {
      cw = cnv.width = innerWidth * 2;
      ch = cnv.height = innerHeight * 2;
      cx = cw / 2;
      cy = ch / 2;
  }

  init();

  window.addEventListener(`resize`, init);


  const cfg = {
      bgFillColor: 'rgba(255,193,7,.01)',
      dirsCount: 6,
      stepsToTurn: 20,
      dotSize: 4,
      dotCount: 300,
      dotVelocity: 4,
      distance: 170,
  }


  function drawRect(color, x, y, w, h, shadowColor, shadowBlur, gco) {
     ctx.globalCompositeOperation = gco;
     ctx.shadowColor = shadowColor || 'black';
      ctx.shadowBlur = shadowBlur;
      ctx.fillStyle = color;
      ctx.fillRect(x, y, w, h);
  }


  class Dot {
      constructor() {
          this.pos = {x: cx, y: cy};
          this.dir = (Math.random() * 3 | 0) * 2;
          this.step = 0;

      }

      redrawDot() {
          let color = '#ffb300';
          let size = cfg.dotSize;
          let blur = 0;
          let x = this.pos.x - size / 2;
          let y = this.pos.y - size / 2;

          drawRect(color, x, y, size, size, color, blur);
      }

      moveDot() {
          this.step++;
          this.pos.x += dirstList[this.dir].x * cfg.dotVelocity;
          this.pos.y += dirstList[this.dir].y * cfg.dotVelocity;
      }

      changeDir() {
          if (this.step % cfg.stepsToTurn === 0) {
              this.dir = Math.random() > .5
                  ? (this.dir + 1) % cfg.dirsCount
                  : (this.dir + cfg.dirsCount - 1) % cfg.dirsCount
          }
      }

      killDot(id) {
         let percent = Math.exp(this.step / cfg.distance) * Math.random();

         if (percent > 100) {
             dotList.splice(id, 1);
         }
      }
  }

  const dirstList = [];

  function createDirs() {
      for (let i = 0; i < 360; i += 360 / cfg.dirsCount) {
          let x = Math.cos(i * Math.PI / 180);
          let y = Math.sin(i * Math.PI / 180);
          dirstList.push({x: x, y: y})
      }
  }

  createDirs();

  let dotList = [];
  function addDot() {
     if(dotList.length < cfg.dotCount && Math.random() > .8) {
        dotList.push(new Dot());
     }
  }

  function refreshDots() {
     dotList.forEach((i, id) => {
        i.moveDot();
        i.redrawDot();
        i.changeDir();
        i.killDot(id);
     })
  }

  let dot = new Dot();

  function loop() {
      drawRect(cfg.bgFillColor, 0, 0, cw, ch, 0,0);
      addDot();
      refreshDots();

      requestAnimationFrame(loop)
  }

  loop();

})();


import.meta.glob([
  '../images/**',
  '../fonts/**',
]);
