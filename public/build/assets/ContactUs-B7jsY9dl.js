import{N as T,M as j,g as m,h as b,_ as U,u as E,b as I,r as q,c as p,o as B,Z as k,j as e,i as F,l as g,t as n,z as u,H as R,m as x,F as L,k as A,x as z,S as C}from"./app-Dg7zKWM_.js";import{a as N,s as v}from"./index-B7InJ2YD.js";import{f as W}from"./index-ZhWAdK_X.js";import"./index-QBm_MoiA.js";var O=`
    .p-textarea {
        font-family: inherit;
        font-feature-settings: inherit;
        font-size: 1rem;
        color: dt('textarea.color');
        background: dt('textarea.background');
        padding-block: dt('textarea.padding.y');
        padding-inline: dt('textarea.padding.x');
        border: 1px solid dt('textarea.border.color');
        transition:
            background dt('textarea.transition.duration'),
            color dt('textarea.transition.duration'),
            border-color dt('textarea.transition.duration'),
            outline-color dt('textarea.transition.duration'),
            box-shadow dt('textarea.transition.duration');
        appearance: none;
        border-radius: dt('textarea.border.radius');
        outline-color: transparent;
        box-shadow: dt('textarea.shadow');
    }

    .p-textarea:enabled:hover {
        border-color: dt('textarea.hover.border.color');
    }

    .p-textarea:enabled:focus {
        border-color: dt('textarea.focus.border.color');
        box-shadow: dt('textarea.focus.ring.shadow');
        outline: dt('textarea.focus.ring.width') dt('textarea.focus.ring.style') dt('textarea.focus.ring.color');
        outline-offset: dt('textarea.focus.ring.offset');
    }

    .p-textarea.p-invalid {
        border-color: dt('textarea.invalid.border.color');
    }

    .p-textarea.p-variant-filled {
        background: dt('textarea.filled.background');
    }

    .p-textarea.p-variant-filled:enabled:hover {
        background: dt('textarea.filled.hover.background');
    }

    .p-textarea.p-variant-filled:enabled:focus {
        background: dt('textarea.filled.focus.background');
    }

    .p-textarea:disabled {
        opacity: 1;
        background: dt('textarea.disabled.background');
        color: dt('textarea.disabled.color');
    }

    .p-textarea::placeholder {
        color: dt('textarea.placeholder.color');
    }

    .p-textarea.p-invalid::placeholder {
        color: dt('textarea.invalid.placeholder.color');
    }

    .p-textarea-fluid {
        width: 100%;
    }

    .p-textarea-resizable {
        overflow: hidden;
        resize: none;
    }

    .p-textarea-sm {
        font-size: dt('textarea.sm.font.size');
        padding-block: dt('textarea.sm.padding.y');
        padding-inline: dt('textarea.sm.padding.x');
    }

    .p-textarea-lg {
        font-size: dt('textarea.lg.font.size');
        padding-block: dt('textarea.lg.padding.y');
        padding-inline: dt('textarea.lg.padding.x');
    }
`,G={root:function(t){var r=t.instance,l=t.props;return["p-textarea p-component",{"p-filled":r.$filled,"p-textarea-resizable ":l.autoResize,"p-textarea-sm p-inputfield-sm":l.size==="small","p-textarea-lg p-inputfield-lg":l.size==="large","p-invalid":r.$invalid,"p-variant-filled":r.$variant==="filled","p-textarea-fluid":r.$fluid}]}},J=T.extend({name:"textarea",style:O,classes:G}),K={name:"BaseTextarea",extends:N,props:{autoResize:Boolean},style:J,provide:function(){return{$pcTextarea:this,$parentInstance:this}}};function f(o){"@babel/helpers - typeof";return f=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(t){return typeof t}:function(t){return t&&typeof Symbol=="function"&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},f(o)}function Y(o,t,r){return(t=Z(t))in o?Object.defineProperty(o,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):o[t]=r,o}function Z(o){var t=Q(o,"string");return f(t)=="symbol"?t:t+""}function Q(o,t){if(f(o)!="object"||!o)return o;var r=o[Symbol.toPrimitive];if(r!==void 0){var l=r.call(o,t);if(f(l)!="object")return l;throw new TypeError("@@toPrimitive must return a primitive value.")}return(t==="string"?String:Number)(o)}var S={name:"Textarea",extends:K,inheritAttrs:!1,observer:null,mounted:function(){var t=this;this.autoResize&&(this.observer=new ResizeObserver(function(){requestAnimationFrame(function(){t.resize()})}),this.observer.observe(this.$el))},updated:function(){this.autoResize&&this.resize()},beforeUnmount:function(){this.observer&&this.observer.disconnect()},methods:{resize:function(){if(this.$el.offsetParent){var t=this.$el.style.height,r=parseInt(t)||0,l=this.$el.scrollHeight,h=!r||l>r,d=r&&l<r;d?(this.$el.style.height="auto",this.$el.style.height="".concat(this.$el.scrollHeight,"px")):h&&(this.$el.style.height="".concat(l,"px"))}},onInput:function(t){this.autoResize&&this.resize(),this.writeValue(t.target.value,t)}},computed:{attrs:function(){return j(this.ptmi("root",{context:{filled:this.$filled,disabled:this.disabled}}),this.formField)},dataP:function(){return W(Y({invalid:this.$invalid,fluid:this.$fluid,filled:this.$variant==="filled"},this.size,this.size))}}},X=["value","name","disabled","aria-invalid","data-p"];function ee(o,t,r,l,h,d){return b(),m("textarea",j({class:o.cx("root"),value:o.d_value,name:o.name,disabled:o.disabled,"aria-invalid":o.invalid||void 0,"data-p":d.dataP,onInput:t[0]||(t[0]=function(){return d.onInput&&d.onInput.apply(d,arguments)})},d.attrs),null,16,X)}S.render=ee;const te={class:"min-h-screen bg-slate-50"},ae={class:"relative pt-32 pb-24 bg-slate-900 overflow-hidden"},se={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center"},oe={class:"inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-400 text-sm font-semibold tracking-wide mb-6"},re={class:"text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight",style:{"font-family":"'Lexend', sans-serif"}},ne={class:"text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600"},le={class:"text-lg text-slate-300 max-w-2xl mx-auto font-light leading-relaxed"},ie={class:"py-16 -mt-16 relative z-20"},de={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},ce={class:"grid grid-cols-1 lg:grid-cols-3 gap-8"},ue={class:"lg:col-span-1 space-y-6"},pe={class:"bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1"},me={class:"text-xl font-bold text-slate-900 mb-1"},be={class:"text-sm text-slate-500 mb-3"},fe=["href"],he={class:"bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1"},xe={class:"text-xl font-bold text-slate-900 mb-1"},ge={class:"text-sm text-slate-500 mb-3"},ve=["href"],ye={class:"bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col items-start gap-4 transition-transform duration-300 hover:-translate-y-1"},_e={class:"text-xl font-bold text-slate-900 mb-1"},we={class:"text-sm text-slate-500 mb-3"},$e={class:"text-base font-medium text-slate-700 leading-relaxed"},ke={class:"lg:col-span-2"},ze={class:"bg-white rounded-3xl shadow-xl shadow-slate-200/40 p-8 md:p-12 border border-slate-100 h-full flex flex-col justify-center"},Ce={class:"mb-8"},je={class:"text-3xl font-extrabold text-slate-900 mb-2",style:{"font-family":"'Lexend', sans-serif"}},Se={class:"text-slate-500"},Ve={class:"grid grid-cols-1 md:grid-cols-2 gap-6"},De={class:"space-y-2"},Pe={class:"text-sm font-semibold text-slate-700"},Me={class:"space-y-2"},He={class:"text-sm font-semibold text-slate-700"},Te={class:"space-y-2"},Ue={class:"text-sm font-semibold text-slate-700"},Ee={class:"space-y-2"},Ie={class:"text-sm font-semibold text-slate-700"},qe={class:"pt-4"},Be={type:"submit",class:"w-full md:w-auto px-10 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.3)] hover:-translate-y-0.5 hover:shadow-[0_0_30px_rgba(249,115,22,0.5)] transition-all duration-300"},Fe={class:"py-16 md:py-24 bg-white border-t border-slate-100"},Re={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},Le={class:"text-center mb-16"},Ae={class:"text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight",style:{"font-family":"'Lexend', sans-serif"}},Ne={class:"text-lg text-slate-500 max-w-2xl mx-auto"},We={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"},Oe={class:"text-xl font-bold text-slate-900 mb-3"},Ge={class:"text-slate-600 leading-relaxed"},Je={key:0,class:"py-12 border-t border-slate-100 bg-slate-50"},Ke={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},Ye={class:"bg-white p-2.5 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100"},Ze=["innerHTML"],Qe={__name:"ContactUs",setup(o){const{t}=E(),r=I(),l=q({name:"",email:"",subject:"",message:""}),h=p(()=>{var a;return((a=r.masterData)==null?void 0:a.contact_offers_title)||t("Why Partner With Us?")}),d=p(()=>{var a;return((a=r.masterData)==null?void 0:a.contact_offers_description)||t("Discover how our specialized tech training and robust placement cell can catapult your career to the next level.")});p(()=>{var a;return((a=r.masterData)==null?void 0:a.contact_offers_icon)||"pi pi-graduation-cap"}),p(()=>{var a;return((a=r.masterData)==null?void 0:a.contact_offers_image)||""});const V=p(()=>{var a,s;return((a=r.masterData)==null?void 0:a.head_office_address)||((s=r.masterData)==null?void 0:s.footer_description)||t("Our head office address will be updated soon. Please contact us by phone or email.")}),y=p(()=>{var s,c;return((c=(s=r.masterData)==null?void 0:s.google_map)==null?void 0:c.trim())||""}),D=p(()=>[{icon:"bi bi-briefcase-fill",iconClass:"text-orange-600",bgClass:"bg-orange-100",title:t("100% Placement Assistance"),description:t("We don't just teach. We ensure you land a top-tier job with our dedicated placement cell.")},{icon:"bi bi-person-workspace",iconClass:"text-cyan-600",bgClass:"bg-cyan-100",title:t("Expert Industry Mentors"),description:t("Learn directly from professionals working at product-based tech companies.")},{icon:"bi bi-code-slash",iconClass:"text-purple-600",bgClass:"bg-purple-100",title:t("Real-World Projects"),description:t("Build a robust portfolio by working on live projects that mirror industry demands.")},{icon:"bi bi-award-fill",iconClass:"text-emerald-600",bgClass:"bg-emerald-100",title:t("Recognized Certification"),description:t("Earn credentials that hold weight and instantly boost your resume's value.")},{icon:"bi bi-people-fill",iconClass:"text-blue-600",bgClass:"bg-blue-100",title:t("Mock Interviews"),description:t("Practice with HR experts and technical leads to conquer real interviews with confidence.")},{icon:"bi bi-shield-check",iconClass:"text-rose-600",bgClass:"bg-rose-100",title:t("Lifetime Career Support"),description:t("Gain lifelong access to our alumni network, exclusive job boards, and career coaching.")}]),P=()=>{l.value={name:"",email:"",subject:"",message:""}};B(async()=>{var a;if(!((a=r.masterData)!=null&&a.google_map))try{const s=await k.get("/master",{headers:{"Content-Type":"application/json",Accept:"application/json"}});r.setMasterData(s.data.data.master)}catch(s){console.error("Error fetching master data:",s)}});const M=async()=>{var a,s;try{(await k.post("/contact/submit",l.value,{headers:{"Content-Type":"application/json",Accept:"application/json"}})).status===201&&(C.fire({position:"top-end",icon:"success",title:t("Your inquiry has been submitted"),showConfirmButton:!1,timer:1500,customClass:{title:"swal-title"}}),P())}catch(c){C.fire({icon:"error",title:`Error submitting form:, ${(s=(a=c.response)==null?void 0:a.data)==null?void 0:s.message}`,showConfirmButton:!1,timer:3500,customClass:{title:"swal-title"}}),console.error("Error submitting form:",c)}};return(a,s)=>{var c,_,w,$;return b(),m("div",te,[e("section",ae,[s[5]||(s[5]=e("div",{class:"absolute inset-0 pointer-events-none",style:{background:"radial-gradient(circle at 50% 0%, rgba(249,115,22,0.15) 0%, transparent 70%)"}},null,-1)),e("div",se,[e("span",oe,[s[4]||(s[4]=e("i",{class:"bi bi-headset"},null,-1)),g(" "+n(a.$t("We're Here to Help")),1)]),e("h1",re,[g(n(a.$t("Get in"))+" ",1),e("span",ne,n(a.$t("Touch")),1)]),e("p",le,n(a.$t("Have questions about our programs, corporate training, or placement support? Our team is ready to help you launch your tech career.")),1)])]),e("section",ie,[e("div",de,[e("div",ce,[e("div",ue,[e("div",pe,[s[6]||(s[6]=e("div",{class:"w-14 h-14 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center text-2xl mb-2"},[e("i",{class:"bi bi-telephone-fill"})],-1)),e("div",null,[e("h3",me,n(a.$t("Call Us")),1),e("p",be,n(a.$t("Mon-Fri from 9am to 6pm.")),1),e("a",{href:`tel:${(c=u(r).masterData)==null?void 0:c.footer_contact}`,class:"text-lg font-semibold text-orange-600 hover:text-orange-700 transition-colors"},n(((_=u(r).masterData)==null?void 0:_.footer_contact)||"+91 00000 00000"),9,fe)])]),e("div",he,[s[7]||(s[7]=e("div",{class:"w-14 h-14 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-2"},[e("i",{class:"bi bi-envelope-fill"})],-1)),e("div",null,[e("h3",xe,n(a.$t("Email Us")),1),e("p",ge,n(a.$t("We usually respond within 24 hours.")),1),e("a",{href:`mailto:${(w=u(r).masterData)==null?void 0:w.footer_email}`,class:"text-lg font-semibold text-cyan-600 hover:text-cyan-700 transition-colors"},n((($=u(r).masterData)==null?void 0:$.footer_email)||"hello@edutantr.com"),9,ve)])]),e("div",ye,[s[8]||(s[8]=e("div",{class:"w-14 h-14 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-2"},[e("i",{class:"bi bi-geo-alt-fill"})],-1)),e("div",null,[e("h3",_e,n(a.$t("Visit Us")),1),e("p",we,n(a.$t("Drop by our headquarters.")),1),e("p",$e,n(V.value),1)])])]),e("div",ke,[e("div",ze,[e("div",Ce,[e("h2",je,n(a.$t("Send a Message")),1),e("p",Se,n(a.$t("Fill out the form below and our placement experts will get back to you shortly.")),1)]),e("form",{onSubmit:R(M,["prevent"]),class:"space-y-6"},[e("div",Ve,[e("div",De,[e("label",Pe,n(a.$t("Full Name"))+" *",1),x(u(v),{modelValue:l.value.name,"onUpdate:modelValue":s[0]||(s[0]=i=>l.value.name=i),class:"w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all",placeholder:a.$t("John Doe"),required:""},null,8,["modelValue","placeholder"])]),e("div",Me,[e("label",He,n(a.$t("Email Address"))+" *",1),x(u(v),{modelValue:l.value.email,"onUpdate:modelValue":s[1]||(s[1]=i=>l.value.email=i),type:"email",class:"w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all",placeholder:a.$t("john@example.com"),required:""},null,8,["modelValue","placeholder"])])]),e("div",Te,[e("label",Ue,n(a.$t("Subject"))+" *",1),x(u(v),{modelValue:l.value.subject,"onUpdate:modelValue":s[2]||(s[2]=i=>l.value.subject=i),class:"w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all",placeholder:a.$t("How can we help?"),required:""},null,8,["modelValue","placeholder"])]),e("div",Ee,[e("label",Ie,n(a.$t("Message"))+" *",1),x(u(S),{modelValue:l.value.message,"onUpdate:modelValue":s[3]||(s[3]=i=>l.value.message=i),rows:"5",class:"w-full !p-4 !rounded-xl !border-slate-200 !bg-slate-50 focus:!bg-white focus:!border-orange-400 focus:!ring-orange-400/20 transition-all",placeholder:a.$t("Tell us more about your inquiry..."),required:""},null,8,["modelValue","placeholder"])]),e("div",qe,[e("button",Be,[s[9]||(s[9]=e("i",{class:"bi bi-send-fill mr-2"},null,-1)),g(" "+n(a.$t("Send Message")),1)])])],32)])])])])]),e("section",Fe,[e("div",Re,[e("div",Le,[e("h2",Ae,n(h.value),1),e("p",Ne,n(d.value),1)]),e("div",We,[(b(!0),m(L,null,A(D.value,(i,H)=>(b(),m("div",{key:H,class:"bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"},[e("div",{class:z(["w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm border border-black/5",i.bgClass,i.iconClass])},[e("i",{class:z(i.icon)},null,2)],2),e("h3",Oe,n(i.title),1),e("p",Ge,n(i.description),1)]))),128))])])]),y.value?(b(),m("section",Je,[e("div",Ke,[e("div",Ye,[e("div",{class:"rounded-[1.5rem] overflow-hidden [&>iframe]:w-full [&>iframe]:h-[450px]",innerHTML:y.value},null,8,Ze)])])])):F("",!0)])}}},st=U(Qe,[["__scopeId","data-v-10a015f1"]]);export{st as default};
