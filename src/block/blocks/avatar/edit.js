import axios from 'axios';
import classnames from 'classnames';

const { Component, Fragment } = wp.element;
const { withSelect } = wp.data;
const { __, _x } = wp.i18n;


const {
	PanelBody,
	Placeholder,
	SelectControl,
	TextControl,
	Toolbar,
	ToggleControl,
	Button,
	ButtonGroup,
	PanelRow,
	Spinner,
} = wp.components;

const {
	InspectorControls,
	BlockControls,
	PanelColorSettings,
} = wp.editor;

const {
	RichText
} = wp.blockEditor;


class User_Profile_Picture_Enhanced_Avatar extends Component {

	constructor() {

		super( ...arguments );
		let loading = true;
		if ( '' !== this.props.attributes.imgUrl ) {
			loading = false;
		}
		this.state = {
			loading: loading,
			imageSize: this.props.attributes.imageSize,
			imgUrl: this.props.attributes.imgUrl,
			width: this.props.attributes.width,
			height: this.props.attributes.height,
			alt: this.props.attributes.alt,
			html: this.props.attributes.html,
			backgroundColor: this.props.attributes.backgroundColor,
			avatarShape: this.props.attributes.avatarShape,
		};
	};

	getAvatar = () => {
		axios.post(upp_enhanced.rest_url + `mpp/v3/get_avatar/`, { post_id: this.props.post.id, size: this.props.attributes.imageSize }, { 'headers': { 'X-WP-Nonce': upp_enhanced.rest_nonce } } ).then( (response) => {
			this.setState(
				{
					loading: false,
					imgUrl: response.data.src,
					alt: response.data.alt,
					width: response.data.width,
					height: response.data.height,
					html: response.data.html,
				}
			);
			this.props.setAttributes( {
				imgUrl: response.data.src,
				alt: response.data.alt,
				width: response.data.width,
				height: response.data.height,
				html: response.data.html,
			});
		});
	}

	componentDidMount = () => {
		if ( this.state.loading ) {
			this.getAvatar();
		}
	}

	componentDidUpdate = (prevProps) => {
		if ( this.props.post.author !== prevProps.post.author ) {
			this.getAvatar();
		}
	}

	render() {
		const { post, setAttributes } = this.props;
		const {  imgUrl, alt, width, height, backgroundColor, avatarShape } = this.props.attributes;

		// Get thumbnail sizes in the right format.
		const imageSizes = Object.entries( upp_enhanced.image_sizes );
		let thumbnailSizes = [];
		imageSizes.forEach( function( label, index ) {
			thumbnailSizes.push( { value: label[0], label: label[1] } );
		} );

		// Get Avatar Shape Settings.
		// Avatar shape options
		const avatarShapeOptions = [
			{ value: 'square', label: __( 'Square', 'user-profile-picture-enhanced' ) },
			{ value: 'round', label: __( 'Round', 'user-profile-picture-enhanced' ) },
		];

		return (
			<Fragment>
				{this.state.loading &&
				<Fragment>
					<Placeholder>
						<div>
							<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="125px" height="125px" viewBox="0 0 753.53 979.74"><title>upp</title><path d="M806.37,185.9c0,40.27-30.49,72.9-68.11,72.9s-68.17-32.63-68.17-72.9S700.62,113,738.26,113,806.37,145.64,806.37,185.9Z" transform="translate(-123.47 -11)" fill="#4063ad"/><path d="M330.36,183.8c0,40.27-30.49,72.9-68.12,72.9s-68.17-32.63-68.17-72.9,30.52-72.87,68.17-72.87S330.36,143.56,330.36,183.8Z" transform="translate(-123.47 -11)" fill="#a34d9c"/><path d="M331.3,888.13V698.21H329c-31.64,0-57.28-27.45-57.28-61.29V336.5a118.37,118.37,0,0,1,5.43-34.79H179.84c-31.94,0-56.37,31.57-56.37,56.34V601.46h48.32V888.13Z" transform="translate(-123.47 -11)" fill="#a34d9c"/><path d="M388.59,636.92V990.74H611.88V636.92H671.5V336.5c0-30.63-27.64-69.57-69.6-69.57H398.56c-39.44,0-69.61,38.94-69.61,69.57V636.92Z" transform="translate(-123.47 -11)" fill="#f4831f"/><path d="M584.3,101c0,49.69-37.63,90-84,90S416.12,150.67,416.12,101s37.66-90,84.14-90S584.3,51.27,584.3,101Z" transform="translate(-123.47 -11)" fill="#f4831f"/><path d="M820.61,303.79H724.08a121.69,121.69,0,0,1,4.7,32.71V636.92c0,33.84-25.64,61.29-57.28,61.29h-2.33v192H828.7V603.54H877V360.16C877,335.36,854.62,303.79,820.61,303.79Z" transform="translate(-123.47 -11)" fill="#4063ad"/></svg>
							<div className="mpp-spinner"><Spinner /></div>
						</div>
					</Placeholder>
				</Fragment>
				}
				{!this.state.loading &&
					<Fragment>
						<InspectorControls>
							<PanelBody title={ __( 'Avatar Settings', 'user-profile-picture-enhanced' ) }>
								<SelectControl
										label={ __( 'Select an Image Size', 'user-profile-picture-enhanced' ) }
										value={this.state.imageSize}
										options={ thumbnailSizes }
										onChange={ ( value ) => {
											setAttributes( {imageSize: value} );
											this.props.attributes.imageSize = value;
											this.setState( { loading: true, imageSize: value } );
											this.getAvatar();
										} }
								/>
								<SelectControl
										label={ __( 'Select an Avatar Shape', 'user-profile-picture-enhanced' ) }
										value={this.state.avatarShape}
										options={ avatarShapeOptions }
										onChange={ ( value ) => {
											setAttributes( {avatarShape: value} );
											this.setState( { avatarShape: value } );
										} }
								/>
							</PanelBody>
						</InspectorControls>
						<Fragment>
							<div
								className={
									classnames(
										'upp-enhanced-avatar',
										avatarShape,
									)
								}
							>
								<img src={imgUrl} alt={alt} width={width} height={height} />
							</div>
						</Fragment>
					</Fragment>
				}
			</Fragment>
		);
	}
}
export default withSelect(select => {
	const { getCurrentPost } = select("core/editor");

	return {
		post: getCurrentPost(),
	};
})(User_Profile_Picture_Enhanced_Avatar);