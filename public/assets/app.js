document.querySelectorAll('.card button').forEach((button) => {
  button.addEventListener('click', () => {
    button.classList.add('loading');
  });
});

const searchInput = document.querySelector('#feature-search');
if (searchInput) {
  const items = Array.from(document.querySelectorAll('.feature-item'));
  searchInput.addEventListener('input', (event) => {
    const keyword = event.target.value.trim().toLowerCase();
    document.querySelectorAll('.feature-item').forEach((item) => {
      const text = item.textContent.toLowerCase();
      item.style.display = keyword === '' || text.includes(keyword) ? '' : 'none';
    });
  });
}

document.querySelectorAll('.feature-load-more').forEach((button) => {
  button.addEventListener('click', async () => {
    const card = button.closest('[data-category]');
    if (!card) {
      return;
    }
    const side = card.dataset.side;
    const category = card.dataset.category;
    const total = Number(card.dataset.total || 0);
    const page = Number(card.dataset.page || 1) + 1;
    const per = 20;
    const list = card.querySelector('.feature-list');

    if (!list) {
      return;
    }

    const response = await fetch(
      `/features?format=json&side=${encodeURIComponent(side)}&category=${encodeURIComponent(category)}&page=${page}&per=${per}`
    );
    const payload = await response.json();
    if (!payload.items || payload.items.length === 0) {
      button.disabled = true;
      button.textContent = '已加载完';
      return;
    }

    payload.items.forEach((item) => {
      const li = document.createElement('li');
      li.className = 'feature-item';

      const title = document.createElement('strong');
      title.textContent = item.title;
      li.appendChild(title);

      const desc = document.createElement('p');
      desc.textContent = item.description;
      li.appendChild(desc);

      const sublist = document.createElement('ul');
      sublist.className = 'feature-sublist';
      item.deliverables.forEach((deliverable) => {
        const sub = document.createElement('li');
        sub.textContent = deliverable;
        sublist.appendChild(sub);
      });
      li.appendChild(sublist);

      list.appendChild(li);
    });

    card.dataset.page = String(page);
    const loaded = list.querySelectorAll('.feature-item').length;
    if (loaded >= total) {
      button.disabled = true;
      button.textContent = '已加载完';
    }
  });
});
