<template>
	<div>
		<br>
		<div class="cx-vui-subtitle">
			{{ 'Forms Settings' }}
		</div>
		<CxVuiCollapseMini
			v-for="( tab, index ) in tabs"
			:desc="tab.desc || ''"
			:label="tab.title"
			:key="tab.component.name"
		>
			<keep-alive>
				<component
					v-bind:is="tab.component"
					ref="tabComponents"
					:incoming="getIncoming( tab.component.name )"
				/>
			</keep-alive>
			<cx-vui-button
				button-style="accent"
				:loading="loadingTab"
				@click="onSaveTab( index, tab.component.name )"
			>
				<span slot="label">Save</span>
			</cx-vui-button>
		</CxVuiCollapseMini>
	</div>
</template>

<script>

import CxVuiCollapseMini from "../../package/collapse-mini/CxVuiCollapseMini";
import * as captcha from "./forms-tabs/captcha";
import * as activecampaign from "./forms-tabs/activecampaign";
import * as mailchimp from "./forms-tabs/mailchimp";
import * as getResponse from "./forms-tabs/getresponse";

const { applyFilters } = wp.hooks;

const formTabs = applyFilters( 'jet.engine.formTabs.register', [
	captcha,
	activecampaign,
	mailchimp,
	getResponse,
] );

export default {
	name:       'forms',
	components: { CxVuiCollapseMini },
	data() {
		return {
			tabs:       formTabs,
			loadingTab: false,
		};
	},
	methods:    {
		onSaveTab( indexTab, tabSlug ) {
			const currentTab = this.$refs.tabComponents[ indexTab ];
			const self = this;

			const ajaxRequest = {
				...{
					url:      window.ajaxurl,
					type:     'POST',
					dataType: 'json',
				},
				...currentTab.getRequestOnSave(),
			};
			ajaxRequest.data = {
				action: `jet_engine_forms_save_tab__${ tabSlug }`,
				...ajaxRequest.data,
			};

			self.loadingTab = true;

			jQuery.ajax( ajaxRequest )
			.done( function( response ) {
				if ( 'function' === typeof currentTab.onSaveDone ) {
					currentTab.onSaveDone( response );
				} else {
					if ( response.success ) {
						self.$CXNotice.add( {
							message:  response.data.message,
							type:     'success',
							duration: 5000,
						} );
					} else {
						self.$CXNotice.add( {
							message:  response.data.message,
							type:     'error',
							duration: 10000,
						} );
					}
				}
				self.loadingTab = false;
			} )
			.fail( function( jqXHR, textStatus, errorThrown ) {
				if ( 'function' === typeof currentTab.onSaveFail ) {
					currentTab.onSaveFail( jqXHR, textStatus, errorThrown );
				} else {
					self.$CXNotice.add( {
						message:  errorThrown,
						type:     'error',
						duration: 10000,
					} );
				}
				self.loadingTab = false;
			} );
		},
		getIncoming( tabName ) {
			return (
				window.JetEngineDashboardConfig._config__forms
				&& window.JetEngineDashboardConfig._config__forms[ tabName ]
			)
				? window.JetEngineDashboardConfig._config__forms[ tabName ]
				: {};
		},
	},
}
</script>