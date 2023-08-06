/**
 * WordPress dependencies.
 */
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Placeholder } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

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
					className="block-editor-post-format-placeholder post-format"
					label= { __( 'Conteneur de format d’article', 'ensemble' ) }
				/>
			</div>
		);
	},
	save: () => {
		return null;
	},
} );
