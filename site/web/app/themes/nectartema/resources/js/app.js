import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'

// Initialize Alpine
window.Alpine = Alpine
Alpine.plugin(focus)
Alpine.start()

// Animação inicial H1
const element = document.querySelector('h1')
if (element) {
  element.classList.add('animate__animated', 'animate__flipInX')
}

document.addEventListener('DOMContentLoaded', () => {
  // --- 1. Cache de Elementos para Scroll ---
  const cdTop = document.querySelector('.cd-top')
  const banner = document.getElementById('banner')
  const bannerInner = document.getElementById('banner-inner')
  const logoCompleta = document.getElementById('logocompleta')
  const logoOnly = document.getElementById('logoonly')

  // --- 2. Evento Unificado de Scroll ---
  window.addEventListener(
    'scroll',
    () => {
      const scrollY = window.scrollY || window.pageYOffset

      // Botão Back to Top
      if (cdTop) {
        if (scrollY > 300) {
          cdTop.classList.add('cd-is-visible')
          if (scrollY > 1200) {
            cdTop.classList.add('cd-fade-out')
          } else {
            cdTop.classList.remove('cd-fade-out')
          }
        } else {
          cdTop.classList.remove('cd-is-visible', 'cd-fade-out')
        }
      }

      // Alternância de Logos e Encolhimento do Menu
      if (scrollY > 50) {
        // Menu encolhido
        if (banner) banner.classList.add('shrink', 'bottom-6', 'h-16')
        if (bannerInner) {
          bannerInner.classList.remove('py-4')
          bannerInner.classList.add('py-2')
        }

        // Logos
        if (logoCompleta && logoOnly) {
          logoCompleta.classList.add('opacity-0', 'pointer-events-none')
          logoCompleta.classList.remove('opacity-100')

          logoOnly.classList.add('opacity-100')
          logoOnly.classList.remove('opacity-0', 'pointer-events-none')
        }
      } else {
        // Menu no topo (Retorna exatamente ao estado original)
        if (banner) banner.classList.remove('shrink', 'bottom-6', 'h-16')
        if (bannerInner) {
          bannerInner.classList.remove('py-4')
          bannerInner.classList.add('py-2')
        }

        // Logos
        if (logoCompleta && logoOnly) {
          logoCompleta.classList.add('opacity-100')
          logoCompleta.classList.remove('opacity-0', 'pointer-events-none')

          logoOnly.classList.add('opacity-0', 'pointer-events-none')
          logoOnly.classList.remove('opacity-100')
        }
      }
    },
    { passive: true }
  )

  // --- 3. Back to Top Click ---
  if (cdTop) {
    cdTop.addEventListener('click', (event) => {
      event.preventDefault()
      window.scrollTo({ top: 0, behavior: 'smooth' })
    })
  }

  // --- 4. Quantidade WooCommerce ---
  document.querySelectorAll('.quantity').forEach((qty) => {
    const input = qty.querySelector('input[type="number"]')
    if (!input) return

    const minusBtn = document.createElement('button')
    minusBtn.type = 'button'
    minusBtn.innerText = '−'
    minusBtn.className =
      'px-3 h-full text-neutral-500 hover:text-neutral-800 transition-colors font-medium text-lg focus:outline-none'

    const plusBtn = document.createElement('button')
    plusBtn.type = 'button'
    plusBtn.innerText = '+'
    plusBtn.className =
      'px-3 h-full text-neutral-500 hover:text-neutral-800 transition-colors font-medium text-lg focus:outline-none'

    qty.insertBefore(minusBtn, input)
    qty.appendChild(plusBtn)

    minusBtn.addEventListener('click', () => {
      const val = parseInt(input.value) || 1
      const min = parseInt(input.getAttribute('min')) || 1
      if (val > min) {
        input.value = val - 1
        input.dispatchEvent(new Event('change', { bubbles: true }))
      }
    })

    plusBtn.addEventListener('click', () => {
      const val = parseInt(input.value) || 1
      const max = parseInt(input.getAttribute('max'))
      if (!max || val < max) {
        input.value = val + 1
        input.dispatchEvent(new Event('change', { bubbles: true }))
      }
    })
  })

  // --- 5. Tradução de textos dinâmicos ---
  document.querySelectorAll('.fc-title-text').forEach((el) => {
    if (el.textContent.trim() === 'Shopping Cart') {
      el.textContent = 'Carrinho'
    }
  })

  // Inicializa os Swatches de Variação
  setupSwatches()
})

// --- Swatches Premium WooCommerce ---
const setupSwatches = () => {
  const variationSelects = document.querySelectorAll('.variations select')

  variationSelects.forEach((select) => {
    if (select.classList.contains('swatches-initialized')) return
    select.classList.add('swatches-initialized', 'hidden')

    const container = document.createElement('div')
    container.className = 'flex flex-wrap gap-3 my-4'

    Array.from(select.options).forEach((option) => {
      if (!option.value) return

      const button = document.createElement('button')
      button.type = 'button'
      button.className = `
        relative px-5 py-2.5 rounded-full border-2 text-sm font-semibold transition-all duration-200
        hover:border-primary hover:text-primary active:scale-95
        ${
          option.selected
            ? 'border-primary bg-primary/5 text-primary shadow-sm'
            : 'border-gray-200 bg-white text-gray-600'
        }
      `
      button.innerHTML = `<span>${option.text}</span>`

      button.onclick = (e) => {
        e.preventDefault()
        select.value = option.value
        select.dispatchEvent(new Event('change', { bubbles: true }))

        container.querySelectorAll('button').forEach((btn) => {
          btn.classList.remove(
            'border-primary',
            'bg-primary/5',
            'text-primary',
            'shadow-sm'
          )
          btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600')
        })

        button.classList.add(
          'border-primary',
          'bg-primary/5',
          'text-primary',
          'shadow-sm'
        )
        button.classList.remove('border-gray-200', 'bg-white', 'text-gray-600')
      }

      container.appendChild(button)
    })

    select.parentNode.insertBefore(container, select)
  })
}

if (typeof jQuery !== 'undefined') {
  jQuery(document.body).on('check_variations', setupSwatches)
}

import.meta.glob(['../images/**', '../fonts/**'])