import{n as L,A as V}from"./AppLayout.575085ec.js";import{r as s,o as a,c as d,e,d as o,b as g,F as y,h as x,f as w,t as v,g as p,u as c,a as k,m as $,H as A}from"./app.caeeee48.js";import{a as N}from"./MaterialStatsCard.238f91a8.js";import{B as z}from"./BankExchangeCard.53d4ada9.js";import"./AppMenu.a3319549.js";const E={class:"text-h2 mr-1"},F={class:"text-subtitle-1 font-weight-light mr-1"},H={__name:"CurrencyList",props:{currency:Array},setup(h){return(n,m)=>{const l=s("v-icon"),b=s("v-card-item"),r=s("v-col"),u=s("v-row"),_=s("v-card-text"),f=s("v-card"),t=s("v-sheet"),B=s("v-container");return a(),d(B,{class:"bg-secondary"},{default:e(()=>[o(u,{"no-gutters":""},{default:e(()=>[(a(!0),g(y,null,x(h.currency,(i,C)=>(a(),d(r,{key:C,cols:"12",sm:"4"},{default:e(()=>[o(t,{class:"ma-2 pa-2"},{default:e(()=>[o(f,{class:"mx-auto","max-width":"368"},{default:e(()=>[o(b,{title:i.title},{subtitle:e(()=>[o(l,{icon:"mdi-alert",size:"18",color:"error",class:"mr-1 pb-1"}),w(" last updated: "+v(i.lastupdateon),1)]),_:2},1032,["title"]),o(_,{class:"py-0"},{default:e(()=>[o(u,{align:"center","no-gutters":""},{default:e(()=>[o(r,{cols:"8"},{default:e(()=>[p("span",E,v(c(L)(i.amount)),1),p("span",F,v(i.notation),1)]),_:2},1024),o(r,{cols:"4",class:"text-right"},{default:e(()=>[o(l,{color:"error",icon:i.icon,size:"88"},null,8,["icon"])]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024)]),_:2},1024))),128))]),_:1})]),_:1})}}},M={id:"currency"},R={id:"banklist"},S={id:"infocards"},G={__name:"Rates",setup(h){let n=k([]);return k([]),$(()=>{let m="rates";axios.get(`/api/pages/${m}`).then(l=>{l.status&&(n.value=l.data.pagetext)})}),(m,l)=>{const b=s("v-alert"),r=s("v-col"),u=s("v-row"),_=s("v-container"),f=s("v-divider");return a(),d(V,null,{default:e(()=>[o(c(A),{title:"Bank Rates"}),o(b,{border:"start",color:"primary",density:"compact",icon:"mdi-clock-fast",title:c(n).title,variant:"elevated"},{default:e(()=>[w(v(c(n).subtitle),1)]),_:1},8,["title"]),p("section",M,[o(H,{currency:c(n).itemList3},null,8,["currency"])]),p("section",R,[o(_,null,{default:e(()=>[o(u,null,{default:e(()=>[(a(!0),g(y,null,x(c(n).itemList1,t=>(a(),d(r,{cols:"12",sm:"6",lg:"3",key:t.title},{default:e(()=>[o(z,{color:t.color,avatar:t.avatar,icon:t.icon,buyusd:t.buyusd,sellusd:t.sellusd,buysgd:t.buysgd,sellsgd:t.sellsgd,"sub-icon":t.subicon,"sub-icon-color":t.subiconcolor,"sub-text":t.subtext},null,8,["color","avatar","icon","buyusd","sellusd","buysgd","sellsgd","sub-icon","sub-icon-color","sub-text"])]),_:2},1024))),128))]),_:1})]),_:1})]),o(_,null,{default:e(()=>[o(f,{class:"my-2"})]),_:1}),p("section",S,[o(_,null,{default:e(()=>[o(u,null,{default:e(()=>[(a(!0),g(y,null,x(c(n).itemList2,t=>(a(),d(r,{cols:"12",sm:"6",lg:"3",key:t.title},{default:e(()=>[o(N,{color:t.color,avatar:t.avatar,icon:t.icon,title:t.title,value:t.value,smallValue:t.smallValue,"sub-icon":t.subicon,"sub-icon-color":t.subiconcolor,"sub-text":t.subtext},null,8,["color","avatar","icon","title","value","smallValue","sub-icon","sub-icon-color","sub-text"])]),_:2},1024))),128))]),_:1})]),_:1})])]),_:1})}}};export{G as default};
