const { Component, Fragment } = wp.element;

const { __, _x } = wp.i18n;

const {
	PanelBody,
	SelectControl,
	TextControl,
	Toolbar,
	ToggleControl,
	Button,
	ButtonGroup,
	PanelRow,
} = wp.components;

const {
	InspectorControls,
	BlockControls
} = wp.editor;

const {
	RichText
} = wp.blockEditor;


class User_Profile_Picture_Enhanced_Avatar extends Component {

	constructor() {

		super( ...arguments );

		this.state = {

		};
	};

	render() {
		const { attributes } = this.props;

		return (
			<Fragment>

			</Fragment>
		);
	}
}

export default User_Profile_Picture_Enhanced_Avatar;
