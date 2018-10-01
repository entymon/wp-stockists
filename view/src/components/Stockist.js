import React from 'react';
import { StockistContainer, StockistHeader, StockistContent } from './Styles';

export default class Stockist extends React.Component {
	
	static defaultProps = {
		data: {
			id: 0,
			email: null,
			second_email: null,
			mobile: null,
			phone: null,
			fax: null,
			state: null,
			title: null,
			town: null,
			website: null
		},
		country: {
			id: 0,
			image_url: '',
			iso_code: '',
			name: '',
			slug: ''
		}
	};
	
	render = () => {
		
		const { data, country } = this.props;
		
		return (
			<StockistContainer>
				<StockistHeader>
					<div className='stockist-title'>
						<p className='main-title'>{data.title}</p>
						<p className='sub-title'>Stockist in {country.name}</p>
					</div>
					<div className='stockist-country-flag'>
						<img className='country-flag' src={country.image_url} alt="flag"/>
					</div>
				</StockistHeader>
				<StockistContent>
					{data.email && (
						<div className='single-label'>
							<div className='label'>Email:</div>
							<div className='value'>
								<a className='stockist-hyperlink' href={`mailto:${data.email}`}>{data.email}</a>
							</div>
						</div>
					)}
					{data.second_email && (
						<div className='single-label'>
							<div className='label'>Second Email:</div>
							<div className='value'>
								<a className='stockist-hyperlink' href={`mailto:${data.second_email}`}>{data.second_email}</a>
							</div>
						</div>
					)}
					{data.mobile && (
						<div className='single-label'>
							<div className='label'>Mobile:</div>
							<div className='value'>{data.mobile}</div>
						</div>
					)}
					{data.phone && (
						<div className='single-label'>
							<div className='label'>Phone:</div>
							<div className='value'>{data.phone}</div>
						</div>
					)}
					{data.fax && (
						<div className='single-label'>
							<div className='label'>Fax:</div>
							<div className='value'>{data.fax}</div>
						</div>
					)}
					{data.state && (
						<div className='single-label'>
							<div className='label'>State:</div>
							<div className='value'>{data.state}</div>
						</div>
					)}
					{data.town && (
						<div className='single-label'>
							<div className='label'>Town:</div>
							<div className='value'>{data.town}</div>
						</div>
					)}
					{data.website && (
						<div className='single-label'>
							<div className='label'>Website:</div>
							<div className='value'>
								<a className='stockist-hyperlink' href={data.website}>{data.website}</a>
							</div>
						</div>
					)}
					
				</StockistContent>

			</StockistContainer>
		);
	};
}