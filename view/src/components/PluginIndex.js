import React from 'react';
import axios from 'axios/index';
import Modal from 'react-responsive-modal';
import _ from 'lodash';
import BasicMap from './BasicMap';
import Regions from './Regions';
import SelectBox from './SelectBox';
import { ModalBody, ModalHeader } from './Styles';
import Stockist from './Stockist';
import styled from 'styled-components';
import config from '../config/config';

const Wrapper = styled.div.attrs({ className: 'wrapper' })`
	
	@media (max-width: 860px) {
		.custom-modal {
			margin-top: 300px;
		}
	}
`;

export default class PluginIndex extends React.Component {
	
	state = {
		stockists: [],
		countries: {},
		countryId: null,
		selectedCountry: null,
		open: false,
	};
	
	setCountryCodes = (countries) => {
		const countryCodes = [];
		for ( let code in countries ) {
			countryCodes.push(code);
		}
		return countryCodes;
	};
	
	/**
	 *
	 * @param regions
	 * @returns {Promise<any>}
	 */
	retrieveCountryData = (regions) => {
		return new Promise((resolve) => {
			let countries = {};
			for(let regionName in regions) {
				countries = { ...countries, ...regions[regionName].countries };
			}
			const countryCodes = this.setCountryCodes(countries);
			resolve({
					countries,
					countryCodes
				});
		});
	};
	
	onOpenModal = () => {
		this.setState({ open: true });
	};
	
	onCloseModal = () => {
		this.setState({ open: false });
	};
	
	componentDidMount = () => {
		
		let hostname = '';
		if (process.env.NODE_ENV === 'development') {
			hostname = config.hostname;
		}
		
		axios.get(`${hostname}/wp-json/jolly/v1/stockist/stockists`).then(res => {
			
			this.retrieveCountryData(res.data).then((data) => {
				
				const sortedData = _.sortBy(res.data, ['order']);
				this.setState({
					countries: data.countries,
					countryCodes: data.countryCodes,
					stockists: sortedData
				});
			});
		});
	};
	
	getListOfStockists = (countryId) => {
		
		let hostname = '';
		if (process.env.NODE_ENV === 'development') {
			hostname = config.hostname;
		}
		
		axios.get(`${hostname}/wp-json/jolly/v1/stockist/stockists/${countryId}`).then(res => {
			this.setState({
				selectedCountry: res.data,
				open: true
			});
		});
	};
	
	showStockists = (countryId) => {
		this.setState({ countryId }, this.getListOfStockists(countryId));
	};
	
	render = () => {
		
		const { selectedCountry } = this.state;
		
		return (
			<Wrapper>
				<div id='js-modal-portal'/>
				<BasicMap
					countries={this.state.countries}
					countryCodes={this.state.countryCodes}
					callback={this.showStockists}
				/>
				<SelectBox
					countries={this.state.countries}
					callback={this.showStockists}
					selected={this.state.countryId}
				/>
				<Regions
					regions={this.state.stockists}
					callback={this.showStockists}
				/>
				<Modal open={this.state.open} onClose={this.onCloseModal} center classNames={{
					overlay: 'custom-overlay',
					modal: 'custom-modal',
				}} container={document.getElementById('js-modal-portal')}>
					<ModalHeader>
						Stockists in {selectedCountry && selectedCountry.country.name}
					</ModalHeader>
					<ModalBody>
						{ selectedCountry && selectedCountry.stockists.map((stockist, key) => (
							<Stockist country={selectedCountry.country} key={`stockist-${key}`} data={stockist} />
						))}
					</ModalBody>
				</Modal>
			</Wrapper>
		);
	}
}