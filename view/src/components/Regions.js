import React from 'react';
import styled from 'styled-components';
import { PageContainer } from './Styles';

const RegionContainer = styled.div.attrs({ className: 'region-container' })`
	> h2 {
		margin: 15px 0 5px 0;
	}
`;
const Countries = styled.div.attrs({ className: 'countries-container' })`
	display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-flex-direction: row;
  -ms-flex-direction: row;
  flex-direction: row;
  -webkit-flex-wrap: wrap;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-justify-content: flex-start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -webkit-align-content: stretch;
  -ms-flex-line-pack: stretch;
  align-content: stretch;
  
  > div.country-container:hover {
    opacity: 0.4;
  }
`;
const CountryContainer = styled.div.attrs({ className: 'country-container' })`
	cursor: pointer;
	display: flex;
	flex: 0 0 auto;
	flex-direction: row;
	justify-content: flex-start;
	margin: 5px;
	transition: opacity .5s;
	
	> img {
		display: flex;
    height: 35px;
	}
	> p {
		display: flex;
    margin: 0;
		align-self: center;
    padding-left: 10px;
	}
`;

export default class Regions extends React.Component {
	
	static defaultProps = {
		regions: [],
		callback: () => {}
	};
	
	openStockists = (countryId) => {
		console.log(countryId, 'country ID');
	};
	
	renderCountries = (countries) => {
		const countriesHTML = [];
		for (let isoKey in countries) {
			const country = countries[isoKey];
			
			countriesHTML.push(
				<CountryContainer id={country.iso_code} key={country.id} onClick={() => this.props.callback(country.id)}>
					<img src={country.image_url} alt="country flag"/>
					<p>{country.country_name}</p>
				</CountryContainer>
			);
		}
		return countriesHTML;
	};
	
	renderRegion = (regions) => {
		return regions.map((region, index) => {
			return (
			<RegionContainer key={index}>
				<h2>{region.region_name}</h2>
				<Countries>
					{this.renderCountries(region.countries)}
				</Countries>
			</RegionContainer>
		)});
	};
	
	render = () => {
		return (
			<PageContainer>
				{this.renderRegion(this.props.regions)}
			</PageContainer>
		);
	}
}