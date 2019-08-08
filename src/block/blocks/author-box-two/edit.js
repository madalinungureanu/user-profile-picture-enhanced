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


class User_Profile_Picture_Enhanced_Author_Box_Two extends Component {

	constructor() {

		super( ...arguments );
		let loading = false;
		this.state = {
			loading: loading,
		};
	};

	render() {
		const { post, setAttributes } = this.props;
		const { defaultImg, textColor, avatarShape, aboutHeading, theme, backgroundColor, border, padding, borderColor, borderRadius, aboutHeadingColor, aboutHeadingFontSize, titleHeadingColor, titleHeadingFontSize, postListHeadingColor, postListHeadingFontSize, showSocial, showTitle, showBio, showPosts} = this.props.attributes;

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

		// Get Theme Settings.
		const themeOptions = [
			{ value: 'none', label: __( 'None', 'user-profile-picture-enhanced' ) },
			{ value: 'bold', label: __( 'Bold', 'user-profile-picture-enhanced' ) },
			{ value: 'business', label: __( 'Business', 'user-profile-picture-enhanced' ) },
			{ value: 'centered', label: __( 'Centered', 'user-profile-picture-enhanced' ) },
			{ value: 'minimal', label: __( 'Minimal', 'user-profile-picture-enhanced' ) },
			{ value: 'dark', label: __( 'Dark', 'user-profile-picture-enhanced' ) },
			{ value: 'light', label: __( 'Light', 'user-profile-picture-enhanced' ) },
			{ value: 'professional', label: __( 'Professional', 'user-profile-picture-enhanced' ) },
			{ value: 'red-minimal', label: __( 'Red Minimal', 'user-profile-picture-enhanced' ) },
			{ value: 'red-full', label: __( 'Red Full', 'user-profile-picture-enhanced' ) },

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
							<PanelBody title={ __( 'Author Heading Settings', 'user-profile-picture-enhanced' ) }>
								<SelectControl
										label={ __( 'Select a Theme', 'user-profile-picture-enhanced' ) }
										value={theme}
										options={ themeOptions }
										onChange={ ( value ) => {
											setAttributes( {theme: value} );
										} }
								/>
								{'bold' !== theme &&
									<Fragment>
										<PanelColorSettings
											title={ __( 'Title Heading Color', 'user-profile-picture-enhanced' ) }
											initialOpen={ true }
											colorSettings={ [ {
												value: titleHeadingColor,
												onChange: ( value ) => {
													setAttributes( { titleHeadingColor: value});
												},
												label: __( 'About Heading Text Color', 'user-profile-picture-enhanced' ),
											} ] }
										>
										</PanelColorSettings>
										<RangeControl
											label={ __( 'Title Font Size', 'user-profile-picture-enhanced' ) }
											value={ titleHeadingFontSize }
											onChange={ ( value ) => this.props.setAttributes( { titleHeadingFontSize: value } ) }
											min={ 10 }
											max={ 100 }
											step={ 1 }
										/>
										<PanelColorSettings
											title={ __( 'Post List Heading Text Color', 'user-profile-picture-enhanced' ) }
											initialOpen={ true }
											colorSettings={ [ {
												value: postListHeadingColor,
												onChange: ( value ) => {
													setAttributes( { postListHeadingColor: value});
												},
												label: __( 'Post List Heading Text Color', 'user-profile-picture-enhanced' ),
											} ] }
										>
										</PanelColorSettings>
										<RangeControl
											label={ __( 'Post List Heading Font Size', 'user-profile-picture-enhanced' ) }
											value={ postListHeadingFontSize }
											onChange={ ( value ) => this.props.setAttributes( { postListHeadingFontSize: value } ) }
											min={ 10 }
											max={ 100 }
											step={ 1 }
										/>
									</Fragment>
								}
								<SelectControl
										label={ __( 'Select an Avatar Shape', 'user-profile-picture-enhanced' ) }
										value={avatarShape}
										options={ avatarShapeOptions }
										onChange={ ( value ) => {
											setAttributes( {avatarShape: value} );
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
								<PanelColorSettings
									title={ __( 'Text Color', 'user-profile-picture-enhanced' ) }
									initialOpen={ true }
									colorSettings={ [ {
										value: textColor,
										onChange: ( value ) => {
											setAttributes( { textColor: value});
										},
										label: __( 'Text Color', 'user-profile-picture-enhanced' ),
									} ] }
								>
								</PanelColorSettings>
							</PanelBody>
							<PanelBody title={ __( 'Show/Hide Sections', 'user-profile-picture-enhanced' ) } initialOpen={true}>
								<ToggleControl
									label={ __( 'Display Social Networks',  'post-type-archive-mapping' ) }
									checked={ showSocial }
									onChange={ ( value ) => {
										setAttributes( {showSocial: value} );
										this.props.attributes.showSocial = value;
									} }
								/>
								<ToggleControl
									label={ __( 'Display Title',  'post-type-archive-mapping' ) }
									checked={ showTitle }
									onChange={ ( value ) => {
										setAttributes( {showTitle: value} );
										this.props.attributes.showTitle = value;
									} }
								/>
								<ToggleControl
									label={ __( 'Display Biography',  'post-type-archive-mapping' ) }
									checked={ showBio }
									onChange={ ( value ) => {
										setAttributes( {showBio: value} );
										this.props.attributes.showBio = value;
									} }
								/>
								<ToggleControl
									label={ __( 'Display Posts',  'post-type-archive-mapping' ) }
									checked={ showPosts }
									onChange={ ( value ) => {
										setAttributes( {showPosts: value} );
										this.props.attributes.showPosts = value;
									} }
								/>
							</PanelBody>
							<PanelBody title={ __( 'Default Image', 'user-profile-picture-enhanced' ) } initialOpen={false}>
								<MediaUpload
									onSelect={ ( imageObject ) => {
										this.props.setAttributes( { defaultImg: imageObject.url } );
									} }
									type="image"
									value={ defaultImg }
									render={ ( { open } ) => (
										<Fragment>
											<button className="components-button is-button" onClick={ open }>
												{ __( 'Default Image', 'user-profile-picture-enhanced' ) }
											</button>
											{ defaultImg &&
												<Fragment>
													<div>
														<img src={ defaultImg } alt={ __( 'User Profile Picture Default Image', 'user-profile-picture-enhanced' ) } width="250" height="250" />
													</div>
													<div>
														<button className="components-button is-button" onClick={ ( event ) => {
															this.props.setAttributes( { defaultImg: '' } );
														} }>
															{ __( 'Remove Default Image', 'user-profile-picture-enhanced' ) }
														</button>
													</div>
												</Fragment>
											}
										</Fragment>
									) }
								/>
							</PanelBody>
						</InspectorControls>
						<Fragment>
							<div
								className={
									classnames(
										'upp-enhanced-author-box-two',
										theme,
										avatarShape
									)
								}
								style={{
									"backgroundColor": backgroundColor,
									"padding": padding + 'px',
									"border": border + 'px' + ' solid' + borderColor,
									"border-radius": borderRadius + 'px',
									"color": textColor,
								}}
							>
								<div className="column-meta">
									<div className="author-name">
										<a href="#">{__('Author Name Goes Here', 'user-profile-picture-enhanced')}</a>
										{ showSocial &&
											<span className="icons upp-enhanced-social-networks brand">
												<a href="#"><i className="fab fa-facebook-f"></i></a>
												<a href="#"><i className="fab fa-twitter"></i></a>
												<a href="#"><i className="fab fa-instagram"></i></a>
												<a href="#"><i className="fab fa-linkedin"></i></a>
												<a href="#"><i className="fab fa-pinterest"></i></a>
												<a href="#"><i className="fab fa-medium"></i></a>
												<a href="#"><i className="fab fa-wordpress"></i></a>
											</span>
										}
									</div>
								</div>
								<div className="author-picture">
									<img src={defaultImg} width="75" height="75" alt={__('Default Picture', 'user-profile-picture-enhanced')} />
								</div>
								{ showTitle &&
									<div
										className="author-title"
										style={ {
											color: titleHeadingColor,
											fontSize: titleHeadingFontSize + 'px'
										} }
									>
										The Author's Title Will Go Here
									</div>
								}
								{ showBio &&
									<div className="author-biography">
										Here's where the author's biography will be. It can <a href="#">have links</a> and other options where a detailed biography is left. It is recommended to fill out the user biography in the user's profile setting. The biography on the front end will be pulled from the user's biography that you set.
									</div>
								}

								{ showPosts &&
									<div className="author-post-list">
										<div
											className="author-post-list-heading"
											style={ {
												color: postListHeadingColor,
												fontSize: postListHeadingFontSize + 'px'
											} }
										>
											Posts by User Display Name
										</div>
										<ul>
											<li><a href="#">This is a fairly long post title</a></li>
											<li><a href="#">This is another user post</a></li>
											<li><a href="#">Finally, a third post.</a></li>
										</ul>
									</div>
								}
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
})(User_Profile_Picture_Enhanced_Author_Box_Two);