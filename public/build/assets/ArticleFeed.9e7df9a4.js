import{_ as F}from"./FeedCard.a94bcc17.js";import{a as h,A as k,w as N,r,o as n,c as s,e as t,d as a,p as S,b as $,F as V,h as q,u as l,j as x,f as p,i as _,t as w}from"./app.caeeee48.js";const P={__name:"ArticleFeed",props:{articles:Array,itemtype:String,hidepagenav:Boolean,titlebgcolor:String},setup(c){const v=c,A=h([2,2,1,2,2,3,3,3,3,3,3]);let e=h(1);const d=k(()=>Math.ceil(v.articles.length/11)),C=k({get(){const i=(e.value-1)*11,o=e.value*11;return v.articles.slice(i,o)}});return N(e,i=>{window.scrollTo(0,0)}),(i,o)=>{const u=r("v-col"),f=r("v-row"),g=r("v-icon"),y=r("v-btn"),B=r("v-container");return n(),s(B,null,{default:t(()=>[a(f,null,{default:t(()=>[a(u,{cols:"12"},{default:t(()=>[S(i.$slots,"default")]),_:3}),(n(!0),$(V,null,q(l(C),(m,b)=>(n(),s(F,{key:m.title,currentindex:b+11*(l(e)-1),size:A.value[b],article:m,itemtype:c.itemtype,titlebgcolor:c.titlebgcolor},null,8,["currentindex","size","article","itemtype","titlebgcolor"]))),128))]),_:3}),c.hidepagenav?_("",!0):(n(),s(f,{key:0,align:"center"},{default:t(()=>[a(u,{cols:"3"},{default:t(()=>[l(e)!==1?(n(),s(y,{key:0,color:"primary",fab:"",small:"",class:"ml-0",square:"",title:"Previous page",onClick:o[0]||(o[0]=m=>x(e)?e.value--:e--)},{default:t(()=>[a(g,null,{default:t(()=>[p("mdi-chevron-left")]),_:1})]),_:1})):_("",!0)]),_:1}),a(u,{class:"text-center subheading",cols:"6"},{default:t(()=>[p(" PAGE "+w(l(e))+" OF "+w(l(d)),1)]),_:1}),a(u,{class:"text-right",cols:"3"},{default:t(()=>[l(d)>1&&l(e)<l(d)?(n(),s(y,{key:0,color:"primary",fab:"",small:"",class:"mr-0",square:"",title:"Next page",onClick:o[1]||(o[1]=m=>x(e)?e.value++:e++)},{default:t(()=>[a(g,null,{default:t(()=>[p("mdi-chevron-right")]),_:1})]),_:1})):_("",!0)]),_:1})]),_:1}))]),_:3})}}};export{P as _};
