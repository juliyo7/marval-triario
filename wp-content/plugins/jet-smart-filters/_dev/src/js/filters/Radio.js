import SelectControl from 'bases/controls/Select';

export default class Radio extends SelectControl {
	name = 'radio';

	constructor ($container) {
		const $filter = $container.find('.jet-radio-list');

		super($container, $filter, $filter.find(':radio'));

		this.mergeSameQueryKeys = true;
	}
}