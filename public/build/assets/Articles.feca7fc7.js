import{r as H,A as I}from"./AppLayout.575085ec.js";import{a as p,A as R,r as l,o as c,b as m,d as o,e as n,u as i,j as f,F as v,h as x,c as y,f as k,t as g,H as U,p as j,g as q}from"./app.caeeee48.js";import{_ as D}from"./PaginatedFeed.3393c4a9.js";import"./AppMenu.a3319549.js";import"./FeedCard.a94bcc17.js";const P={__name:"ArticleAPISearchBar",setup(b){let a=p(!1);const h=2e3,_="No record found";let u=p([]),s=p("");const V=R({get(){if(s.value==="")return[];const r=[];for(const t of u.value)r.includes(t.category)||r.push(t.category);return r}});function A(){if(s.value==="")return[];const r=s.value.trim();axios.post("/api/searcharticle",{q:r}).then(t=>{t.status&&(u.value=t.data.articles,t.data.totalcount==0&&(a.value=!0))}).catch(t=>{console.log("Error - "+t)})}function C(){s.value="",u.value=[]}return(r,t)=>{const B=l("v-text-field"),S=l("v-chip"),N=l("v-card-text"),$=l("v-list-item"),w=l("v-list"),L=l("v-container"),E=l("v-btn"),F=l("v-snackbar");return c(),m(v,null,[o(L,{class:"py-0 my-0"},{default:n(()=>[o(B,{modelValue:i(s),"onUpdate:modelValue":t[0]||(t[0]=e=>f(s)?s.value=e:s=e),density:"compact",variant:"solo",label:"Search your topic...","append-inner-icon":"mdi-close-circle","append-icon":"mdi-magnify","single-line":"","hide-details":"","onClick:append":A,"onClick:appendInner":C},null,8,["modelValue"]),o(N,{class:"pt-1"},{default:n(()=>[(c(!0),m(v,null,x(i(V),(e,d)=>(c(),y(S,{key:d,class:"mr-2 mt-2"},{default:n(()=>[k(g(e),1)]),_:2},1024))),128))]),_:1}),o(w,{class:"pt-1"},{default:n(()=>[(c(!0),m(v,null,x(i(u),(e,d)=>(c(),y($,{key:d,"prepend-avatar":`../assets/articles/${e.image}`,title:e.title,subtitle:e.author,onClick:z=>i(H)(e.article_id)},null,8,["prepend-avatar","title","subtitle","onClick"]))),128))]),_:1})]),_:1}),o(F,{modelValue:i(a),"onUpdate:modelValue":t[2]||(t[2]=e=>f(a)?a.value=e:a=e),timeout:h},{actions:n(()=>[o(E,{color:"info",variant:"text",onClick:t[1]||(t[1]=e=>f(a)?a.value=!1:a=!1)},{default:n(()=>[k(" Close ")]),_:1})]),default:n(()=>[k(g(_)+" ")]),_:1},8,["modelValue"])],64)}}},T=q("div",{class:"my-2"},null,-1),Q={__name:"Articles",setup(b){return(a,h)=>{const _=l("v-container");return c(),y(I,null,{default:n(()=>[o(i(U),{title:"Articles"}),o(_,null,{default:n(()=>[T]),_:1}),o(P),o(D,null,{default:n(()=>[j(a.$slots,"default")]),_:3})]),_:3})}}};export{Q as default};
