import{o as u,b as w,p as _,w as $,m as C,J as B,A as D,c as S,d as a,e as r,C as m,D as f,g as e,T as p,n as v,u as c,i as V,K as E,a as x,B as U,M as A,f as y,N}from"./app.caeeee48.js";import{_ as T,a as K,b as M}from"./TextInput.257cf170.js";const F=["type"],g={__name:"DangerButton",props:{type:{type:String,default:"submit"}},setup(o){return(n,s)=>(u(),w("button",{type:o.type,class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"},[_(n.$slots,"default")],8,F))}},O={class:"fixed inset-14 overflow-y-auto py-6 sm:px-0 z-50","scroll-region":""},P=e("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1),W=[P],z={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(o,{emit:n}){const s=o;$(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const t=()=>{s.closeable&&n("close")},i=l=>{l.key==="Escape"&&s.show&&t()};C(()=>document.addEventListener("keydown",i)),B(()=>{document.removeEventListener("keydown",i),document.body.style.overflow=null});const d=D(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(l,b)=>(u(),S(E,{to:"body"},[a(p,{"leave-active-class":"duration-200"},{default:r(()=>[m(e("div",O,[a(p,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:r(()=>[m(e("div",{class:"fixed inset-0 transform transition-all",onClick:t},W,512),[[f,o.show]])]),_:1}),a(p,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[m(e("div",{class:v(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",c(d)])},[o.show?_(l.$slots,"default",{key:0}):V("",!0)],2),[[f,o.show]])]),_:3})],512),[[f,o.show]])]),_:3})]))}},I=["type"],L={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(o){return(n,s)=>(u(),w("button",{type:o.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"},[_(n.$slots,"default")],8,I))}},j={class:"space-y-6"},J=e("header",null,[e("h2",{class:"text-lg font-medium text-gray-900"},"Delete Account"),e("p",{class:"mt-1 text-sm text-gray-600"},"Once your account is deleted, all of its resources and data will be permanently deleted.")],-1),q={class:"p-6"},G=e("h2",{class:"text-lg font-medium text-gray-900"},"Are you sure your want to delete your account?",-1),H=e("p",{class:"mt-1 text-sm text-gray-600"},"Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.",-1),Q={class:"mt-6"},R={class:"mt-6 flex justify-end"},Z={__name:"DeleteUserForm",setup(o){const n=x(!1),s=x(null),t=U({password:""}),i=()=>{n.value=!0,A(()=>s.value.focus())},d=()=>{t.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>l(),onError:()=>s.value.focus(),onFinish:()=>t.reset()})},l=()=>{n.value=!1,t.reset()};return(b,h)=>(u(),w("section",j,[J,a(g,{onClick:i},{default:r(()=>[y("Delete Account")]),_:1}),a(z,{show:n.value,onClose:l},{default:r(()=>[e("div",q,[G,H,e("div",Q,[a(T,{for:"password",value:"Password",class:"sr-only"}),a(K,{id:"password",ref_key:"passwordInput",ref:s,modelValue:c(t).password,"onUpdate:modelValue":h[0]||(h[0]=k=>c(t).password=k),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:N(d,["enter"])},null,8,["modelValue","onKeyup"]),a(M,{message:c(t).errors.password,class:"mt-2"},null,8,["message"])]),e("div",R,[a(L,{onClick:l},{default:r(()=>[y(" Cancel ")]),_:1}),a(g,{class:v(["ml-3",{"opacity-25":c(t).processing}]),disabled:c(t).processing,onClick:d},{default:r(()=>[y(" Delete Account ")]),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{Z as default};
