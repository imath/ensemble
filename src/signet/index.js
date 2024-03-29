/**
 * WordPress dependencies.
 */
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import {
	Placeholder,
	Button,
	ExternalLink,
	Spinner,
} from '@wordpress/components';
import { __experimentalFetchUrlData as fetchUrlData } from '@wordpress/core-data';
import { __unstableStripHTML as stripHTML } from '@wordpress/dom';
import { useEffect, useReducer, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies.
 */
import metadata from './block.json';
import './style.scss';
import { ReactComponent as Bookmark } from './bookmark.svg';

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
function useRichUrlData( url, setAttributes, attributes ) {
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
				const { title, image, description } = urlData;
				setAttributes( {
					title: !! attributes.title ? stripHTML( attributes.title ) : stripHTML( title ),
					image: !! attributes.image ?  attributes.image : image,
					description: !! attributes.description ? stripHTML( attributes.description ) : stripHTML( description ),
				} );

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
	}, [ url, setAttributes, attributes ] );

	return state;
}

registerBlockType( metadata, {
	icon: Bookmark,
	edit: ( { attributes, setAttributes, isSelected } ) => {
		const blockProps = useBlockProps();
		const label = __( 'Signet', 'ensemble' );
		const { url, image, title, description } = attributes;
		const [ link, setURL ] = useState( url );
		const [ isEditingURL, setIsEditingURL ] = useState( ! url );
		const { richData, isFetching } = useRichUrlData( url, setAttributes, attributes );
		const hasRichData = richData && Object.keys( richData ).length;

		const onSubmit = ( event ) => {
			if ( event ) {
				event.preventDefault();
			}

			setIsEditingURL( false );
			setAttributes( { url: link } );
		};

		if ( isEditingURL ) {
			return (
				<div { ...blockProps }>
					<Placeholder
						icon={ <Bookmark width="24px" /> }
						label={ label }
						className="wp-block-embed"
						instructions={ __( 'Coller l’URL du signet pour récupérer les informations nécessaires à son aperçu.', 'ensemble' ) }
					>
						<form onSubmit={ onSubmit }>
							<input
								type="url"
								value={ link || '' }
								className="components-placeholder__input"
								aria-label={ label }
								placeholder={ __( 'Insérer l’URL du signet pour obtenir son aperçu…', 'ensemble' ) }
								onChange={ ( event ) => setURL( event.target.value ) }
							/>
							<Button variant="primary" type="submit">
								{ __( 'Intégrer', 'ensemble' ) }
							</Button>
						</form>
					</Placeholder>
				</div>
			);
		}

		if ( !! url ) {
			if ( isFetching ) {
				return (
					<div { ...blockProps }>
						<div className="wp-block-embed is-loading">
							<Spinner />
							<p>{ __( 'Intégration en cours…', 'ensemble' ) }</p>
						</div>
					</div>
				);
			}

			if ( hasRichData && richData.title ) {
				const descriptionOutput = !! description ? (
					<p class="ensemble-signet-description">{ description }</p>
				) : '';
				const titleOutput = !! title ? (
					<a href={ url } target="_blank" rel="noreferrer noopener" className="signet-url">
						<span className="ensemble-signet-title">{ title }</span>
					</a>
				) : '';

				return (
					<div { ...blockProps }>
						{ !! image && (
							<figure className="ensemble-signet-figure">
								<img src={ image } alt="" />
								<figcaption>
									{ titleOutput }
									{ descriptionOutput }
								</figcaption>
							</figure>
						) }

						{ ! image && (
							<div className="ensemble-signet-figure">
								{ titleOutput }
								{ descriptionOutput }
							</div>
						) }
					</div>
				);
			} else {
				return (
					<div { ...blockProps }>
						<p>{ __( 'Il n’a pas été possible de récupérer les informations nécessaires à l’aperçu de votre signet.', 'ensemble' ) }</p>
						<ExternalLink
							href={ url }
						>
							{ __( 'Accéder au signet.', 'ensemble' ) }
						</ExternalLink>
					</div>
				);
			}
		}
	},
	save: ( { attributes } ) => {
		const blockProps = useBlockProps.save();
		const { url, image, title, description } = attributes;
		const descriptionOutput = !! description ? (
			<p class="ensemble-signet-description">{ description }</p>
		) : '';
		const titleOutput = !! title ? (
			<a href={ url } target="_blank" rel="noreferrer noopener" className="signet-url">
				<span className="ensemble-signet-title">{ title }</span>
			</a>
		) : '';

		if ( ! url ) {
			return null;
		}

		return (
			<div { ...blockProps }>
				{ !! image && (
					<figure className="ensemble-signet-figure">
						<a href={ url } target="_blank" rel="noreferrer noopener">
							<img src={ image } alt="" />
						</a>
						<figcaption>
							{ titleOutput }
							{ descriptionOutput }
						</figcaption>
					</figure>
				) }

				{ ! image && (
					<div className="ensemble-signet-figure">
						{ titleOutput }
						{ descriptionOutput }
					</div>
				) }
			</div>
		);
	},
} );
