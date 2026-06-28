/* Service Hover Preview - Services Page */
(function() {
  var items = document.querySelectorAll('.service-item');
  var preview = document.getElementById('servicePreview');
  if (!items.length || !preview) return;

  var defaultPanel = preview.querySelector('.sp-default');
  var contents = preview.querySelectorAll('.sp-content');

  function showPreview(service) {
    items.forEach(function(i) { i.classList.remove('active'); });
    if (defaultPanel) defaultPanel.style.display = 'none';
    contents.forEach(function(c) {
      c.classList.toggle('active', c.getAttribute('data-preview') === service);
    });
  }

  items.forEach(function(item) {
    item.addEventListener('mouseenter', function() {
      this.classList.add('active');
      showPreview(this.getAttribute('data-service'));
    });
    item.addEventListener('click', function() {
      this.classList.add('active');
      showPreview(this.getAttribute('data-service'));
      if (window.innerWidth <= 900) {
        preview.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
})();
