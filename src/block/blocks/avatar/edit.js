const { Component, Fragment } = wp.element;
const { withSelect } = wp.data;
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
		const { post } = this.props;

		return (
			<Fragment>
				{post.author}
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