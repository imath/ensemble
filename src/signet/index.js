/**
 * WordPress dependencies.
 */
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { __experimentalFetchUrlData as fetchUrlData } from '@wordpress/core-data';
import { useEffect, useReducer } from '@wordpress/element';

/**
 * Internal dependencies.
 */
import metadata from './block.json';

/**
 * Resolves URL Rich Data.
 *
 * Copy/pasted from Block Editor's link-control.
 *
 * @link https://github.com/WordPress/gutenberg
 *
 * @param {object} state
 * @param {object} action
 * @returns {object}
 */
function reducer( state, action ) {
	switch ( action.type ) {
		case 'RESOLVED':
			return {
				...state,
				isFetching: false,
				richData: action.richData,
			};
		case 'ERROR':
			return {
				...state,
				isFetching: false,
				richData: null,
			};
		case 'LOADING':
			return {
				...state,
				isFetching: true,
			};
		default:
			throw new Error( `Unexpected action type ${ action.type }` );
	}
}

/**
 * Gets URL Rich Data.
 *
 * Adapted from Block Editor's link-control.
 *
 * @link https://github.com/WordPress/gutenberg
 *
 * @param {string} url
 * @returns {object}
 */
function useRichUrlData( url ) {
	const [ state, dispatch ] = useReducer( reducer, {
		richData: null,
		isFetching: false,
	} );

	useEffect( () => {
		if ( url && url.length ) {
			dispatch( {
				type: 'LOADING',
			} );

			const controller = new window.AbortController();

			const signal = controller.signal;

			fetchUrlData( url, {
				signal,
			} ).then( ( urlData ) => {
				dispatch( {
					type: 'RESOLVED',
					richData: urlData,
				} );
			} ).catch( () => {
				if ( ! signal.aborted ) {
					dispatch( {
						type: 'ERROR',
					} );
				}
			} );

			return () => {
				controller.abort();
			};
		}
	}, [ url ] );

	return state;
}

registerBlockType( metadata, {
	edit: () => {
		const blockProps = useBlockProps();
		const url = 'https://wordpress.org/news/2023/08/lionel/';

		const { richData, isFetching } = useRichUrlData( url );
		const hasRichData = richData && Object.keys( richData ).length;

		/*
		 * @todo Check gutenberg/packages/block-editor/src/components/link-control/link-preview.js
		 * to set the output.
		 */

		return (
			<div { ...blockProps }>
				<p>Hello world</p>
			</div>
		);
	},
	save: () => {
		return null;
	},
} );
