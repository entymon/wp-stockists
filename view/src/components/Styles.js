import styled from 'styled-components';

export const PageContainer = styled.div.attrs({ className: 'countries-container' })`
  max-width: 980px;
  margin: 0 auto;
  padding: 20px;
`;

export const SelectBoxContainer = styled.div.attrs({ className: 'select-box-container' })`
	padding: 20px 0;
	border-top: 1px solid #607D8B;
	border-bottom: 1px solid #607D8B;
	
	.select-label {
		display: inline-block;
		font-size: 24px;
		line-height: 48px;
		font-weight: 400;
		color: #004fa3;
	}
	
	.select-input {
		display: inline-block;
		min-width: 360px;
		margin-left: 20px;
		> div { border-radius: 0; }
	}
	
	@media (max-width: 860px) {
	  .select-label {
			display: block;
		}
		.select-input {
			margin-left: 0;
			display: block;
		}
  }
`;


export const ModalHeader = styled.div.attrs({ className: 'modal-header' })`
    margin-top: 30px;
    margin-bottom: 20px;
    width: 100%;
    padding: 0 10px;
    font-size: 20px;
    color: #004fa3;
`;
export const ModalBody = styled.div.attrs({ className: 'modal-body' })`
	overflow: hidden;
`;

export const StockistContainer = styled.div.attrs({ className: 'stockist-container' })`
	padding: 20px;
	float: left;
	width: 328px;
	border: 1px solid #004fa3;
	margin: 0 10px 20px;
	
	@media-query (min-width: 860px) {
		float: none;
	}
`;

export const StockistHeader = styled.div.attrs({ className: 'stockist-header' })`
	overflow: hidden;

	> .stockist-title {
		float: left;
		color: #004fa3;
    width: 50%;

		> p.main-title {
			margin: 0;
			font-weight: 800;
		}
		> p.sub-title {
			margin-top: 28px;
	    font-size: 12px;
	    opacity: .8;
		}
	}
	
	> .stockist-country-flag {
    width: 50%;
		float: right;
    text-align: right;
			
		> img.country-flag {
	    width: 120px;
		}
	}
`;

export const StockistContent = styled.div.attrs({ className: 'stockist-content' })`
	
	margin-top: 30px
	> .single-label {
	
			margin-bottom: 10px;
			overflow: hidden;
			padding: 5px;
			border: 1px solid #004fa3;
			background-color: #faca0c;
			color: #004fa3;
			font-size: 14px;
			
		> .label {
			width: 100px;
			float: left;
		}
		> .value {
			float: left;
			font-weight: 800;
			
			> a.stockist-hyperlink {
				color: #004fa3;
				font-size: 14px;
				text-decoration: none;
				cursor: pointer;
				transition: opacity .5s;
			}
			> a.stockist-hyperlink:hover {
				opacity: .5;
			}
		}
	}
`;
