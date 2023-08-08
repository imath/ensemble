/**
 * External dependencies.
 */
import { find } from 'lodash';

/**
 * WordPress dependencies.
 */
import {
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { store as coreStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import metadata from './block.json';

function PostFormatInnerBlocks( { template } ) {
	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'wp-block-post-format' },
		{ template: template, __unstableDisableLayoutClassNames: true }
	);

	return <div { ...innerBlocksProps } />;
}

registerBlockType( metadata, {
	edit: ( { attributes, context } ) => {
		const blockProps = useBlockProps();
		const { format } = attributes;
		const { postId } = context;

		if ( 'standard' !== format ) {
			const formatSlug = 'post-format-' + format;
			const { postFormats, isLoading } = useSelect(
				( select ) => {
					const { getEntityRecords, isResolving } = select( coreStore );
					const taxonomyArgs = [
						'taxonomy',
						'post_format',
						{
							post: postId,
							per_page: -1,
							context: 'view',
						},
					];

					const terms = getEntityRecords( ...taxonomyArgs );

					return {
						postFormats: terms,
						isLoading: isResolving( 'getEntityRecords', taxonomyArgs ),
					};
				},
				[ postId ]
			);

			if ( false === isLoading && find( postFormats, [ 'slug', formatSlug ] ) ) {
				/**
				 * @todo This is the part to edit so that `formatSlug` can be used
				 * to select the template to load.
				 */
				const FORMAT_TEMPLATE = [
					[ 'core/post-title' ],
				];

				return (
					<div { ...blockProps }>
						<PostFormatInnerBlocks template={ FORMAT_TEMPLATE } />
					</div>
				);
			} else {
				return null;
			}
		} else {
			const TEMPLATE = [
				[ 'core/post-title' ],
				[ 'core/post-date' ],
				[ 'core/post-excerpt' ],
			];

			return (
				<div { ...blockProps }>
					<PostFormatInnerBlocks template={ TEMPLATE } />
				</div>
			);
		}
	},
} );
