const navbar = document.getElementById('navbar');
const backToTop = document.getElementById('backToTop');
const hamburger = document.getElementById('hamburger');
const navLinks = document.querySelector('.nav-links');

window.addEventListener('scroll', () => {
  const scrolled = window.scrollY > 60;
  navbar?.classList.toggle('scrolled', scrolled);
  backToTop?.classList.toggle('visible', scrolled);
}, { passive: true });

hamburger?.addEventListener('click', () => {
  navLinks?.classList.toggle('open');
  hamburger.setAttribute('aria-expanded', String(navLinks?.classList.contains('open')));
});

document.querySelectorAll('.nav-links a').forEach((link) => {
  link.addEventListener('click', () => {
    navLinks?.classList.remove('open');
    hamburger?.setAttribute('aria-expanded', 'false');
  });
});

const sections = document.querySelectorAll('section[id]');
const navItems = document.querySelectorAll('.nav-links a');
const navObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;
    navItems.forEach((item) => item.classList.toggle('active', item.getAttribute('href') === `#${entry.target.id}`));
  });
}, { rootMargin: '-30% 0px -60%', threshold: 0 });
sections.forEach((section) => navObserver.observe(section));

document.querySelectorAll('.service-card, .portfolio-item, .tool-pill, .about-highlights span').forEach((element, index) => {
  element.dataset.reveal = '';
  element.style.transitionDelay = `${(index % 4) * 70}ms`;
});
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add('revealed');
    revealObserver.unobserve(entry.target);
  });
}, { threshold: 0.08 });
document.querySelectorAll('[data-reveal]').forEach((element) => revealObserver.observe(element));

const graceForm = document.getElementById('graceContactForm');
graceForm?.addEventListener('submit', async (event) => {
  event.preventDefault();
  const button = graceForm.querySelector('button[type="submit"]');
  const message = document.getElementById('form-msg');
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
  const submitLabel = button.dataset.label || button.textContent;

  button.disabled = true;
  button.textContent = 'Sending…';
  message.textContent = '';

  try {
    const response = await fetch('/grace-sellah/contact', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, Accept: 'application/json' },
      body: JSON.stringify({
        name: graceForm.name.value.trim(),
        email: graceForm.email.value.trim(),
        service: graceForm.service.value,
        message: graceForm.message.value.trim(),
      }),
    });
    const data = await response.json();
    if (!response.ok || !data.success) {
      throw new Error(data.errors ? Object.values(data.errors).flat().join(' ') : 'Please check the form and try again.');
    }
    message.textContent = data.message || 'Thank you — your enquiry has been sent.';
    message.style.color = data.email_sent === false ? '#8a5a12' : '#28734b';
    graceForm.reset();
  } catch (error) {
    message.textContent = error.message || 'Unable to send right now. Please try again.';
    message.style.color = '#a83232';
  } finally {
    button.disabled = false;
    button.textContent = submitLabel;
  }
});
