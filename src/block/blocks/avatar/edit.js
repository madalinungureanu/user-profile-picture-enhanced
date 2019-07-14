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
	RangeControl,
	ButtonGroup,
	PanelRow,
	Spinner,
} = wp.components;

const {
	InspectorControls,
	BlockControls,
	MediaUpload,
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
			padding: this.props.attributes.padding,
			imgBorder: this.props.attributes.imgBorder,
			imgBgColor: this.props.attributes.imgBgColor,
			imgBorderColor: this.props.attributes.imgBorderColor,
			imgpadding: this.props.attributes.imgPadding,
			border: this.props.attributes.border,
			borderColor: this.props.attributes.borderColor,
			borderRadius: this.props.attributes.borderRadius,
			caption: this.props.attributes.caption,
			captionColor: this.props.attributes.captionColor,
			captionFontSize: this.props.attributes.captionFontSize,
			bgImg: this.props.attributes.bgImg,
			bgImgFill: this.props.attributes.bgImgFill,
			bgImgOpacity: this.props.attributes.bgImgOpacity,
			bgImgParallax: this.props.attributes.bgImgParallax,
		};
	};

	getAvatar = () => {
		const refThis = this;
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
		}).catch(function (error) {
			refThis.setState(
				{
					loading: false,
				}
			)
		});;
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
		if ( this.props.post.featured_media !== prevProps.post.featured_media ) {

			// Set up endpoint to add new profile picture.
			axios.post(upp_enhanced.rest_url + `mpp/v3/change_profile_image/`, { post_id: this.props.post.id, media_id: this.props.post.featured_media }, { 'headers': { 'X-WP-Nonce': upp_enhanced.rest_nonce } } ).then( (response) => {
				this.getAvatar();
			} );
		}
	}

	render() {
		const { post, setAttributes } = this.props;
		const { align, imgUrl, alt, width, height, backgroundColor, avatarShape, padding, imgBorder, imgBgColor, imgBorderColor, imgPadding, border, borderColor, borderRadius, caption, captionColor, captionFontSize, bgImg, bgImgFill, bgImgOpacity, bgImgParallax } = this.props.attributes;

		// Get thumbnail sizes in the right format.
		const imageSizes = Object.entries( upp_enhanced.image_sizes );
		let thumbnailSizes = [];
		imageSizes.forEach( function( label, index ) {
			thumbnailSizes.push( { value: label[0], label: label[1] } );
		} );

		// Get Avatar Shape Settings.
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
				{!this.state.loading && '' !== imgUrl &&
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
								<RangeControl
									label={ __( 'Padding', 'user-profile-picture-enhanced' ) }
									value={ padding }
									onChange={ ( value ) => this.props.setAttributes( { padding: value } ) }
									min={ 0 }
									max={ 60 }
									step={ 1 }
								/>
								<RangeControl
									label={ __( 'Border', 'user-profile-picture-enhanced' ) }
									value={ border }
									onChange={ ( value ) => this.props.setAttributes( { border: value } ) }
									min={ 0 }
									max={ 60 }
									step={ 1 }
								/>
								<RangeControl
									label={ __( 'Border Radius', 'user-profile-picture-enhanced' ) }
									value={ borderRadius }
									onChange={ ( value ) => this.props.setAttributes( { borderRadius: value } ) }
									min={ 0 }
									max={ 60 }
									step={ 1 }
								/>
								<RangeControl
									label={ __( 'Image Border', 'user-profile-picture' ) }
									value={ imgBorder }
									onChange={ ( value ) => this.props.setAttributes( { imgBorder: value } ) }
									min={ 0 }
									max={ 60 }
									step={ 1 }
								/>
								<RangeControl
									label={ __( 'Image Padding', 'user-profile-picture' ) }
									value={ imgPadding }
									onChange={ ( value ) => this.props.setAttributes( { imgPadding: value } ) }
									min={ 0 }
									max={ 60 }
									step={ 1 }
								/>
							</PanelBody>
							<PanelBody title={ __( 'Background Settings', 'user-profile-picture-enhanced' ) } initialOpen={false}>
								<MediaUpload
									onSelect={ ( imageObject ) => {
										this.props.setAttributes( { bgImg: imageObject.url } );
									} }
									type="image"
									value={ bgImg }
									render={ ( { open } ) => (
										<Fragment>
											<button className="components-button is-button" onClick={ open }>
												{ __( 'Background Image!', 'user-profile-picture-enhanced' ) }
											</button>
											{ bgImg &&
												<Fragment>
													<div>
														<img src={ bgImg } alt={ __( 'User Profile Picture Background Image', 'user-profile-picture-enhanced' ) } width="250" height="250" />
													</div>
													<div>
														<button className="components-button is-button" onClick={ ( event ) => {
															this.props.setAttributes( { bgImg: '' } );
														} }>
															{ __( 'Remove Image', 'user-profile-picture-enhanced' ) }
														</button>
													</div>
												</Fragment>
											}
										</Fragment>
									) }
								/>
								<ToggleControl
									label={ __( 'Parallax?', 'user-profile-picture-enhanced' ) }
									checked={ bgImgParallax }
									onChange={ ( value ) => this.props.setAttributes( { bgImgParallax: value } ) }
								/>

							</PanelBody>
							<PanelBody title={ __( 'Color Settings', 'user-profile-picture-enhanced' ) } initialOpen={false}>
								<PanelColorSettings
									title={ __( 'Border Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: borderColor,
										onChange: ( value ) => {
											setAttributes( { borderColor: value});
										},
										label: __( 'Image Border Color', 'user-profile-picture-enhanced' ),
									} ] }
								></PanelColorSettings>
								<PanelColorSettings
									title={ __( 'Image Background Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: imgBgColor,
										onChange: ( value ) => {
											setAttributes( { imgBgColor: value});
										},
										label: __( 'Image Border Color', 'user-profile-picture-enhanced' ),
									} ] }
								></PanelColorSettings>
								<PanelColorSettings
									title={ __( 'Image Border Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: imgBorderColor,
										onChange: ( value ) => {
											setAttributes( { imgBorderColor: value});
										},
										label: __( 'Image Border Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
								<PanelColorSettings
									title={ __( 'Background Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: backgroundColor,
										onChange: ( value ) => {
											setAttributes( { backgroundColor: value});
										},
										label: __( 'Background Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
							</PanelBody>
							<PanelBody title={ __( 'Caption Settings', 'user-profile-picture-enhanced' ) } initialOpen={false}>
								<PanelColorSettings
									title={ __( 'Caption Text Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: captionColor,
										onChange: ( value ) => {
											setAttributes( { captionColor: value});
										},
										label: __( 'Caption Text Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
								<RangeControl
									label={ __( 'Caption Font Size', 'user-profile-picture-enhanced' ) }
									value={ captionFontSize }
									onChange={ ( value ) => this.props.setAttributes( { captionFontSize: value } ) }
									min={ 10 }
									max={ 100 }
									step={ 1 }
								/>
							</PanelBody>
						</InspectorControls>
						<Fragment>
							<div
								className={
									classnames(
										'upp-enhanced-avatar',
										avatarShape,
										`align${align}`,
									)
								}
								style={{
									"backgroundColor": backgroundColor,
									"padding": padding + 'px',
									"border": border + 'px' + ' solid' + borderColor,
									"border-radius": borderRadius + 'px',
									"backgroundImage": 'url(' + bgImg + ')',
									"backgroundSize": bgImgFill,
									"backgroundAttachment": bgImgParallax ? 'fixed' : 'inherit',
								}}
							>
								<img
									src={imgUrl}
									alt={alt}
									width={width}
									height={height}
									style={{
										"backgroundColor": imgBgColor,
										"border": imgBorder + 'px' + ' solid' + imgBorderColor,
										"padding": imgPadding + 'px',
									}}
								/>
								<RichText
									tagName="h2"
									placeholder={ __( 'Enter a Caption...', 'user-profile-picture-enhancedanced' ) }
									value={ caption }
									className='upp-enhanced-avatar-caption'
									style={ {
										color: captionColor,
										fontSize: captionFontSize + 'px'
									} }
									onChange={ ( value ) => { setAttributes( { caption: value } ) } }
								/>
							</div>
						</Fragment>
					</Fragment>
				}
				{!this.state.loading && '' === imgUrl &&
					<Fragment>
						{__( 'There is no avatar for this user.', 'user-profile-picture-enhanced' )}
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