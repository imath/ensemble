/**
 * WordPress dependencies.
 */
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Placeholder } from '@wordpress/components';

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
