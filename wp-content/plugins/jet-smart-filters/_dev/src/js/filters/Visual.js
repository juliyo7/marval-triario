import CheckboxControl from 'bases/controls/Checkbox';

export default class Visual extends CheckboxControl {
	name = 'visual';

	constructor($container) {
		const $filter = $container.find('.jet-color-image-list');

		super($container, $filter, $filter.find('.jet-color-image-list__input'));

		this.mergeSameQueryKeys = true;
	}
}