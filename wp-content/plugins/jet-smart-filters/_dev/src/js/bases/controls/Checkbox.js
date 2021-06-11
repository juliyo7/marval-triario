import Filter from 'bases/Filter';

export default class CheckboxControl extends Filter {
	constructor($container, $filter, $checkboxes) {
		super($filter, $container);

		this.$checkboxes = $checkboxes || $filter.find(':checkbox');
		this.$checkboxesList = $container.find('.jet-checkboxes-list');
		this.$searchInput = $container.find('.jet-checkboxes-search input');
		this.$searchClear = $container.find('.jet-checkboxes-search__clear');
		this.$moreless = $container.find('.jet-checkboxes-moreless');
		this.$morelessToggle = this.$moreless.find('.jet-checkboxes-moreless__toggle');
		this.$dropdown = $container.find('.jet-checkboxes-dropdown');
		this.$dropdownLabel = this.$dropdown.find('.jet-checkboxes-dropdown__label');
		this.$dropdownBody = this.$dropdown.find('.jet-checkboxes-dropdown__body');
		this.relationalOperator = this.$filter.data('relational-operator');
		this.searchValue = '';
		this.moreState = false;
		this.dropdownState = false;
		this.inputNotEmptyClass = 'jet-input-not-empty';
		this.numberOfDisplayed = this.$filter.data('less-items-count');
		this.moreBtnText = this.$moreless.data('more-text');
		this.lessBtnText = this.$moreless.data('less-text');
		this.moreBtnClass = 'jet-more-btn';
		this.lessBtnClass = 'jet-less-btn';
		this.dropdownOpenClass = 'jet-dropdown-open';
		this.dropdownPlaceholderText = this.$dropdownLabel.html();

		this.processData();
		this.initEvent();
		this.initAdditionalEvent();
		this.hideNotDisplayedItems();
	}

	addFilterChangeEvent() {
		this.$checkboxes.on('change', () => {
			this.processData();
			this.emitFiterChange();
		});
	}

	initAdditionalEvent() {
		if (this.$searchInput.length)
			this.$searchInput.on('keyup', evt => {
				this.applySearch(evt.target.value);
			});

		if (this.$searchClear.length)
			this.$searchClear.on('click', () => {
				this.clearSearch();
			})

		if (this.$moreless.length) {
			this.$morelessToggle.addClass(this.moreBtnClass);

			this.$morelessToggle.on('click', () => {
				this.moreLessToggle();
			});
		}

		if (this.$dropdown.length)
			this.$dropdownLabel.on('click', () => {
				this.dropdownToggle();
			});
	}

	removeChangeEvent() {
		this.$checkboxes.off();
		this.$searchInput.off();
		this.$searchClear.off();
		this.$morelessToggle.off();
		this.$dropdownLabel.off();
	}

	processData() {
		const $checked = this.$checked;
		let dataValue = false;

		if ($checked.length === 1) {
			dataValue = $checked.val();
		} else if ($checked.length > 1) {
			dataValue = [];

			$checked.each(index => {
				dataValue.push($checked.get(index).value);
			})

			if (this.relationalOperator)
				dataValue.push('operator_' + this.relationalOperator);
		}

		this.dataValue = dataValue;

		this.dropDownItemsUpdate();
	}

	setData(newData) {
		this.getItemsByValue(newData).forEach($item => {
			$item.prop('checked', true);
		});

		this.processData();
	}

	reset(value = false) {
		if (value) {
			// reset one value
			this.getItemByValue(value).prop('checked', false);
			this.processData();
		} else {
			// reset filter
			this.getItemsByValue(this.dataValue).forEach($item => {
				$item.prop('checked', false);
			});

			this.processData();
		}
	}

	hideNotDisplayedItems() {
		const displayedItems = this.displayedItems;

		this.$checkboxes.each(index => {
			const $checkbox = this.$checkboxes.eq(index),
				$checkboxRow = $checkbox.closest('.jet-checkboxes-list__row'),
				displayedItem = displayedItems.some($item => { return $checkbox.is($item); });

			if (displayedItem) {
				$checkboxRow.attr('style', function (i, style) {
					return style && style.replace(/display[^;]+;?/g, '');
				});
			} else {
				$checkboxRow.css('display', 'none');
			}
		});

		if (this.$moreless.length) {
			if (this._moreLessNeeded) {
				this.$moreless.show();
			} else {
				this.$moreless.hide();
			}
		}
	}

	applySearch(value) {
		this.searchValue = value.toLowerCase();

		if (this.searchValue) {
			this.$searchInput.addClass(this.inputNotEmptyClass);
		} else {
			this.$searchInput.removeClass(this.inputNotEmptyClass);
		}

		this.hideNotDisplayedItems();
	}

	clearSearch() {
		this.$searchInput.val('');
		this.applySearch('');
	}

	moreLessToggle() {
		if (this.moreState) {
			this.switchToLess();
		} else {
			this.switchToMore();
		}
	}

	switchToMore() {
		this.moreState = true;
		this.$morelessToggle.removeClass(this.moreBtnClass).addClass(this.lessBtnClass).text(this.lessBtnText);

		this.hideNotDisplayedItems();
	}

	switchToLess() {
		this.moreState = false;
		this.$morelessToggle.removeClass(this.lessBtnClass).addClass(this.moreBtnClass).text(this.moreBtnText);

		this.hideNotDisplayedItems();
	}

	dropdownToggle() {
		if (this.dropdownState) {
			this.dropdownClose();
		} else {
			this.dropdownOpen();
		}
	}

	dropdownClose() {
		this.dropdownState = false;
		this.$dropdown.removeClass(this.dropdownOpenClass);

		$(document).off('click', this.documentClick);
	}

	dropdownOpen() {
		this.dropdownState = true;
		this.$dropdown.addClass(this.dropdownOpenClass);
		this.$searchInput.focus();

		$(document).on('click', { this: this }, this.documentClick);
	}

	documentClick(e) {
		if (!$.contains(e.data.this.$dropdown.get(0), e.target))
			e.data.this.dropdownClose();
	}

	dropDownItemsUpdate() {
		if (!this.$dropdownLabel.length)
			return;

		// remove all jQuery events to avoid memory leak
		this.$dropdownLabel.find('*').off();

		const $checked = this.$checked;

		if ($checked.length) {
			this.$dropdownLabel.html('');

			const $items = $('<div class="jet-checkboxes-dropdown__active"></div>');
			this.$dropdownLabel.append($items);

			$checked.each(index => {
				const $item = $checked.eq(index);

				$items.append(
					$(`<div class="jet-checkboxes-dropdown__active__item">${$item.data('label')}<span class="jet-checkboxes-dropdown__active__item__remove">×</span></div>`)
						.one('click', event => {
							event.stopPropagation();

							this.reset($item.val());
							this.emitFiterChange();
						})
				);
			});
		} else {
			this.$dropdownLabel.html(this.dropdownPlaceholderText);
		}
	}

	get activeValue() {
		let currentData = this.data,
			activeValue = '',
			delimiter = '';

		if (!Array.isArray(currentData))
			currentData = [currentData];

		currentData.forEach(value => {
			const label = this.getValueLabel(value);

			if (label) {
				activeValue += delimiter + label;
				delimiter = ', ';
			}
		});

		return activeValue || false;
	}

	get $checked() {
		return this.$checkboxes.filter(':checked');
	}

	get displayedItems() {
		let items = [];

		this.$checkboxes.each(index => {
			const $item = this.$checkboxes.eq(index),
				$itemContainer = $item.closest('.jet-checkboxes-list__row');

			// ignore the item if it was hidden by the indexer as empty
			if ($itemContainer.hasClass('jet-filter-row-hide'))
				return;

			// ignore the item if the item value does not match the search
			if (this.searchValue && $item.data('label').toLowerCase().indexOf(this.searchValue) === -1)
				return;

			items.push($item);
		});

		this._moreLessNeeded = items.length > this.numberOfDisplayed ? true : false;

		return !this.moreState && items.length > this.numberOfDisplayed
			? items.slice(0, this.numberOfDisplayed)
			: items;
	}

	// Additional methods
	getItemsByValue(values) {
		const items = [];

		if (!Array.isArray(values))
			values = [values];

		values.forEach(value => {
			items.push(this.getItemByValue(value));
		});

		return items;
	}

	getItemByValue(value) {
		return this.$checkboxes.filter('[value="' + value + '"]');
	}

	getValueLabel(value) {
		return this.$checkboxes.filter('[value="' + value + '"]').data('label');
	}
}