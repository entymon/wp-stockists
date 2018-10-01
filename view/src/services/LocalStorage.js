export const _CACHE_COUNTRIES = '_cache_countries';
export const _CACHE_COUNTRY_CODES = '_cache_country_codes';
export const _CACHE_STOCKISTS = '_cache_stockists';

export default class LocalStorage {

	add = (itemKey, value) => {
		localStorage.setItem(itemKey, value);
	};
	
	remove = (itemKey) => {
		localStorage.removeItem(itemKey);
	};
	
	get = (itemKey) => {
		localStorage.getItem(itemKey);
	}
	
}