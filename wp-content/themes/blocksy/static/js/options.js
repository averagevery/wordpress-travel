import './public-path'
import $ from 'jquery'
import { initAllPanels } from './options/initPanels'
import { initWidget } from './backend/widgets'

if ($ && $.fn) {
	$(document).on('widget-added', (event, widget) => {
		initWidget(widget[0])
	})
}

document.addEventListener('DOMContentLoaded', () => {
	initAllPanels()
	;[
		...document.querySelectorAll('.notice-blocksy-plugin'),
		...document.querySelectorAll('[data-dismiss]')
	].map(el => import('./notification/main').then(({ mount }) => mount(el)))
})

export { getValueFromInput } from './options/helpers/get-value-from-input'
export { default as OptionsPanel } from './options/OptionsPanel'
export { DeviceManagerProvider } from './customizer/components/useDeviceManager'
export { default as PanelLevel } from './options/components/PanelLevel'
export { default as Switch } from './options/options/ct-switch'
export { default as ImageUploader } from './options/options/ct-image-uploader'
