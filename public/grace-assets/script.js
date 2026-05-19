/* ── Navbar scroll state ── */
const navbar = document.getElementById('navbar');
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
  if (window.scrollY > 60) {
    navbar.classList.add('scrolled');
    backToTop.classList.add('visible');
  } else {
    navbar.classList.remove('scrolled');
    backToTop.classList.remove('visible');
  }
});

/* ── Hamburger menu ── */
const hamburger = document.getElementById('hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
  navLinks.classList.toggle('open');
});

document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => navLinks.classList.remove('open'));
});

/* ── Active nav link on scroll ── */
const sections = document.querySelectorAll('section[id]');
const navItems = document.querySelectorAll('.nav-links a');

const observerNav = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      navItems.forEach(a => {
        a.style.fontWeight = a.getAttribute('href') === '#' + entry.target.id ? '700' : '';
      });
    }
  });
}, { threshold: 0.4 });

sections.forEach(s => observerNav.observe(s));

/* ── Scroll-reveal ── */
const revealEls = document.querySelectorAll(
  '.strip-card, .service-card, .portfolio-item, .tool-pill, .contact-item, .about-highlights .highlight-item'
);
revealEls.forEach((el, i) => {
  el.setAttribute('data-reveal', '');
  el.style.transitionDelay = (i % 4) * 80 + 'ms';
});

const revealObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('revealed');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('[data-reveal]').forEach(el => revealObserver.observe(el));

/* ── Contact form ── */
const graceForm = document.getElementById('graceContactForm');
if (graceForm) {
  graceForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = graceForm.querySelector('button[type="submit"]');
    const msg = document.getElementById('form-msg');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    btn.disabled = true;
    btn.textContent = 'Sending…';
    msg.textContent = '';
    msg.style.color = '';

    const body = {
      name:    graceForm.querySelector('#name').value.trim(),
      email:   graceForm.querySelector('#email').value.trim(),
      service: graceForm.querySelector('#service').value,
      message: graceForm.querySelector('#message').value.trim(),
    };

    try {
      const res = await fetch('/grace-sellah/contact', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
        },
        body: JSON.stringify(body),
      });

      const data = await res.json();

      if (res.ok && data.success) {
        msg.textContent = 'Message sent! Grace will get back to you shortly.';
        msg.style.color = '#4a7c5f';
        graceForm.reset();
      } else {
        const errors = data.errors ? Object.values(data.errors).flat().join(' ') : 'Something went wrong. Please try again.';
        msg.textContent = errors;
        msg.style.color = '#c0392b';
      }
    } catch {
      msg.textContent = 'Network error. Please check your connection and try again.';
      msg.style.color = '#c0392b';
    } finally {
      btn.disabled = false;
      btn.textContent = 'Send Message';
      setTimeout(() => { msg.textContent = ''; }, 7000);
    }
  });
}
