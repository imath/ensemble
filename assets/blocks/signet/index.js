(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,n=window.wp.blocks,r=window.wp.coreData,i=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"ensemble/signet","title":"Signet","category":"embed","icon":"pressthis","description":"Embarque une visualisation du lien","textdomain":"ensemble","attributes":{"url":{"type":"string","__experimentalRole":"content"},"align":{"type":"string","default":"center"}},"supports":{"align":["left","right","center"],"html":false,"spacing":{"margin":true,"padding":true}}}');function s(e,t){switch(t.type){case"RESOLVED":return{...e,isFetching:!1,richData:t.richData};case"ERROR":return{...e,isFetching:!1,richData:null};case"LOADING":return{...e,isFetching:!0};default:throw new Error(`Unexpected action type ${t.type}`)}}(0,n.registerBlockType)(i,{edit:()=>{const n=(0,t.useBlockProps)(),{richData:i,isFetching:a}=function(t){const[n,i]=(0,e.useReducer)(s,{richData:null,isFetching:!1});return(0,e.useEffect)((()=>{if(t&&t.length){i({type:"LOADING"});const e=new window.AbortController,n=e.signal;return(0,r.__experimentalFetchUrlData)(t,{signal:n}).then((e=>{i({type:"RESOLVED",richData:e})})).catch((()=>{n.aborted||i({type:"ERROR"})})),()=>{e.abort()}}}),[t]),n}("https://wordpress.org/news/2023/08/lionel/");return i&&Object.keys(i).length,(0,e.createElement)("div",n,(0,e.createElement)("p",null,"Hello world"))},save:()=>null})})();