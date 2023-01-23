/**
 * WordPress dependencies.
 */
const {
	blockEditor: {
		useBlockProps,
	},
	blocks: {
		registerBlockType,
	},
	components: {
		Placeholder,
	},
	element: {
		createElement,
	},
	i18n: {
		__,
	},
} = wp;

/**
 * Internal dependencies.
 */
import metadata from './block.json';

registerBlockType( metadata, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div { ...blockProps }>
				<Placeholder
					className="block-editor-media-placeholder is-large has-illustration"
					withIllustration={ true }
				/>
			</div>
		);
	},
	save: () => {
		return null;
	},
} );
