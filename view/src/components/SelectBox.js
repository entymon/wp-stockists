import React from 'react';
import Select from 'react-select'
import _ from 'lodash';
import { PageContainer, SelectBoxContainer } from './Styles';

export default class SelectBox extends React.Component {
	
	static defaultProps = {
		countries: [],
		selected: null,
		callback: () => {}
	};
	
	getOptions = (data) => {
		let options = [];
		if (!_.isEmpty(data)) {
			for (let code in data) {
				const obj = {
					value: data[code].id,
					label: data[code].country_name
				};
				options.push(obj);
			}
		}
		return options;
	};
	
	getValue = (options) => {
		if (this.props.selected !== null) {
			return options.filter(obj => {
				return parseInt(obj.value, 10) === parseInt(this.props.selected, 10);
			})
		}
		return null;
	};
	
	handleSelectedOption = (option) => {
		this.props.callback(option.value);
	};
	
	render = () => {
		
		const options = this.getOptions(this.props.countries);
		const value = this.getValue(options);
		
		return (
			<PageContainer>
				<SelectBoxContainer>
					<div className='select-label'>
						Your local Entymon Stockists
					</div>
					<Select
						placeholder='Select country'
						className='select-input'
						options={options}
						value={value}
						onChange={this.handleSelectedOption}
					/>
				</SelectBoxContainer>
			</PageContainer>
		);
	}
}