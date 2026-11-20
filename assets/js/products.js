// Catalogue UI state is scoped to this browser tab. PHP supplies initial records and page shells.
// Hooks: .js-component-products-{row,filters,count,range,empty,detail,value,gallery,editor,upload,feedback,preview}.
// No catalogue or image data is transmitted. Image files are previewed after type and size validation.
(() => {
  const source = document.getElementById('product-catalogue-data');
  if (!source) return;
  const config = JSON.parse(source.textContent);
  const storageKey = 'wireland-product-catalogue-v1';
  let changes = {};
  try {
    changes = JSON.parse(sessionStorage.getItem(storageKey) || '{}');
  } catch {
    changes = {};
  }
  const catalogue = new Map(config.products.map((product) => [product.id, product]));
  Object.entries(changes).forEach(([id, product]) => catalogue.set(id, product));
  // Category IDs and previous names preserve assignments across category renames.
  // Hooks: .js-component-categories-{list,count,editor,title,feedback,slug,total,search-*,visible,hidden}.
  const categoryStorageKey = 'wireland-product-categories-v1';
  let categoryChanges = {};
  try {
    categoryChanges = JSON.parse(sessionStorage.getItem(categoryStorageKey) || '{}');
  } catch {
    categoryChanges = {};
  }
  const categories = new Map(config.categories.map((category) => [category.id, category]));
  Object.entries(categoryChanges).forEach(([id, category]) => categories.set(id, category));
  const categoryForProduct = (product) => categories.get(product.category_id) ||
    [...categories.values()].find((category) => category.name === product.category ||
      category.previous_names?.includes(product.category));
  catalogue.forEach((product) => {
    const category = categoryForProduct(product);
    if (category) {
      product.category_id = category.id;
      product.category = category.name;
    }
  });
  document.querySelectorAll('select[name="category"]').forEach((select) => {
    const current = select.value;
    const allOption = select.querySelector('option[value=""]');
    select.replaceChildren();
    if (allOption) select.append(allOption);
    categories.forEach((category) => select.add(new Option(category.name, category.name)));
    const category = categoryForProduct({ category: current });
    select.value = category?.name || current;
  });
  const categoryList = document.querySelector('.js-component-categories-list');
  if (categoryList) {
    const template = categoryList.firstElementChild.cloneNode(true);
    categoryList.replaceChildren();
    categories.forEach((category) => {
      const row = template.cloneNode(true);
      const cell = (key) => row.querySelector(`.js-component-categories-${key}`);
      const searchReady = Boolean(category.slug && (category.meta_description || category.description));
      row.querySelector('th').textContent = category.name;
      cell('slug').textContent = category.slug || '';
      cell('total').textContent = [...catalogue.values()]
        .filter((product) => product.category_id === category.id).length;
      cell('search-ready').hidden = !searchReady;
      cell('search-missing').hidden = searchReady;
      cell('visible').hidden = Boolean(category.noindex);
      cell('hidden').hidden = !category.noindex;
      const link = row.querySelector('a');
      link.href = `${config.category_edit_url}?id=${encodeURIComponent(category.id)}`;
      link.setAttribute('aria-label', `Edit Category: ${category.name}`);
      categoryList.append(row);
    });
    document.querySelector('.js-component-categories-count').textContent = `${categories.size} categories`;
  }
  const categoryEditor = document.querySelector('.js-component-categories-editor');
  if (categoryEditor) {
    const id = categoryEditor.dataset.categoryId;
    const originalCategory = categories.get(id);
    const name = categoryEditor.elements.namedItem('name');
    const feedback = categoryEditor.querySelector('.js-component-categories-feedback');
    if (id && !originalCategory) {
      categoryEditor.hidden = true;
      document.querySelector('.js-component-categories-title').textContent = 'Category Not Found';
      return;
    }
    // SEO fields: slug follows the name until edited; preview and counters mirror the form.
    // Hooks: .js-component-categories-preview-{slug,title,description,status}.
    const fields = Object.fromEntries(['slug', 'description', 'image_alt', 'meta_title', 'meta_description', 'noindex']
      .map((key) => [key, categoryEditor.elements.namedItem(key)]));
    const preview = (key) => categoryEditor.querySelector(`.js-component-categories-preview-${key}`);
    const slugify = (value) => value.toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const slugPattern = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
    name.value = originalCategory?.name || '';
    fields.slug.value = originalCategory?.slug || slugify(name.value);
    fields.description.value = originalCategory?.description || '';
    fields.meta_title.value = originalCategory?.meta_title || '';
    fields.meta_description.value = originalCategory?.meta_description || '';
    fields.noindex.checked = Boolean(originalCategory?.noindex);
    fields.image_alt.value = originalCategory?.image_alt || '';
    // Category photo: single image from forms/file-upload; stored as its URL or data URL.
    const photoRoot = categoryEditor.querySelector('.js-component-file-upload-root');
    const photo = window.FileUpload.init(photoRoot);
    photo.setValues(originalCategory?.image ? [originalCategory.image] : []);
    photoRoot.addEventListener('file-upload:change', () => {
      fields.image_alt.setCustomValidity('');
      feedback.textContent = '';
    });
    let slugEdited = Boolean(originalCategory?.slug);
    const updateCounter = (input) => {
      const help = document.getElementById(`${input.id}-help`);
      if (help) help.textContent = `${input.value.length} of ${input.maxLength} characters`;
    };
    const updatePreview = () => {
      preview('slug').textContent = fields.slug.value || 'category-slug';
      preview('title').textContent = fields.meta_title.value.trim() || name.value.trim() || 'Category name';
      preview('description').textContent = fields.meta_description.value.trim() ||
        fields.description.value.trim() || 'Add a description to show it in search results.';
      preview('status').textContent = fields.noindex.checked ? 'Hidden from search engines.' : '';
      updateCounter(fields.meta_title);
      updateCounter(fields.meta_description);
    };
    updatePreview();
    const save = categoryEditor.querySelector('button[type="submit"]');
    save.disabled = false;
    save.classList.remove('button-disabled');
    categoryEditor.addEventListener('input', (event) => {
      event.target.setCustomValidity?.('');
      feedback.textContent = '';
      if (event.target === fields.slug) slugEdited = fields.slug.value !== '';
      if (event.target === name && !slugEdited) fields.slug.value = slugify(name.value);
      updatePreview();
    });
    fields.slug.addEventListener('blur', () => {
      fields.slug.value = slugify(fields.slug.value);
      updatePreview();
    });
    categoryEditor.addEventListener('submit', (event) => {
      event.preventDefault();
      const value = name.value.trim();
      const slug = fields.slug.value.trim();
      const others = [...categories.values()].filter((category) => category.id !== id);
      const duplicate = others.some((category) => [category.name, ...(category.previous_names || [])]
        .some((existing) => existing.toLowerCase() === value.toLowerCase()));
      if (!value || duplicate) {
        name.setCustomValidity(!value ? 'Category name is missing. Enter a name.' : 'This category name is already in use. Enter a different name.');
        name.reportValidity();
        return;
      }
      const slugTaken = others.some((category) => category.slug === slug);
      if (!slugPattern.test(slug) || slugTaken) {
        fields.slug.setCustomValidity(slugTaken
          ? 'This URL slug is already in use. Enter a different slug.'
          : 'URL slug can only use lowercase letters, numbers and single hyphens.');
        fields.slug.reportValidity();
        return;
      }
      if (photo.isBusy()) {
        feedback.textContent = 'The photo is still loading. Try again in a moment.';
        return;
      }
      const image = photo.getValues()[0] || '';
      const imageAlt = fields.image_alt.value.trim();
      if (image && !imageAlt) {
        fields.image_alt.setCustomValidity('Photo description is missing. Describe what the photo shows.');
        fields.image_alt.reportValidity();
        return;
      }
      const categoryId = id || `CAT-NEW-${crypto.randomUUID()}`;
      const previousNames = new Set(originalCategory?.previous_names || []);
      if (originalCategory && originalCategory.name !== value) previousNames.add(originalCategory.name);
      const updated = {
        ...categoryChanges,
        [categoryId]: {
          id: categoryId,
          name: value,
          slug,
          description: fields.description.value.trim(),
          image,
          image_alt: image ? imageAlt : '',
          meta_title: fields.meta_title.value.trim(),
          meta_description: fields.meta_description.value.trim(),
          noindex: fields.noindex.checked,
          previous_names: [...previousNames],
        },
      };
      try {
        sessionStorage.setItem(categoryStorageKey, JSON.stringify(updated));
        window.location.assign(config.categories_url);
      } catch {
        feedback.textContent = 'The category could not be saved. Try again.';
      }
    });
  }
  const money = (price) => `RM ${Number(price).toFixed(2)}`;
  const field = (root, name) => root.querySelector(`.js-component-products-${name}`);
  const stockNumber = (value) => /^\d+$/.test(String(value ?? '')) && Number.isSafeInteger(Number(value))
    ? Number(value) : null;
  const needsRestock = (product) => product.status !== 'Archived' && stockNumber(product.stock) !== null &&
    stockNumber(product.restock_threshold) !== null && Number(product.stock) <= Number(product.restock_threshold);
  const restockLabel = (product) => stockNumber(product.stock) === null || stockNumber(product.restock_threshold) === null
    ? 'Not Set' : product.status === 'Archived' ? 'Archived' : needsRestock(product)
      ? (Number(product.stock) === 0 ? 'Out of Stock' : 'Restock Needed') : 'In Stock';
  const filters = document.querySelector('.js-component-products-filters');
  if (filters) {
    const body = document.querySelector('.js-component-products-list');
    const template = body.querySelector('.js-component-products-row');
    catalogue.forEach((product) => {
      let row = [...body.querySelectorAll('.js-component-products-row')].find((item) => item.dataset.productId === product.id);
      if (!row) {
        row = template.cloneNode(true);
        row.dataset.productId = product.id;
        body.append(row);
      }
      const group = product.status !== 'Active' ? 'inactive' : needsRestock(product) ? 'restock' : 'active';
      body.querySelector(`[data-group="${group}"] .js-component-products-group-list`).append(row);
      ['name', 'sku', 'category', 'requirement', 'status'].forEach((name) => {
        field(row, name).textContent = product[name];
      });
      field(row, 'status').hidden = product.status === 'Active';
      field(row, 'requirement').hidden = product.requirement !== 'Prescription Required';
      field(row, 'stock').textContent = stockNumber(product.stock) === null ? 'Not Set' : `${product.stock} units`;
      field(row, 'restock').textContent = restockLabel(product);
      field(row, 'restock').hidden = !needsRestock(product);
      field(row, 'price').textContent = money(product.price);
      const image = field(row, 'image');
      const imageUrl = product.images?.[0] || product.image;
      image.hidden = !imageUrl;
      if (imageUrl) image.src = imageUrl;
      else image.removeAttribute('src');
      const detailUrl = `${config.detail_url}?id=${encodeURIComponent(product.id)}`;
      const editUrl = `${config.edit_url}?id=${encodeURIComponent(product.id)}`;
      row.querySelector('.product-link').href = detailUrl;
      const editAction = field(row, 'edit');
      editAction.href = editUrl;
      editAction.setAttribute('aria-label', `Edit Product: ${product.name}`);
      const stockAction = field(row, 'update-stock');
      stockAction.href = `${editUrl}#product-stock`;
      stockAction.hidden = !needsRestock(product) || product.status !== 'Active';
      stockAction.setAttribute('aria-label', `Update Stock: ${product.name}`);
      const restock = group === 'restock';
      field(row, 'mobile-stock').hidden = !restock;
      const mobileStockAction = field(row, 'mobile-update-stock');
      mobileStockAction.href = `${editUrl}#product-stock`;
      mobileStockAction.setAttribute('aria-label', `Update Stock: ${product.name}`);
      field(row, 'more').hidden = !restock;
      field(row, 'links').hidden = restock;
      [field(row, 'more'), field(row, 'links')].forEach((root) => {
        const actions = root.querySelectorAll('a');
        actions[0].href = detailUrl;
        actions[1].href = editUrl;
        actions[0].setAttribute('aria-label', `View Product: ${product.name}`);
        actions[1].setAttribute('aria-label', `Edit Product: ${product.name}`);
      });
      const trigger = field(row, 'more').querySelector('.js-component-dropdown-trigger');
      const menu = field(row, 'more').querySelector('.js-component-dropdown-menu');
      menu.id = `product-actions-${product.id}`;
      trigger.setAttribute('aria-controls', menu.id);
      trigger.setAttribute('aria-label', `More Actions: ${product.name}`);
    });
    const categoryFilter = document.querySelector('.js-component-products-category-filter');
    const categoryTemplate = categoryFilter.querySelector('.dropdown-option').cloneNode(true);
    const categoryOptions = categoryFilter.querySelector('.dropdown-group');
    categoryOptions.replaceChildren();
    categories.forEach((category) => {
      const option = categoryTemplate.cloneNode(true);
      const input = option.querySelector('input');
      input.id = `products-category-${category.id}`;
      input.value = category.name;
      option.querySelector('label').htmlFor = input.id;
      option.querySelector('.choice-text').textContent = category.name;
      option.querySelector('.dropdown-count').textContent = [...catalogue.values()]
        .filter((product) => product.category_id === category.id).length;
      categoryOptions.append(option);
    });
    const prescriptionOnly = document.querySelector('.js-component-products-prescription-only');
    const filterRows = () => {
      const values = new FormData(filters);
      const query = values.get('query').trim().toLowerCase();
      const statuses = values.getAll('statuses[]');
      const selectedCategories = values.getAll('categories[]');
      categoryFilter.querySelector('.button-label').textContent = selectedCategories.length
        ? selectedCategories.slice(0, 3).join(', ') + (selectedCategories.length > 3 ? ` +${selectedCategories.length - 3}` : '')
        : 'All Categories';
      let visible = 0;
      body.querySelectorAll('.js-component-products-row').forEach((row) => {
        const product = catalogue.get(row.dataset.productId);
        const matches = (!prescriptionOnly.checked || product.requirement === 'Prescription Required') && `${product.name} ${product.sku}`.toLowerCase().includes(query) &&
          (!selectedCategories.length || selectedCategories.includes(product.category)) &&
          (!statuses.length || statuses.includes(product.status));
        row.hidden = !matches;
        if (matches) visible += 1;
      });
      body.querySelectorAll('.js-component-products-group').forEach((group) => {
        const count = [...group.querySelectorAll('.js-component-products-row')].filter((row) => !row.hidden).length;
        group.hidden = count === 0;
        if (query && count > 0) {
          group.querySelector('.js-component-products-group-toggle').setAttribute('aria-expanded', 'true');
          group.querySelector('.js-component-products-group-list').hidden = false;
        }
        group.querySelector('.js-component-products-group-count').textContent = `${count} ${count === 1 ? 'product' : 'products'}`;
      });
      document.querySelector('.js-component-products-empty').hidden = visible > 0;
    };
    prescriptionOnly.addEventListener('change', filterRows);
    filters.addEventListener('submit', (event) => { event.preventDefault(); filterRows(); });
    filters.addEventListener('input', filterRows);
    filters.addEventListener('change', filterRows);
    filters.addEventListener('reset', () => setTimeout(filterRows, 0));
    filterRows();
  }

  const detail = document.querySelector('.js-component-products-detail');
  if (detail && detail.dataset.productId) {
    const product = catalogue.get(detail.dataset.productId);
    if (product) {
      field(detail, 'name').textContent = product.name;
      const detailAmount = (amount) => {
        const text = String(amount ?? '');
        if (!/^\d+(?:\.\d{1,2})?$/.test(text)) return null;
        const number = Number(text);
        return Number.isFinite(number) && number * 100 <= Number.MAX_SAFE_INTEGER ? number : null;
      };
      // Single-product details omit collection fields and unused inherited timing values.
      detail.querySelectorAll('[data-product-field]').forEach((item) => {
        const key = item.dataset.productField;
        item.hidden = (product.product_type !== 'combo' && ['combo_price', 'combo_contents', 'product_type'].includes(key)) ||
          (product.follow_up !== 'Product-specific Interval' && ['interval', 'reminder'].includes(key));
      });
      detail.querySelectorAll('.js-component-products-value').forEach((value) => {
        const key = value.dataset.field;
        if (key === 'base_price') {
          value.previousElementSibling.textContent = product.product_type === 'combo'
            ? 'Combined Price' : 'Regular Price';
        }
        if (['price', 'base_price', 'combo_price', 'discount_price'].includes(key)) {
          const amount = key === 'base_price' ? (product.base_price ?? product.price) : product[key];
          const number = detailAmount(amount);
          value.textContent = number === null ? 'Not Set' : money(number);
          return;
        }
        if (key === 'stock_status') {
          value.textContent = restockLabel(product);
          value.classList.toggle('color-negative', needsRestock(product));
          return;
        }
        if (key === 'requirement' && product.requirement === 'Basic') {
          value.textContent = 'Not Required';
          return;
        }
        if (key === 'saving') {
          const regular = detailAmount(product.product_type === 'combo'
            ? product.combo_price : product.base_price ?? product.price);
          const final = detailAmount(product.price);
          const saving = regular !== null && final !== null ? Math.round((regular - final) * 100) / 100 : null;
          value.textContent = saving === null ? 'Not Set' : regular > 0 && saving > 0
            ? `${money(saving)} · ${Number((saving / regular * 100).toFixed(1))}%` : 'No Discount';
          return;
        }
        if (['stock', 'restock_threshold', 'interval', 'reminder'].includes(key)) {
          const amount = product[key];
          const unit = ['stock', 'restock_threshold'].includes(key) ? 'units'
            : key === 'reminder' ? 'days before follow-up' : 'days';
          value.textContent = amount === '' || amount === undefined || amount === null
            ? 'Not Set' : `${amount} ${unit}`;
          return;
        }
        if (key === 'description') {
          const paragraphs = String(product.description || '').split(/\n\s*\n/).filter((text) => text.trim());
          const content = document.createElement('div');
          content.className = 'product-description grid gap-4';
          paragraphs.forEach((text) => {
            const paragraph = document.createElement('p');
            paragraph.className = 'product-paragraph';
            paragraph.textContent = text;
            content.append(paragraph);
          });
          if (paragraphs.length) value.replaceChildren(content);
          else value.textContent = 'Not Set';
          return;
        }
        if (['benefits', 'usage', 'precautions'].includes(key)) {
          const lines = (Array.isArray(product[key]) ? product[key] : String(product[key] || '').split('\n'))
            .filter((line) => line.trim());
          if (!lines.length) {
            value.textContent = 'Not Set';
            return;
          }
          const list = document.createElement('ul');
          list.className = 'product-list grid gap-2 pl-5 list-[square]';
          lines.forEach((line) => {
            const item = document.createElement('li');
            item.className = 'product-item';
            item.textContent = line;
            list.append(item);
          });
          value.replaceChildren(list);
          return;
        }
        if (key === 'faqs') {
          value.replaceChildren();
          if (!product.faqs?.length) {
            value.textContent = '—';
            return;
          }
          const list = document.createElement('dl');
          list.className = 'product-faqs grid gap-5';
          product.faqs.forEach((faq) => {
            const item = document.createElement('div');
            item.className = 'product-faq min-w-0';
            const question = document.createElement('dt');
            question.className = 'product-question font-medium color-strong';
            question.textContent = faq.question;
            const answer = document.createElement('dd');
            answer.className = 'product-answer mt-1';
            answer.textContent = faq.answer;
            item.append(question, answer);
            list.append(item);
          });
          value.append(list);
          return;
        }
        if (key === 'product_type') {
          value.textContent = product.product_type === 'combo' ? 'Multi-product Combo' : 'Single Product';
          return;
        }
        if (key === 'combo_contents') {
          value.textContent = product.product_type === 'combo'
            ? (product.combo_items || []).map((item) => {
              const included = catalogue.get(item.product_id);
              return `${item.quantity} × ${included ? `${included.name} (${included.sku})` : item.product_id}`;
            }).join('\n') : '—';
          return;
        }
        value.textContent = product[key] === '' || product[key] === undefined || product[key] === null
          ? 'Not Set' : String(product[key]);
        value.classList.toggle('whitespace-pre-line', key === 'ingredients');
      });
      const gallery = field(detail, 'gallery');
      const images = (product.images || [product.image]).filter(Boolean).slice(0, 4);
      [...gallery.children].forEach((slot, index) => {
        slot.querySelector('img')?.remove();
        const placeholder = slot.querySelector('.product-placeholder');
        placeholder.hidden = false;
        slot.disabled = true;
        if (!images[index]) return;
        const image = document.createElement('img');
        image.alt = `${product.name} — Image ${index + 1}`;
        image.width = 160;
        image.height = 160;
        image.className = 'product-image relative size-full bg-white object-contain';
        image.addEventListener('load', () => {
          placeholder.hidden = true;
          slot.disabled = false;
        });
        image.addEventListener('error', () => {
          image.remove();
          placeholder.hidden = false;
          slot.disabled = true;
        });
        image.src = images[index];
        slot.append(image);
      });
      gallery.addEventListener('click', (event) => {
        const trigger = event.target.closest('.js-component-modal-open');
        const image = trigger?.querySelector('img');
        if (!image) return;
        const preview = field(detail, 'preview');
        preview.src = image.src;
        preview.alt = image.alt;
      });
    } else {
      field(detail, 'name').textContent = 'Product Not Found';
      detail.querySelector('.section-content')?.remove();
      field(detail, 'gallery')?.remove();
    }
  }

  const editor = document.querySelector('.js-component-products-editor');
  if (!editor) return;
  const original = catalogue.get(editor.dataset.productId);
  const feedback = field(editor, 'feedback');
  let images = [...(original?.images || (original?.image ? [original.image] : []))];
  let readingImages = false;
  if (original) {
    Object.entries(original).forEach(([key, value]) => {
      const control = editor.elements.namedItem(key);
      if (key === 'product_type' && control) {
        control.checked = value === 'combo';
        return;
      }
      if (key === 'requirement' && control) {
        control.checked = value === 'Prescription Required';
        return;
      }
      if (control) control.value = key === 'benefits' && Array.isArray(value) ? value.join('\n') : value;
    });
  }
  // Inventory hooks show the current restock decision without changing patient follow-up timing.
  const syncInventory = () => {
    const stock = editor.elements.namedItem('stock').value;
    const threshold = editor.elements.namedItem('restock_threshold').value;
    field(editor, 'restock-notice').textContent = stockNumber(stock) === null || stockNumber(threshold) === null
      ? 'Enter a stock quantity and restock threshold to see stock status.'
      : `${stock} units available · Restock at ${threshold} units or fewer. ${restockLabel({
        stock, restock_threshold: threshold, status: editor.elements.namedItem('status').value,
      })}.`;
  };
  editor.addEventListener('input', syncInventory);
  editor.addEventListener('change', syncInventory);
  syncInventory();
  // Predefined choices preserve the existing canonical precautions text field.
  const precautionChoices = [...editor.querySelectorAll('input[name="precaution_options"]')];
  const precautions = String(original?.precautions || '').split('\n').map((value) => value.trim()).filter(Boolean);
  precautionChoices.forEach((control) => { control.checked = precautions.includes(control.value); });
  editor.elements.namedItem('precautions_custom').value = precautions
    .filter((value) => !precautionChoices.some((control) => control.value === value)).join('\n');
  // Combo rows reuse field markup; item IDs link catalogue products without duplicating their data.
  const productType = editor.elements.namedItem('product_type');
  const productCategory = editor.elements.namedItem('category');
  const collectionCategory = categories.get('CAT-005');
  let previousCategory = productCategory.value;
  const productFormat = editor.elements.namedItem('format');
  const productSize = editor.elements.namedItem('size');
  let singleFormat = original?.product_type === 'combo' ? 'Liquid' : productFormat.value;
  let singleSize = original?.product_type === 'combo' ? '' : productSize.value;
  let previousProductType = productType.checked ? 'combo' : 'single';
  // Sets derive their format and contents from included products; single values survive type changes.
  const syncSetContents = () => {
    if (!productType.checked) return;
    productFormat.value = 'Set';
    productSize.value = [...items.children].map((row) => {
      const product = catalogue.get(row.querySelector('select').value);
      const quantity = row.querySelector('select[id^="combo-quantity"]').value;
      if (!product || !/^[1-9]\d*$/.test(quantity)) return '';
      return `${product.name}${product.size ? ` ${product.size}` : ''} × ${quantity}`;
    }).filter(Boolean).join(' · ');
  };
  // Collections use their dedicated category; keep the previous selection when switching back.
  const combo = field(editor, 'combo');
  const items = field(editor, 'items');
  const itemTemplate = field(editor, 'item-template');
  let itemIndex = 0;
  let syncPricing = () => {};
  // Two distinct products are the minimum; repeated units belong in Quantity.
  const syncComboRows = () => {
    const rows = [...items.children];
    const enabled = productType.checked;
    let units = 0;
    const selected = new Set(rows.map((row) => row.querySelector('select').value).filter(Boolean));
    rows.forEach((row, index) => {
      const select = row.querySelector('select');
      const quantity = row.querySelector('select[id^="combo-quantity"]');
      row.querySelector(`label[for="${select.id}"]`).firstChild.textContent = `Product ${index + 1} `;
      [...select.options].forEach((option) => {
        option.disabled = Boolean(option.value && option.value !== select.value && selected.has(option.value));
      });
      const remove = row.querySelector('button');
      remove.disabled = !enabled || rows.length <= 2;
      remove.classList.toggle('button-disabled', remove.disabled);
      remove.setAttribute('aria-label', `Remove Product ${index + 1}`);
      if (select.value && /^[1-9]\d*$/.test(quantity.value) && Number.isSafeInteger(Number(quantity.value)) && Number(quantity.value) <= 10) {
        units += Number(quantity.value);
      }
    });
    syncSetContents();
    field(editor, 'combo-summary').textContent = `${selected.size} products selected · ${units} units.`;
  };
  const addItem = (item = {}) => {
    const row = itemTemplate.content.firstElementChild.cloneNode(true);
    const select = row.querySelector('select');
    const quantity = row.querySelector('select[id^="combo-quantity"]');
    itemIndex += 1;
    row.querySelector('.js-component-tooltip-content').id = `combo-remove-tooltip-${itemIndex}`;
    [select, quantity].forEach((control) => {
      const oldId = control.id;
      control.id = `${oldId}-${itemIndex}`;
      row.querySelector(`label[for="${oldId}"]`).htmlFor = control.id;
      const help = row.querySelector(`#${oldId}-help`);
      if (help) {
        help.id = `${control.id}-help`;
        control.setAttribute('aria-describedby', help.id);
      }
      control.required = true;
    });
    catalogue.forEach((product) => {
      if (product.id === editor.dataset.productId || product.product_type === 'combo' ||
        (product.status === 'Archived' && product.id !== item.product_id)) return;
      select.add(new Option(`${product.name} (${product.sku})`, product.id));
    });
    select.value = item.product_id || '';
    quantity.value = item.quantity ?? 1;
    row.querySelector('button').addEventListener('click', () => {
      if (items.children.length <= 2) return;
      const next = row.nextElementSibling?.querySelector('select') ||
        row.previousElementSibling?.querySelector('select') || field(editor, 'add-item');
      row.remove();
      syncComboRows();
      syncPricing();
      next.focus();
    });
    items.append(row);
    document.dispatchEvent(new CustomEvent('overlays:init', { detail: row }));
    syncComboRows();
  };
  const syncCombo = () => {
    const enabled = productType.checked;
    combo.hidden = !enabled;
    if (enabled && previousProductType !== 'combo') {
      singleFormat = productFormat.value;
      singleSize = productSize.value;
    } else if (!enabled && previousProductType === 'combo') {
      productFormat.value = singleFormat;
      productSize.value = singleSize;
    }
    previousProductType = productType.checked ? 'combo' : 'single';
    productFormat.disabled = enabled;
    productSize.readOnly = enabled;
    productSize.required = !enabled;
    if (enabled && collectionCategory) {
      if (!productCategory.disabled) previousCategory = productCategory.value;
      productCategory.value = collectionCategory.name;
    } else if (productCategory.disabled) {
      productCategory.value = previousCategory;
    }
    productCategory.disabled = enabled;
    while (enabled && items.children.length < 2) addItem();
    items.querySelectorAll('input, select, button').forEach((control) => {
      control.disabled = !enabled;
      control.setCustomValidity?.('');
    });
    productType.setCustomValidity('');
    syncComboRows();
    syncPricing();
  };
  (original?.combo_items || []).forEach(addItem);
  productType.addEventListener('change', syncCombo);
  field(editor, 'add-item').addEventListener('click', () => {
    addItem();
    items.lastElementChild.querySelector('select').focus();
  });
  items.addEventListener('change', syncComboRows);
  items.addEventListener('input', syncComboRows);
  syncCombo();
  // Prices are calculated in integer sen; `price` remains the final selling price for existing consumers.
  // Hooks: .js-component-products-{price-breakdown,price-items,savings,final-price,price-status}.
  const basePrice = editor.elements.namedItem('base_price');
  const discountPrice = editor.elements.namedItem('discount_price');
  const discountPercent = editor.elements.namedItem('discount_percent');
  const comboPrice = editor.elements.namedItem('combo_price');
  const toSen = (value) => {
    const text = String(value).trim();
    if (!/^\d+(\.\d{1,2})?$/.test(text)) return null;
    const [whole, fraction = ''] = text.split('.');
    const amount = Number(whole) * 100 + Number(fraction.padEnd(2, '0'));
    return Number.isSafeInteger(amount) ? amount : null;
  };
  basePrice.value = original?.base_price ?? original?.price ?? '';
  discountPrice.value = original?.discount_price ?? '';
  comboPrice.value = original?.combo_price ?? (original?.product_type === 'combo' ? original.price : '');
  comboPrice.inputMode = 'decimal';
  basePrice.inputMode = 'decimal';
  discountPrice.inputMode = 'decimal';
  let singlePrice = basePrice.value;
  let wasCombo = false;
  syncPricing = () => {
    const isCombo = productType.checked;
    if (isCombo && !wasCombo) singlePrice = basePrice.value;
    if (!isCombo && wasCombo) basePrice.value = singlePrice;
    wasCombo = isCombo;
    basePrice.readOnly = isCombo;
    basePrice.required = !isCombo;
    field(editor, 'base-price-field').hidden = isCombo;
    editor.querySelector('label[for="product-base-price"]').firstChild.textContent =
      isCombo ? 'Combined Price (RM) ' : 'Regular Price (RM) ';
    field(editor, 'combo-price-field').hidden = !isCombo;
    comboPrice.disabled = !isCombo;
    comboPrice.required = isCombo;
    field(editor, 'price-breakdown').hidden = !isCombo;
    const lines = field(editor, 'price-items');
    lines.replaceChildren();
    let regular = toSen(basePrice.value);
    if (isCombo) {
      regular = 0;
      const selected = new Set();
      let complete = items.children.length >= 2;
      for (const row of items.children) {
        const product = catalogue.get(row.querySelector('select').value);
        const quantity = row.querySelector('select[id^="combo-quantity"]').value;
        const unit = product ? toSen(product.price) : null;
        if (!product || unit === null || !/^[1-9]\d*$/.test(quantity) ||
          !Number.isSafeInteger(Number(quantity)) || selected.has(product.id)) {
          complete = false;
          continue;
        }
        selected.add(product.id);
        const subtotal = unit * Number(quantity);
        if (!Number.isSafeInteger(subtotal) || !Number.isSafeInteger(regular + subtotal)) {
          complete = false;
          continue;
        }
        regular += subtotal;
        const line = document.createElement('li');
        line.className = 'product-price-item flex flex-wrap justify-between gap-2 py-3 text-sm first:pt-0 last:pb-0';
        const label = document.createElement('span');
        label.className = 'product-price-label min-w-0 wrap-anywhere';
        label.textContent = `${product.name} × ${quantity} (${money(unit / 100)} each)`;
        const amount = document.createElement('span');
        amount.className = 'product-price-value tabular-nums';
        amount.textContent = money(subtotal / 100);
        line.append(label, amount);
        lines.append(line);
      }
      if (!complete) regular = null;
      basePrice.value = regular === null ? '' : (regular / 100).toFixed(2);
    }
    document.getElementById('product-combo-price-after').textContent = regular === null ? '—' : money(regular / 100);
    const selling = isCombo ? toSen(comboPrice.value) : regular;
    field(editor, 'combined-saving').textContent = regular !== null && selling !== null
      ? `Combined Saving: ${money(Math.max(0, regular - selling) / 100)}` : 'Combined Saving: —';
    const automaticDiscount = discountPercent.value !== '';
    discountPrice.readOnly = automaticDiscount;
    if (automaticDiscount) {
      const rate = Number(discountPercent.value);
      // Integer arithmetic floors the discounted price to whole Ringgit without floating-point drift.
      discountPrice.value = rate === 0 || selling === null ? ''
        : Number(BigInt(selling) * BigInt(100 - rate) / 10000n).toFixed(2);
      discountPrice.setCustomValidity('');
    }
    const discounted = discountPrice.value.trim() !== '';
    const discount = discounted ? toSen(discountPrice.value) : null;
    const validDiscount = !discounted || (discount !== null && selling !== null && discount < selling);
    const final = regular !== null && selling !== null && validDiscount ? (discounted ? discount : selling) : null;
    field(editor, 'final-price').textContent = final === null ? 'Not Set' : money(final / 100);
    field(editor, 'savings').textContent = final === null ? 'Not Set' : money((selling - final) / 100);
    ['final-price', 'savings'].forEach((name) => {
      field(editor, name).classList.toggle('font-normal', final === null);
      field(editor, name).classList.toggle('color-muted', final === null);
    });
    field(editor, 'price-empty').hidden = lines.children.length > 0;
    field(editor, 'price-empty').textContent = items.querySelector('select')?.value ||
      [...items.children].some((row) => row.querySelector('select').value)
      ? 'No prices available. Check the selected products and quantities above.'
      : 'No products selected. Choose products above to see their prices.';
    field(editor, 'price-message').textContent = regular === null
      ? (isCombo ? 'Collection is incomplete. Select at least 2 different products with valid prices and quantities.' : 'Regular price is missing or invalid. Enter an amount.')
      : selling === null ? 'Collection price is missing or invalid. Enter an amount.'
        : !validDiscount ? 'Discount price is invalid. Enter a price below the regular or collection price.' : '';
    field(editor, 'price-status').hidden = !field(editor, 'price-message').textContent;
  };
  editor.addEventListener('input', syncPricing);
  editor.addEventListener('change', syncPricing);
  syncPricing();
  const saveButton = editor.querySelector('button[type="submit"]');
  saveButton.disabled = true;
  const syncTiming = () => {
    const custom = editor.elements.namedItem('follow_up').value === 'Product-specific Interval';
    ['interval', 'reminder'].forEach((name) => {
      const control = editor.elements.namedItem(name);
      control.required = custom;
      control.disabled = !custom;
      control.setCustomValidity('');
    });
  };
  editor.elements.namedItem('follow_up').addEventListener('change', syncTiming);
  syncTiming();
  // Completion tracks current required/conditional inputs without showing validation popups.
  // Hooks: .js-component-products-{progress,completion-count,completion-help}.
  const updateProgress = () => {
    const value = (name) => String(editor.elements.namedItem(name)?.value || '').trim();
    const isCombo = productType.checked;
    const regular = toSen(value('base_price'));
    const selling = isCombo ? toSen(value('combo_price')) : regular;
    const sku = value('sku');
    const checks = [
      ['Product Name', Boolean(value('name'))],
      ['SKU', /^[A-Za-z0-9-]+$/.test(sku) && ![...catalogue.values()].some((product) =>
        product.id !== editor.dataset.productId && product.sku.toLowerCase() === sku.toLowerCase())],
      ['Category', [...categories.values()].some((category) => category.name === value('category'))],
      ['Description', Boolean(value('description'))],
      ['Short Description', value('short_description').length <= 160],
      ['Size / Contents', isCombo || Boolean(value('size'))],
      [isCombo ? 'Collection Price' : 'Regular Price', selling !== null],
    ];
    ['stock', 'restock_threshold'].forEach((name) => {
      checks.push([name === 'stock' ? 'Stock Quantity' : 'Restock Threshold',
        value(name) === '' || stockNumber(value(name)) !== null]);
    });
    if (isCombo) {
      const selected = new Set();
      const validItems = [...items.children].every((row) => {
        const product = catalogue.get(row.querySelector('select').value);
        const quantity = row.querySelector('select[id^="combo-quantity"]').value;
        const valid = product && product.id !== editor.dataset.productId && product.product_type !== 'combo' &&
          !selected.has(product.id) && /^[1-9]\d*$/.test(quantity) && Number.isSafeInteger(Number(quantity)) && Number(quantity) <= 10;
        if (product) selected.add(product.id);
        return valid;
      });
      checks.push(['Collection Products', items.children.length >= 2 && validItems && regular !== null]);
    }
    if (value('discount_price')) {
      const discount = toSen(value('discount_price'));
      checks.push(['Discount Price', discount !== null && selling !== null && discount < selling]);
    }
    if (value('follow_up') === 'Product-specific Interval') {
      checks.push(['Follow-up Interval', /^[1-9]\d*$/.test(value('interval'))]);
      checks.push(['Reminder Lead Time', /^\d+$/.test(value('reminder')) &&
        /^[1-9]\d*$/.test(value('interval')) && Number(value('reminder')) <= Number(value('interval'))]);
    }
    const missing = checks.filter(([, complete]) => !complete).map(([label]) => label);
    const completed = checks.length - missing.length;
    const percent = Math.floor(completed / checks.length * 100);
    field(editor, 'progress').value = percent;
    field(editor, 'progress').textContent = `${percent}%`;
    field(editor, 'completion-count').textContent = `${completed} of ${checks.length} complete · ${percent}%`;
    field(editor, 'completion-help').textContent = readingImages ? 'Images are loading. Wait before saving.'
      : missing.length ? `Complete or correct: ${missing.join(', ')}.` : 'Required information is complete.';
    saveButton.disabled = missing.length > 0 || readingImages;
    saveButton.classList.toggle('button-disabled', saveButton.disabled);
  };
  editor.addEventListener('input', updateProgress);
  editor.addEventListener('change', updateProgress);
  // Add/remove actions change conditional requirements without firing input/change events.
  editor.addEventListener('click', () => queueMicrotask(() => { syncPricing(); updateProgress(); }));
  updateProgress();
  const uploaderRoot = editor.querySelector('.js-component-file-upload-root');
  const uploader = window.FileUpload.init(uploaderRoot);
  uploader.setValues(images);
  uploaderRoot.addEventListener('file-upload:change', () => {
    images = uploader.getValues();
    readingImages = uploader.isBusy();
    updateProgress();
  });
  editor.addEventListener('input', (event) => {
    event.target.setCustomValidity?.('');
    feedback.textContent = '';
  });
  editor.addEventListener('submit', (event) => {
    event.preventDefault();
    updateProgress();
    if (saveButton.disabled) return;
    syncPricing();
    const data = Object.fromEntries(new FormData(editor));
    delete data['product_images[]'];
    data.product_type = productType.checked ? 'combo' : 'single';
    data.requirement = editor.elements.namedItem('requirement').checked ? 'Prescription Required' : 'Basic';
    data.category = productCategory.value;
    data.format = productFormat.value;
    Object.keys(data).forEach((key) => { if (typeof data[key] === 'string') data[key] = data[key].trim(); });
    const reject = (name, message) => {
      const control = editor.elements.namedItem(name);
      control.setCustomValidity(message);
      control.reportValidity();
    };
    if (!data.name) return reject('name', 'Product name is missing. Enter a name.');
    if (!data.description) return reject('description', 'Description is missing. Add a description.');
    if (data.short_description.length > 160) {
      return reject('short_description', 'Short description is too long. Use up to 160 characters.');
    }
    if (data.product_type !== 'combo' && !data.size) return reject('size', 'Size or contents are missing. Enter the pack size.');
    if (!/^[A-Za-z0-9-]+$/.test(data.sku)) return reject('sku', 'SKU is invalid. Use letters, numbers and hyphens.');
    if ([...catalogue.values()].some((product) => product.id !== editor.dataset.productId &&
      product.sku.toLowerCase() === data.sku.toLowerCase())) return reject('sku', 'This SKU is already in use. Enter a different SKU.');
    const regular = toSen(data.base_price);
    if (regular === null) {
      if (data.product_type === 'combo') {
        return reject('product_type', 'Collection is incomplete. Select two different products and check quantities.');
      }
      return reject('base_price', 'Regular price is invalid. Use an amount with up to two decimal places.');
    }
    const selling = data.product_type === 'combo' ? toSen(data.combo_price) : regular;
    if (selling === null) return reject('combo_price', 'Collection price is invalid. Use an amount with up to two decimal places.');
    data.combo_price = data.product_type === 'combo' ? selling / 100 : '';
    const discount = data.discount_price ? toSen(data.discount_price) : null;
    if (data.discount_price && (discount === null || discount >= selling)) {
      return reject('discount_price', 'Discount price is invalid. Use up to two decimals and a value below the regular or collection price.');
    }
    data.base_price = regular / 100;
    data.discount_price = discount === null ? '' : discount / 100;
    data.price = (discount === null ? selling : discount) / 100;
    if (data.follow_up === 'Product-specific Interval') {
      if (!/^[1-9]\d*$/.test(data.interval)) return reject('interval', 'Follow-up interval is invalid. Enter whole days of 1 or more.');
      if (!/^\d+$/.test(data.reminder) || Number(data.reminder) > Number(data.interval)) {
        return reject('reminder', 'Reminder lead time is invalid. Enter whole days from 0 to the follow-up interval.');
      }
    } else {
      data.interval = '';
      data.reminder = '';
    }
    data.precautions = [...new Set([
      ...precautionChoices.filter((control) => control.checked).map((control) => control.value),
      ...data.precautions_custom.split('\n').map((value) => value.trim()).filter(Boolean),
    ])].join('\n');
    delete data.precaution_options;
    delete data.precautions_custom;
    data.benefits = data.benefits.split('\n').map((benefit) => benefit.trim()).filter(Boolean);
    const selectedCategory = [...categories.values()].find((category) => category.name === data.category);
    if (!selectedCategory) return reject('category', 'Category is unavailable. Select another category.');
    data.category_id = selectedCategory.id;
    data.combo_items = [];
    if (data.product_type === 'combo') {
      if (items.children.length < 2) return reject('product_type', 'Collection needs two different products. Add another product.');
      const selected = new Set();
      for (const row of items.children) {
        const select = row.querySelector('select');
        const quantity = row.querySelector('select[id^="combo-quantity"]');
        const product = catalogue.get(select.value);
        const itemError = !product || product.id === editor.dataset.productId || product.product_type === 'combo'
          ? 'Product is unavailable for this collection. Select a single product.'
          : selected.has(product.id) ? 'Product is already included. Update its quantity.' : '';
        if (itemError) {
          select.setCustomValidity(itemError);
          select.reportValidity();
          return;
        }
        if (!/^[1-9]\d*$/.test(quantity.value) || !Number.isSafeInteger(Number(quantity.value)) || Number(quantity.value) > 10) {
          quantity.setCustomValidity('Quantity is invalid. Select a quantity from 1 to 10.');
          quantity.reportValidity();
          return;
        }
        selected.add(product.id);
        data.combo_items.push({ product_id: product.id, quantity: Number(quantity.value) });
      }
    }
    const id = editor.dataset.productId || `NEW-${crypto.randomUUID()}`;
    const now = new Intl.DateTimeFormat('en-GB', { day: 'numeric', month: 'short', year: 'numeric', timeZone: 'Asia/Kuala_Lumpur' }).format(new Date());
    changes[id] = { ...original, ...data, id, images, image: images[0] || '', updated: now,
      created: original?.created || now, updated_by: 'Your Account' };
    try {
      sessionStorage.setItem(storageKey, JSON.stringify(changes));
      window.location.assign(`${config.detail_url}?id=${encodeURIComponent(id)}`);
    } catch {
      feedback.textContent = 'Changes could not be saved. Try again, or use fewer or smaller images.';
    }
  });
})();
