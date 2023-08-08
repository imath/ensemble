(()=>{"use strict";const t=window.wp.element,e=window.lodash,o=window.wp.blockEditor,s=window.wp.blocks,r=window.wp.coreData,a=window.wp.data,n=(window.wp.i18n,JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"ensemble/post-format-template","title":"Gabarit des formats d’article","category":"theme","icon":"layout","description":"Vérifie si le format est à appliquer","textdomain":"ensemble","attributes":{"format":{"type":"string","default":"standard"}},"usesContext":["postId","postType"],"supports":{"align":["left","right","center","wide","full"],"html":false,"spacing":{"margin":true,"padding":true}}}'));function i(e){let{template:s}=e;const r=(0,o.useInnerBlocksProps)({className:"wp-block-post-format"},{template:s,__unstableDisableLayoutClassNames:!0});return(0,t.createElement)("div",r)}(0,s.registerBlockType)(n,{edit:s=>{let{attributes:n,context:l}=s;const p=(0,o.useBlockProps)(),{format:c}=n,{postId:d}=l;if("standard"!==c){const o="post-format-"+c,{postFormats:s,isLoading:n}=(0,a.useSelect)((t=>{const{getEntityRecords:e,isResolving:o}=t(r.store),s=["taxonomy","post_format",{post:d,per_page:-1,context:"view"}];return{postFormats:e(...s),isLoading:o("getEntityRecords",s)}}),[d]);if(!1===n&&(0,e.find)(s,["slug",o])){const e=[["core/post-title"]];return(0,t.createElement)("div",p,(0,t.createElement)(i,{template:e}))}return null}{const e=[["core/post-title"],["core/post-date"],["core/post-excerpt"]];return(0,t.createElement)("div",p,(0,t.createElement)(i,{template:e}))}}})})();