import {
	isFunction,
	getNesting
} from 'includes/utility';

export default class CustomProvider {
	customProviders = ['jet-engine-maps'];
	customAjaxRequests = {
		'jet-engine-maps': this.jetEngineMapsAjaxRequest
	}

	constructor(filterGroup) {
		this.filterGroup = filterGroup;
		this.filterGroup.isCustomProvider = this.customProviders.includes(this.filterGroup.provider);

		// jetEngine Calendar add current query to request
		$(document).on('jet-engine-request-calendar', () => {
			this.jetEngineCalendarRequest();
		});
	}

	ajaxRequest() {
		const ajaxRequestFn = this.customAjaxRequests[this.filterGroup.provider];

		if (!isFunction(ajaxRequestFn))
			return;

		ajaxRequestFn.call(this);
	}

	jetEngineMapsAjaxRequest() {
		this.filterGroup.ajaxRequest(response => {
			this.filterGroup.$provider
				.closest('.elementor-widget-jet-engine-maps-listing')
				.trigger('jet-filter-custom-content-render', response);

			// update pagination props
			if (response.pagination && getNesting(JetSmartFilterSettings, 'props', this.filterGroup.provider, this.filterGroup.queryId)) {
				window.JetSmartFilterSettings.props[this.filterGroup.provider][this.filterGroup.queryId] = {
					...response.pagination
				}
			}
		});
	}

	jetEngineCalendarRequest() {
		const currentRequest = getNesting(JetEngine, 'currentRequest');

		if (!currentRequest)
			return;

		currentRequest.query = this.filterGroup.currentQuery;
	}
}