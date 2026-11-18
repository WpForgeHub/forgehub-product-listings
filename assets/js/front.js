/**
 * ForgeHub Product Listings - Live Search, Filter, Sort, Price Brackets, and View Switcher
 * Pure vanilla JavaScript. Zero CDN dependencies.
 */
(function() {
	'use strict';

	function initListings() {
		var wrappers = document.querySelectorAll('.wpfh-pl-wrapper');
		if (!wrappers.length) return;

		wrappers.forEach(function(wrapper) {
			setupListingInstance(wrapper);
		});
	}

	function setupListingInstance(wrapper) {
		var searchInputs   = wrapper.querySelectorAll('.wpfh-pl-search-input');
		var searchClears   = wrapper.querySelectorAll('.wpfh-pl-search-clear');
		var editionBtns    = wrapper.querySelectorAll('.wpfh-pl-edition-btn');
		var priceBtns      = wrapper.querySelectorAll('.wpfh-pl-price-btn');
		var sortSelect     = wrapper.querySelector('.wpfh-pl-sort-select');
		var viewBtns       = wrapper.querySelectorAll('.wpfh-pl-view-btn');
		var itemsContainer = wrapper.querySelector('.wpfh-pl-items');
		var emptyState     = wrapper.querySelector('.wpfh-pl-empty-state');
		var countLabel     = wrapper.querySelector('.wpfh-pl-count-label');
		var resetBtn       = wrapper.querySelector('.wpfh-pl-reset-filters');
		var catBtns        = wrapper.querySelectorAll('.wpfh-pl-cat-btn, .wpfh-pl-chip, .wpfh-pl-cat-box');

		if (!itemsContainer) return;

		var allCards = Array.from(itemsContainer.querySelectorAll('.wpfh-pl-card'));

		// State object
		var state = {
			search: '',
			category: 'all',
			edition: 'all',
			priceRange: 'all',
			sort: 'title-asc',
			view: wrapper.dataset.defaultView || 'grid'
		};

		// Parse initial state from URL search params if present
		function readUrlParams() {
			var params = new URLSearchParams(window.location.search);
			if (params.has('pl_search')) state.search = params.get('pl_search').trim();
			if (params.has('pl_cat')) state.category = params.get('pl_cat').trim();
			if (params.has('pl_edition')) state.edition = params.get('pl_edition').trim();
			if (params.has('pl_price')) state.priceRange = params.get('pl_price').trim();
			if (params.has('pl_sort')) state.sort = params.get('pl_sort').trim();
			if (params.has('pl_view')) state.view = params.get('pl_view').trim();
		}

		// Update URL params without page reload (for bookmarking / sharing)
		function updateUrlParams() {
			var params = new URLSearchParams(window.location.search);
			if (state.search) params.set('pl_search', state.search); else params.delete('pl_search');
			if (state.category && state.category !== 'all') params.set('pl_cat', state.category); else params.delete('pl_cat');
			if (state.edition && state.edition !== 'all') params.set('pl_edition', state.edition); else params.delete('pl_edition');
			if (state.priceRange && state.priceRange !== 'all') params.set('pl_price', state.priceRange); else params.delete('pl_price');
			if (state.sort && state.sort !== 'title-asc') params.set('pl_sort', state.sort); else params.delete('pl_sort');
			if (state.view && state.view !== (wrapper.dataset.defaultView || 'grid')) params.set('pl_view', state.view); else params.delete('pl_view');

			var newRelativePathQuery = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
			window.history.replaceState(null, '', newRelativePathQuery);
		}

		// Sync UI control states with current state
		function syncUi() {
			searchInputs.forEach(function(input) {
				input.value = state.search;
			});
			searchClears.forEach(function(clear) {
				clear.style.display = state.search ? 'block' : 'none';
			});

			editionBtns.forEach(function(btn) {
				var isActive = btn.dataset.edition === state.edition;
				btn.classList.toggle('is-active', isActive);
				btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			});

			priceBtns.forEach(function(btn) {
				var isActive = btn.dataset.priceRange === state.priceRange;
				btn.classList.toggle('is-active', isActive);
				btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			});

			if (sortSelect) {
				sortSelect.value = state.sort;
			}

			viewBtns.forEach(function(btn) {
				var isActive = btn.dataset.view === state.view;
				btn.classList.toggle('is-active', isActive);
				btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
			});

			itemsContainer.classList.toggle('wpfh-pl-view-grid', state.view === 'grid');
			itemsContainer.classList.toggle('wpfh-pl-view-list', state.view === 'list');

			catBtns.forEach(function(btn) {
				var isActive = btn.dataset.cat === state.category;
				btn.classList.toggle('is-active', isActive);
			});
		}

		// Filter and sort items
		function applyFilters() {
			var query = state.search.toLowerCase();
			var visibleCount = 0;

			// Filter cards
			allCards.forEach(function(card) {
				var title = (card.dataset.title || '').toLowerCase();
				var excerpt = (card.querySelector('.wpfh-pl-card-excerpt') ? card.querySelector('.wpfh-pl-card-excerpt').innerText : '').toLowerCase();
				var cats = (card.dataset.cats || '').split(' ');
				var edition = card.dataset.edition || 'all';
				var cardPrice = parseFloat(card.dataset.price) || 0;
				var minPrice = parseFloat(card.dataset.minPrice !== undefined ? card.dataset.minPrice : card.dataset.price) || 0;
				var maxPrice = parseFloat(card.dataset.maxPrice !== undefined ? card.dataset.maxPrice : card.dataset.price) || 0;

				var matchesSearch = !query || title.indexOf(query) !== -1 || excerpt.indexOf(query) !== -1;
				var matchesCat = state.category === 'all' || cats.indexOf(state.category) !== -1;
				var matchesEdition = state.edition === 'all' || edition === state.edition || edition === 'all';

				var matchesPrice = true;
				if (state.priceRange && state.priceRange !== 'all') {
					if (state.priceRange === 'free') {
						matchesPrice = (minPrice === 0);
					} else if (state.priceRange === 'under-20') {
						// Cheapest option (free included) is at or below $20.
						matchesPrice = (minPrice <= 20);
					} else if (state.priceRange === '20-50') {
						// Price span overlaps the 20-50 bracket.
						matchesPrice = (minPrice <= 50 && maxPrice >= 20);
					} else if (state.priceRange === '50-plus') {
						matchesPrice = (maxPrice >= 50);
					}
				}

				if (matchesSearch && matchesCat && matchesEdition && matchesPrice) {
					card.style.display = '';
					visibleCount++;
				} else {
					card.style.display = 'none';
				}
			});

			// Sort cards
			var sortedCards = allCards.slice().sort(function(a, b) {
				var titleA = a.dataset.title || '';
				var titleB = b.dataset.title || '';
				var priceA = parseFloat(a.dataset.price) || 0;
				var priceB = parseFloat(b.dataset.price) || 0;

				switch (state.sort) {
					case 'title-desc':
						return titleB.localeCompare(titleA);
					case 'price-asc':
						return priceA - priceB;
					case 'price-desc':
						return priceB - priceA;
					case 'title-asc':
					default:
						return titleA.localeCompare(titleB);
				}
			});

			sortedCards.forEach(function(card) {
				itemsContainer.appendChild(card);
			});

			// Empty state handling
			if (emptyState) {
				emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
			}

			// Status bar text
			if (countLabel) {
				countLabel.textContent = visibleCount + ' ' + (visibleCount === 1 ? 'plugin found' : 'plugins found');
			}

			// Reset filters button
			var isFiltered = state.search || state.category !== 'all' || state.edition !== 'all' || state.priceRange !== 'all';
			if (resetBtn) {
				resetBtn.style.display = isFiltered ? 'inline-block' : 'none';
			}

			updateUrlParams();
		}

		// Event: Live Search with debounce
		var debounceTimer;
		searchInputs.forEach(function(input) {
			input.addEventListener('input', function() {
				clearTimeout(debounceTimer);
				debounceTimer = setTimeout(function() {
					state.search = input.value.trim();
					searchInputs.forEach(function(other) {
						if (other !== input) other.value = state.search;
					});
					searchClears.forEach(function(clear) {
						clear.style.display = state.search ? 'block' : 'none';
					});
					applyFilters();
				}, 150);
			});
		});

		searchClears.forEach(function(clear) {
			clear.addEventListener('click', function() {
				state.search = '';
				searchInputs.forEach(function(input) {
					input.value = '';
				});
				searchClears.forEach(function(c) {
					c.style.display = 'none';
				});
				if (searchInputs.length) searchInputs[0].focus();
				applyFilters();
			});
		});

		// Event: Edition buttons
		editionBtns.forEach(function(btn) {
			btn.addEventListener('click', function() {
				state.edition = btn.dataset.edition || 'all';
				editionBtns.forEach(function(b) {
					b.classList.toggle('is-active', b === btn);
				});
				applyFilters();
			});
		});

		// Event: Price filter buttons
		priceBtns.forEach(function(btn) {
			btn.addEventListener('click', function() {
				state.priceRange = btn.dataset.priceRange || 'all';
				priceBtns.forEach(function(b) {
					b.classList.toggle('is-active', b === btn);
				});
				applyFilters();
			});
		});

		// Event: Sort select
		if (sortSelect) {
			sortSelect.addEventListener('change', function() {
				state.sort = sortSelect.value;
				applyFilters();
			});
		}

		// Event: View Toggle (Grid / List)
		viewBtns.forEach(function(btn) {
			btn.addEventListener('click', function() {
				state.view = btn.dataset.view || 'grid';
				viewBtns.forEach(function(b) {
					b.classList.toggle('is-active', b === btn);
				});
				itemsContainer.classList.toggle('wpfh-pl-view-grid', state.view === 'grid');
				itemsContainer.classList.toggle('wpfh-pl-view-list', state.view === 'list');
				updateUrlParams();
			});
		});

		// Event: Category selection (sidebar items, toolbar chips, category boxes)
		wrapper.addEventListener('click', function(e) {
			var catTarget = e.target.closest('.wpfh-pl-cat-btn, .wpfh-pl-chip, .wpfh-pl-cat-box');
			if (!catTarget) return;

			var chosenCat = catTarget.dataset.cat || 'all';
			state.category = chosenCat;

			catBtns.forEach(function(btn) {
				btn.classList.toggle('is-active', btn.dataset.cat === chosenCat);
			});

			applyFilters();
		});

		// Event: Reset filters button
		if (resetBtn) {
			resetBtn.addEventListener('click', function() {
				state.search = '';
				state.category = 'all';
				state.edition = 'all';
				state.priceRange = 'all';
				state.sort = 'title-asc';
				syncUi();
				applyFilters();
			});
		}

		// Initial setup
		readUrlParams();
		syncUi();
		applyFilters();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initListings);
	} else {
		initListings();
	}
})();
