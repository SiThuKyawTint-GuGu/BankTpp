import{B as m,o as l,c as d,e as t,d as a,u as o,H as c,g as e,f as p,n as u,l as f}from"./app.caeeee48.js";import{_}from"./GuestLayout.4ead4ab5.js";import{_ as w,a as b,b as g}from"./TextInput.257cf170.js";import{_ as h}from"./PrimaryButton.65d698f2.js";import"./AppLayout.575085ec.js";import"./AppMenu.a3319549.js";const x=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),V=["onSubmit"],v={class:"flex justify-end mt-4"},H={__name:"ConfirmPassword",setup(y){const s=m({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(C,r)=>(l(),d(_,null,{default:t(()=>[a(o(c),{title:"Confirm Password"}),x,e("form",{onSubmit:f(i,["prevent"])},[e("div",null,[a(w,{for:"password",value:"Password"}),a(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(s).password,"onUpdate:modelValue":r[0]||(r[0]=n=>o(s).password=n),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),a(g,{class:"mt-2",message:o(s).errors.password},null,8,["message"])]),e("div",v,[a(h,{class:u(["ml-4",{"opacity-25":o(s).processing}]),disabled:o(s).processing},{default:t(()=>[p(" Confirm ")]),_:1},8,["class","disabled"])])],40,V)]),_:1}))}};export{H as default};
