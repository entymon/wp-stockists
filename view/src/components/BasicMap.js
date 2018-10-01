import React, { Component } from 'react';
import {
	ComposableMap,
	ZoomableGroup,
	Geographies,
	Geography
} from 'react-simple-maps'
import tooltip from 'wsdm-tooltip';
import { PageContainer } from './Styles';
import SelectRegion from './SelectRegion';

export default class BasicMap extends Component {
	
	static defaultProps = {
		countries: [],
		countryCodes: [],
		zoomRegions: [
			{ name: 'Africa', coordinates: [16.063, 2.378], zoom: 2 },
			{ name: 'Australia & New Zealand', coordinates: [151.2093, -33.8688], zoom: 2 },
			{ name: 'Asia', coordinates: [100.437012, 47.650589], zoom: 2 },
			{ name: 'Caribbean', coordinates: [-82.3666, 23.1136], zoom: 4 },
			{ name: 'Europe', coordinates: [21.0122, 52.2297], zoom: 3 },
			{ name: 'North America', coordinates: [-100.437012, 47.650589], zoom: 2 },
			{ name: 'South America', coordinates: [-56.0979, -15.6014], zoom: 2 },
			{ name: 'Southeast Asia', coordinates: [103.8198, 1.3521], zoom: 3 },
		],
		callback: () => {}
	};
	
	state = {
		countryCodes: [],
		worldData: null,
		zoom: 1,
		center: [0, 20],
	};
	
	tryFetchLocal = () => {
		fetch('/world-50m.json')
			.then(response => {
				if (response.status !== 200) {
					return;
				}
				response.json().then(worldData => {
					this.setState({
						worldData: worldData
					})
				})
			})
	};
	
	componentDidMount = () => {
		
		this.tip = tooltip();
		this.tip.create();
		
		let pathSVG = '/wp-content/plugins/jolly-stockists/view/build/world-50m.json';
		if (process.env.NODE_ENV === 'development') {
			pathSVG = '/world-50m.json';
		}
		
		fetch(pathSVG)
			.then(response => {
				if (response.status !== 200) {
					this.tryFetchLocal();
					return;
				} else {
					response.json().then(worldData => {
						this.setState({
							worldData: worldData
						})
					})
				}
			})
	};
	
	handleMouseMove = (geography, evt) => {
		if (this.props.countryCodes.includes(geography.id)) {
			this.tip.show(`
				<style>
					.wsdm-tooltip { padding: 0 !important; }
					.wsdm-tooltip .map-hover-tooltip {
				    color: #1c4ea3;
				    background-color: #faca0c;
				    opacity: 1;
				    border: 1px solid #faca0c;
				    padding: 5px 10px;
				    margin: 0;
					}
				</style>
	      <div class="map-hover-tooltip" style="bottom: -100px; color: #1c4ea3; background-color: #faca0c; opacity: 1; border: 1px solid #faca0c; padding: 5px 10px; margin: 0;">
	        ${this.props.countries[geography.id].country_name}
	      </div>
	    `);
			this.tip.position({ pageX: evt.pageX, pageY: evt.pageY });
		}
	};
	
	/**
	 * Mouse on leave handler
	 */
	handleMouseLeave = () => {
		this.tip.hide();
	};
	
	/**
	 * Click handler - returns country ID
	 * @param geography
	 */
	handleClick = (geography) => {
		if (this.props.countries[geography.id]) {
			this.props.callback(this.props.countries[geography.id].id);
		}
	};
	
	handleChangeRegion = (region) => {
		this.setState({
			center: region.coordinates,
			zoom: region.zoom
		})
	};
	
	handleReset = () => {
		this.setState({
			center: [0, 20],
			zoom: 1
		})
	};
	
	render = () => {
		
		return (
			<div>
				
				<PageContainer>
					<SelectRegion callback={this.handleChangeRegion} />
				</PageContainer>
				<PageContainer>
					<ComposableMap
						projectionConfig={{
							scale: 205,
							rotation: [-11, 0, 0]
						}}
						width={980}
						height={551}
						style={{
							width: '100%',
							height: 'auto'
						}}
					>
						<ZoomableGroup
							center={this.state.center}
							disablePanning
							zoom={this.state.zoom}
						>
							<Geographies geography={this.state.worldData}>
								{this.renderGeographies}
							</Geographies>
						
						</ZoomableGroup>
					</ComposableMap>
				</PageContainer>
			</div>
		)
	};
	
	renderGeographies = (geographies, projection) => {
		return geographies.map((geography, i) => this.renderGeography(projection, geography, i))
	};
	
	renderGeography = (projection, geography, i) => {
		
		if (geography.id !== 'ATA') {
			return (
				<Geography
					key={i}
					geography={geography}
					projection={projection}
					onClick={this.handleClick}
					onMouseMove={this.handleMouseMove}
					onMouseEnter={this.onMouseEnter}
					onMouseLeave={this.handleMouseLeave}
					style={{
						default: {
							fill: (this.props.countryCodes.includes(geography.id) ? '#faca0c' : '#ECEFF1'),
							stroke: '#607D8B',
							strokeWidth: 0.75,
							outline: 'none'
						},
						hover: {
							fill: (this.props.countryCodes.includes(geography.id) ? '#1c4ea3' : '#ECEFF1'),
							stroke: '#607D8B',
							strokeWidth: 0.75,
							outline: 'none'
						},
						pressed: {
							fill: (this.props.countryCodes.includes(geography.id) ? '#faca0c' : '#ECEFF1'),
							stroke: '#607D8B',
							strokeWidth: 0.75,
							outline: 'none'
						}
					}}
				/>
			);
		}
	};
}