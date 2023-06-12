import{a as N,k as w,v as Q,m as X,r as o,o as l,b as i,d as t,e as n,x as P,F as c,h as f,f as d,i as C,u as S,t as g,g as T,L as Y,y as Z,c as V,z as R,q as ee,s as te}from"./app.caeeee48.js";const ne=(p,v)=>{const m=p.__vccOpts||p;for(const[k,_]of v)m[k]=_;return m},ae=p=>(ee("data-v-5394b915"),p=p(),te(),p),oe={class:"d-flex align-center"},le=ae(()=>T("span",{class:"d-none d-sm-flex"},"The Place for Banking Knowledge",-1)),se={key:0,class:"d-none d-sm-flex"},ie={class:"d-none d-sm-flex"},ue={key:0,class:"pa-2"},re={__name:"AppMenu",props:{canLogin:Boolean,canRegister:Boolean,laravelVersion:String,phpVersion:String},setup(p){const v=N(!1);let m=N([]);const k=N(w().props.value.themeName==="dark"?"night":"day"),_=Q(),F=[{title:"Home",path:"/",icon:"mdi-home",submenu:!1},{title:"Read",path:"#",icon:"mdi-braille",submenu:!0},{title:"Rates",path:"/rates",icon:"mdi-chart-bell-curve",submenu:!1},{title:"Loans",path:"/loans",icon:"mdi-account-cash",submenu:!1},{title:"Login",path:"/login",icon:"mdi-lock",submenu:!1},{title:"Register",path:"/register",icon:"mdi-account",submenu:!1}],U=[{title:"Home",path:"/dashboard",icon:"mdi-home"},{title:"Read",path:"#",icon:"mdi-braille",submenu:!0},{title:"Rates",path:"/rates",icon:"mdi-chart-bell-curve"},{title:"Loans",path:"/loans",icon:"mdi-account-cash"}],B=[{title:"Account",path:route("profile.edit"),icon:"mdi-account"},{title:"Favorites",path:"/favourites",icon:"mdi-heart"},{title:"Check Score",path:"/checkscore",icon:"mdi-bullseye-arrow"}],A=[{title:"Articles",path:"/articles",icon:"mdi-file-document-multiple"},{title:"Processes",path:"/processes",icon:"mdi-label-multiple"},{title:"Banking Words",path:"/bankingwords",icon:"mdi-alphabet-greek"}],b=a=>{window.location.href=a};function H(){_.global.name.value=_.global.current.value.dark?"day":"dark",axios.post("/updatesession",{key:"themeName",value:_.global.name.value}).then(a=>{})}X(()=>{_.global.name.value=w().props.value.themeName?w().props.value.themeName:"day",m=w().props.value.auth.user?U:F});function M(){R.Inertia.post("/logout")}function q(){R.Inertia.get("/pointpage")}return(a,s)=>{const z=o("v-app-bar-nav-icon"),D=o("v-avatar"),E=o("v-app-bar-title"),I=o("v-btn"),u=o("v-list-item"),h=o("v-list-item-title"),$=o("v-list"),x=o("v-menu"),L=o("v-icon"),K=o("v-chip"),O=o("v-switch"),W=o("v-app-bar"),j=o("v-divider"),G=o("v-list-group"),J=o("v-navigation-drawer");return l(),i(c,null,[t(W,{elevation:2},{append:n(()=>[a.$page.props.auth.user?(l(),i("div",se,[t(x,null,{activator:n(({props:e})=>[t(I,P({icon:"mdi-account-circle"},e),null,16)]),default:n(()=>[t($,null,{default:n(()=>[t(u,{lines:"two","prepend-avatar":a.$page.props.auth.user.profile_photo?a.$page.props.auth.user.profile_photo:"/img/blank-profile-picture.png",title:a.$page.props.auth.user.name,subtitle:a.$page.props.auth.user.email},null,8,["prepend-avatar","title","subtitle"]),(l(),i(c,null,f(B,(e,r)=>t(u,{key:r},{default:n(()=>[t(h,{onClick:y=>b(e.path)},{default:n(()=>[d(g(e.title),1)]),_:2},1032,["onClick"])]),_:2},1024)),64)),t(u,null,{default:n(()=>[t(h,{onClick:s[1]||(s[1]=e=>M())},{default:n(()=>[d("Logout")]),_:1})]),_:1}),t(u,null,{default:n(()=>[t(h,{onClick:s[2]||(s[2]=e=>q())},{default:n(()=>[d("Point")]),_:1})]),_:1})]),_:1})]),_:1})])):C("",!0),(l(!0),i(c,null,f(S(m),e=>(l(),i("div",ie,[(l(),V(I,{key:e.title,href:e.path},{default:n(()=>[d(g(e.title)+" ",1),e.submenu?(l(),V(x,{key:0,activator:"parent"},{default:n(()=>[t($,null,{default:n(()=>[(l(),i(c,null,f(A,(r,y)=>t(u,{key:y},{default:n(()=>[t(h,{onClick:pe=>b(r.path)},{default:n(()=>[d(g(r.title),1)]),_:2},1032,["onClick"])]),_:2},1024)),64))]),_:2},1024)]),_:2},1024)):C("",!0)]),_:2},1032,["href"]))]))),256)),t(K,{class:"mr-2"},{default:n(()=>[t(L,{start:"",icon:"mdi-theme-light-dark"}),d(" "+g(k.value),1)]),_:1}),t(O,{modelValue:k.value,"onUpdate:modelValue":s[3]||(s[3]=e=>k.value=e),"hide-details":"",inset:"","true-value":"night","false-value":"day",onClick:H},null,8,["modelValue"])]),default:n(()=>[t(z,{class:"d-flex d-sm-none",onClick:s[0]||(s[0]=e=>v.value=!v.value)}),t(E,{class:"pl-0"},{default:n(()=>[T("div",oe,[t(S(Y),{href:"/"},{default:n(()=>[t(D,{rounded:"0",class:"mr-3",image:"/img/logo.png"})]),_:1}),le])]),_:1})]),_:1}),t(J,{class:"d-flex d-sm-none",modelValue:v.value,"onUpdate:modelValue":s[5]||(s[5]=e=>v.value=e)},Z({append:n(()=>[a.$page.props.auth.user?(l(),i("div",ue,[t(I,{block:"",onClick:s[4]||(s[4]=e=>M())},{default:n(()=>[d(" Logout ")]),_:1})])):C("",!0)]),default:n(()=>[a.$page.props.auth.user?(l(),V(j,{key:0})):C("",!0),t($,{density:"compact",nav:""},{default:n(()=>[(l(!0),i(c,null,f(S(m),(e,r)=>(l(),i("div",{key:r},[e.submenu?C("",!0):(l(),V(u,{key:0,value:e,"active-color":"primary"},{prepend:n(()=>[t(L,{icon:e.icon},null,8,["icon"])]),default:n(()=>[t(h,{textContent:g(e.title),onClick:y=>b(e.path)},null,8,["textContent","onClick"])]),_:2},1032,["value"]))]))),128)),(l(),i(c,null,f(A,(e,r)=>t(u,{key:r,value:e,"active-color":"primary"},{prepend:n(()=>[t(L,{icon:e.icon},null,8,["icon"])]),default:n(()=>[t(h,{textContent:g(e.title),onClick:y=>b(e.path)},null,8,["textContent","onClick"])]),_:2},1032,["value"])),64))]),_:1}),t($,{density:"compact",nav:""},{default:n(()=>[t(G,{value:"Account"},{activator:n(({props:e})=>[t(u,P(e,{title:"Profile"}),null,16)]),default:n(()=>[(l(),i(c,null,f(B,(e,r)=>t(u,{key:r,value:e.title,title:e.title,"prepend-icon":e.icon,onClick:y=>b(e.path)},null,8,["value","title","prepend-icon","onClick"])),64))]),_:1})]),_:1})]),_:2},[a.$page.props.auth.user?{name:"prepend",fn:n(()=>[t(u,{lines:"two","prepend-avatar":a.$page.props.auth.user.profile_photo?a.$page.props.auth.user.profile_photo:"/img/blank-profile-picture.png",title:a.$page.props.auth.user.name,subtitle:a.$page.props.auth.user.email},null,8,["prepend-avatar","title","subtitle"])]),key:"0"}:void 0]),1032,["modelValue"])],64)}}},de=ne(re,[["__scopeId","data-v-5394b915"]]);export{de as A,ne as _};
