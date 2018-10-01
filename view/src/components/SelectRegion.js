import React from 'react';
import Select from 'react-select'
import { PageContainer } from './Styles';
import styled from 'styled-components';

const SelectRegionContainer = styled.div.attrs({ className: 'select-region-container' })`
	
	padding-bottom: 20px;
	border-bottom: 1px solid #607D8B;
	
	.select-label {
		display: inline-block;
		font-size: 18px;
		line-height: 36px;
		height: 36px;
		font-weight: 400;
		color: #004fa3;
	}
	
	.select-region {
		display: inline-block;
		min-width: 360px;
		margin: 0 20px;
		
		> div { border-radius: 0; }
	}
	
	.reset-button,
	.reset-button-mobile {
		display: inline-block;
    line-height: 36px;
    height: 36px;
    text-align: center;
    border: 1px solid #607D8B;
    background-color: #faca0c;
    color: #1c4ea3;
    cursor: pointer;
    transition: all .5s;
    width: 80px;
  }
  .reset-button:hover,
  .reset-button-mobile:hover {
    color: #FFF;
    background-color: #1c4ea3;
  }
  
  .reset-button-mobile {
    display: none;
  }
  @media (max-width: 860px) {
	  .reset-button-mobile {
	    display: inline-block;
	    margin-left: 20px;
	    float: right;
	  }
	  .reset-button {
	    display: none;
	  }
	  .select-region {
	    padding-top: 20px;
	    display: block;
	    margin: 0;
	    min-width: auto;
	    width: 100%;
	  }
  }
`;

export default class SelectRegion extends React.Component {
	
	static defaultProps = {
		callback: () => {}
	};
	
	componentDidMount = () => {
		this.regions = [
			{ value: 1, label: 'Africa', coordinates: [16.063, 2.378], zoom: 2 },
			{ value: 2, label: 'Australia & New Zealand', coordinates: [151.2093, -33.8688], zoom: 2 },
			{ value: 3, label: 'Asia', coordinates: [100.437012, 47.650589], zoom: 2 },
			{ value: 4, label: 'Caribbean', coordinates: [-82.3666, 23.1136], zoom: 4 },
			{ value: 5, label: 'Europe', coordinates: [21.0122, 52.2297], zoom: 3 },
			{ value: 6, label: 'North America', coordinates: [-100.437012, 47.650589], zoom: 2 },
			{ value: 7, label: 'South America', coordinates: [-56.0979, -15.6014], zoom: 2 },
			{ value: 8, label: 'Southeast Asia', coordinates: [103.8198, 1.3521], zoom: 3 }
		];
	};
	
	handleReset = () => {
		this.props.callback({
			zoom: 1,
			coordinates: [0, 20]
		});
	};
	
	handleSelectedOption = (option) => {
		this.props.callback(option);
	};
	
	render = () => {
		
		return (
			<PageContainer>
				<SelectRegionContainer>
					<div className='select-label'>
						Zoom In
					</div>
					<div className={'reset-button-mobile'} onClick={this.handleReset}>
						{'Reset'}
					</div>
					<Select
						placeholder='Select region'
						className='select-region'
						options={this.regions}
						onChange={this.handleSelectedOption}
					/>
					<div className={'reset-button'} onClick={this.handleReset}>
						{'Reset'}
					</div>
					<div className='clear'/>
				</SelectRegionContainer>
			</PageContainer>
		);
	}
}