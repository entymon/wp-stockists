export const _CACHE_COUNTRIES = 'cache-countries';
export const _CACHE_COUNTRY_CODES = 'cache-country-codes';
export const _CACHE_STOCKISTS = 'cache-stockists';

export default class LocalStorage {

	static add = (itemKey, value) => {
		localStorage.setItem(itemKey, JSON.stringify(value));
	};
	
	static remove = (itemKey) => {
		localStorage.removeItem(itemKey);
	};
	
	static get = (itemKey) => {
		const data = localStorage.getItem(itemKey);
		if (data) {
			return JSON.parse(data);
		}
		return null;
	}
	
}