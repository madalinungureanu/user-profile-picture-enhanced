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


class User_Profile_Picture_Enhanced_Biography extends Component {

	constructor() {

		super( ...arguments );
		let loading = true;
		if ( '' !== this.props.attributes.biography ) {
			loading = false;
		}
		this.state = {
			loading: loading,
			biography: this.props.attributes.biography,
			biographyHeading: this.props.attributes.biogrpahyHeading,
		};
	};

	getBiography = () => {
		axios.post(upp_enhanced.rest_url + `mpp/v3/get_user_biography/`, { post_id: this.props.post.id }, { 'headers': { 'X-WP-Nonce': upp_enhanced.rest_nonce } } ).then( (response) => {
			this.setState(
				{
					loading: false,
					biography: response.data.biography,
				}
			);
			this.props.setAttributes( {
				biography: response.data.biography,
			});
		});
	}

	componentDidMount = () => {
		if ( this.state.loading ) {
			this.getBiography();
		}
	}

	componentDidUpdate = (prevProps) => {
		if ( this.props.post.author !== prevProps.post.author ) {
			this.getBiography();
		}
	}

	render() {
		const { post, setAttributes } = this.props;
		const { align, biography, biographyHeading, backgroundColor, padding, border, borderColor, borderRadius, headingColor, headingFontSize, biographyColor, bgImg, bgImgFill, bgImgOpacity, bgImgParallax } = this.props.attributes;

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
						<PanelBody title={ __( 'Biography Settings', 'user-profile-picture-enhanced' ) }>
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
									label={ __( 'Heading Font Size', 'user-profile-picture' ) }
									value={ headingFontSize }
									onChange={ ( value ) => this.props.setAttributes( { headingFontSize: value } ) }
									min={ 10 }
									max={ 100 }
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
									title={ __( 'Background Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: backgroundColor,
										onChange: ( value ) => {
											setAttributes( { backgroundColor: value});
										},
										label: __( 'Backgroud Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
								<PanelColorSettings
									title={ __( 'Heading Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: headingColor,
										onChange: ( value ) => {
											setAttributes( { headingColor: value});
										},
										label: __( 'Heading Text Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
								<PanelColorSettings
									title={ __( 'Biography Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: biographyColor,
										onChange: ( value ) => {
											setAttributes( { biographyColor: value});
										},
										label: __( 'Biography Text Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
							</PanelBody>
						</InspectorControls>
						<Fragment>
							<div
								className={
									classnames(
										'upp-enhanced-biography',
										`align${align}`,
									)
								}
								style={{
									"backgroundColor": backgroundColor,
									"padding": padding + 'px',
									"border": border + 'px' + ' solid' + borderColor,
									"borderRadius": borderRadius + 'px',
									"backgroundImage": 'url(' + bgImg + ')',
									"backgroundSize": bgImgFill,
									"backgroundAttachment": bgImgParallax ? 'fixed' : 'inherit',
								}}
							>
								<RichText
									tagName="h2"
									placeholder={ __( 'Enter a Biography Heading...', 'user-profile-picture-enhanced' ) }
									value={ biographyHeading }
									className='upp-enhanced-biography-heading'
									style={ {
										color: headingColor,
										fontSize: headingFontSize + 'px'
									} }
									onChange={ ( value ) => { setAttributes( { biographyHeading: value } ) } }
								/>
								<RichText
									tagName="div"
									placeholder={ __( 'Enter a Biography...', 'user-profile-picture-enhanced' ) }
									value={ biography }
									className='upp-enhanced-biogrpahy-content'
									style={ {
										color: biographyColor,
									} }
									onChange={ ( value ) => { setAttributes( { biography: value } ) } }
								/>
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
})(User_Profile_Picture_Enhanced_Biography);