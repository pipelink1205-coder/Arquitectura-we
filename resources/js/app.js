/*
 * Arquitectura y Construcciones WE — interacciones de la página principal.
 * Navegación, contadores, cintas de obra, filtros, visor de fotos y formulario.
 */
document.addEventListener('DOMContentLoaded',function(){
  'use strict';
  var $=function(id){return document.getElementById(id)};
  var reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- Menú móvil (antes del scroll: onScroll lo referencia) ---- */
  var menu=$('menu'),burger=$('burger');
  if(!menu||!burger)return;

  /* ---- Scroll: nav sólida, barra de progreso, botón arriba ---- */
  var nav=$('nav'),pg=$('pg'),up=$('arriba'),ticking=false;
  function onScroll(){
    var y=scrollY,h=document.documentElement.scrollHeight-innerHeight;
    if(nav)nav.classList.toggle('solid',y>30||menu.classList.contains('open'));
    if(pg)pg.style.transform='scaleX('+(h>0?Math.min(y/h,1):0)+')';
    if(up)up.classList.toggle('on',y>innerHeight*1.2);
    ticking=false;
  }
  addEventListener('scroll',function(){if(!ticking){ticking=true;requestAnimationFrame(onScroll)}},{passive:true});
  if(up)up.addEventListener('click',function(){scrollTo({top:0,behavior:reduce?'auto':'smooth'})});

  function setMenu(open){
    menu.classList.toggle('open',open);
    burger.setAttribute('aria-expanded',open);
    burger.setAttribute('aria-label',open?'Cerrar menú':'Abrir menú');
    document.body.style.overflow=open?'hidden':'';
    onScroll();
  }
  burger.addEventListener('click',function(){setMenu(!menu.classList.contains('open'))});
  menu.addEventListener('click',function(e){if(e.target.closest('a'))setMenu(false)});
  addEventListener('keydown',function(e){if(e.key==='Escape'&&menu.classList.contains('open')){setMenu(false);burger.focus()}});
  matchMedia('(min-width:901px)').addEventListener('change',function(m){if(m.matches)setMenu(false)});
  onScroll();

  /* ---- Sección activa en el menú ---- */
  var links=[].slice.call(menu.querySelectorAll('a[href^="#"]'));
  if('IntersectionObserver' in window){
    var spy=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting)links.forEach(function(a){a.classList.toggle('act',a.getAttribute('href')==='#'+e.target.id)})})},{rootMargin:'-45% 0px -50% 0px'});
    ['servicios','proceso','destacados','proyectos','contacto'].forEach(function(id){spy.observe($(id))});
  }

  /* ---- Contadores ---- */
  if('IntersectionObserver' in window&&!reduce){
    var co=new IntersectionObserver(function(es){es.forEach(function(e){
      if(!e.isIntersecting)return;co.unobserve(e.target);
      var el=e.target,n=+el.dataset.n,t0=performance.now();
      (function f(t){var p=Math.min((t-t0)/1500,1);el.textContent=Math.round(n*(1-Math.pow(1-p,4)));if(p<1)requestAnimationFrame(f)})(t0);
    })},{threshold:.8});
    document.querySelectorAll('[data-n]').forEach(function(el){el.textContent='0';co.observe(el)});
  }

  /* ---- Cinta de obra: rellena el ancho y velocidad constante en px/s ---- */
  var pistas=[].slice.call(document.querySelectorAll('.pista'));
  var base=pistas.map(function(p){return p.firstElementChild.cloneNode(true)});
  function armarCintas(){
    pistas.forEach(function(p,i){
      var cinta=p.parentElement,w=cinta.offsetWidth;
      p.textContent='';
      var g=base[i].cloneNode(true);p.appendChild(g);
      var gw=g.offsetWidth||1,n=Math.max(1,Math.ceil(w/gw));
      for(var k=1;k<n;k++)p.appendChild(base[i].cloneNode(true));
      var mitad=[].slice.call(p.children);
      mitad.forEach(function(c){p.appendChild(c.cloneNode(true))});
      var vel=innerWidth<640?42:64; /* píxeles por segundo */
      p.style.setProperty('--dur',(gw*n/vel).toFixed(2)+'s');
    });
  }
  var rw=innerWidth,rt;
  addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(function(){if(innerWidth!==rw){rw=innerWidth;armarCintas()}},200)});
  (document.fonts&&document.fonts.ready?document.fonts.ready:Promise.resolve()).then(armarCintas);

  /* ---- Filtros del portafolio ---- */
  var fbtns=[].slice.call(document.querySelectorAll('.filtros button')),obras=[].slice.call(document.querySelectorAll('.obra'));
  fbtns.forEach(function(b){
    var f=b.dataset.f;
    b.addEventListener('click',function(){
      fbtns.forEach(function(x){x.setAttribute('aria-pressed',x===b)});
      b.scrollIntoView({block:'nearest',inline:'nearest',behavior:reduce?'auto':'smooth'});
      obras.forEach(function(o){
        var ver=f==='all'||o.dataset.c===f;o.hidden=!ver;o.classList.remove('entra');
        if(ver&&!reduce){void o.offsetWidth;o.classList.add('entra')}
      });
    });
  });

  /* ---- Visor de fotos ---- */
  var lb=$('lb'),li=$('lb-img'),cap=$('lb-cap'),cur=0,lastFocus=null;
  if(lb&&li&&cap){
  function visibles(){return obras.filter(function(o){return !o.hidden})}
  function mostrar(i){
    var v=visibles();cur=(i+v.length)%v.length;
    var o=v[cur],im=o.querySelector('img');
    li.src=im.currentSrc||im.src;li.alt=im.alt;
    cap.innerHTML='';var b=document.createElement('b');b.textContent=o.querySelector('h3').textContent;
    var c=document.createElement('span');c.textContent=(cur+1)+' / '+v.length;cap.appendChild(b);cap.appendChild(c);
  }
  obras.forEach(function(o){o.querySelector('button').addEventListener('click',function(){
    lastFocus=this;mostrar(visibles().indexOf(o));
    if(lb.showModal){lb.showModal();document.body.style.overflow='hidden'}
  })});
  function cerrar(){if(lb.open)lb.close()}
  lb.addEventListener('close',function(){document.body.style.overflow='';if(lastFocus)lastFocus.focus()});
  $('lb-prev').addEventListener('click',function(){mostrar(cur-1)});
  $('lb-next').addEventListener('click',function(){mostrar(cur+1)});
  $('lb-x').addEventListener('click',cerrar);
  lb.addEventListener('click',function(e){if(e.target===lb||e.target.classList.contains('lb-img'))cerrar()});
  addEventListener('keydown',function(e){if(!lb.open)return;if(e.key==='ArrowLeft')mostrar(cur-1);if(e.key==='ArrowRight')mostrar(cur+1)});
  var sx=null,sy=null;
  li.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;sy=e.touches[0].clientY},{passive:true});
  li.addEventListener('touchend',function(e){if(sx===null)return;var dx=e.changedTouches[0].clientX-sx,dy=e.changedTouches[0].clientY-sy;
    if(Math.abs(dx)>50&&Math.abs(dx)>Math.abs(dy))mostrar(cur+(dx<0?1:-1));sx=null},{passive:true});
  }

  /* ---- Formulario: validación en el navegador + envío a Laravel ---- */
  var form=$('form'),st=$('st');
  if(!form||!st)return;
  var MAIL=form.dataset.correo;
  var tokenMeta=document.querySelector('meta[name="csrf-token"]');
  var token=tokenMeta?tokenMeta.content:'';
  var sinServidor=document.documentElement.dataset.standalone==='1'
    ||location.protocol==='file:'
    ||token==='offline';
  var campos={nombre:$('fn'),telefono:$('ft'),correo:$('fe'),servicio:$('fs'),mensaje:$('fm'),consentimiento:$('fc')};
  function datos(){return{n:$('fn').value.trim(),t:$('ft').value.trim(),e:$('fe').value.trim(),s:$('fs').value,m:$('fm').value.trim()}}
  function limpiar(){
    form.querySelectorAll('[aria-invalid]').forEach(function(el){el.removeAttribute('aria-invalid')});
    form.querySelectorAll('.campo-err').forEach(function(el){el.remove()});
  }
  function error(msg,el){st.className='status err';st.textContent=msg;if(el){el.setAttribute('aria-invalid','true');el.focus()}return false}
  function valido(d){
    limpiar();
    if($('fh').value)return false;
    if(!d.n)return error('Escribe tu nombre.',$('fn'));
    if(d.t.replace(/\D/g,'').length<7)return error('Escribe un teléfono de contacto válido.',$('ft'));
    if(d.e&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(d.e))return error('Revisa el correo electrónico o déjalo vacío.',$('fe'));
    if(!d.m)return error('Cuéntanos brevemente sobre tu proyecto.',$('fm'));
    if(!$('fc').checked)return error('Para enviar, acepta el tratamiento de datos.',$('fc'));
    st.className='status';st.textContent='';return true;
  }
  /* Errores que devuelve Laravel (422): se marcan en cada campo */
  function erroresServidor(errs){
    var primero=null;
    Object.keys(errs).forEach(function(k){
      var el=campos[k];if(!el)return;
      el.setAttribute('aria-invalid','true');
      var s=document.createElement('span');s.className='campo-err';s.textContent=errs[k][0];
      (k==='consentimiento'?el.closest('label'):el).insertAdjacentElement('afterend',s);
      if(!primero)primero=el;
    });
    st.className='status err';st.textContent='Revisa los campos marcados.';
    if(primero)primero.focus();
  }
  form.addEventListener('input',function(e){
    if(e.target.getAttribute('aria-invalid')){
      e.target.removeAttribute('aria-invalid');
      var n=(e.target.type==='checkbox'?e.target.closest('label'):e.target).nextElementSibling;
      if(n&&n.classList.contains('campo-err'))n.remove();
    }
  });
  function abrirWhatsApp(d){
    var sel=$('fw');if(!sel)return false;
    var p=sel.value.split('|');
    var msg='Hola '+p[1]+', soy '+d.n+'. Me interesa el servicio de '+d.s+'.\n\n'+d.m+'\n\nMi teléfono: '+d.t+(d.e?'\nMi correo: '+d.e:'');
    var url='https://wa.me/'+p[0]+'?text='+encodeURIComponent(msg);
    var w=window.open(url,'_blank','noopener');
    if(!w)location.href=url;
    st.className='status ok';st.textContent='Abrimos WhatsApp con tu mensaje listo para enviar.';
    return true;
  }
  var btnWa=$('wa');
  if(btnWa)btnWa.addEventListener('click',function(){var d=datos();if(!valido(d))return;abrirWhatsApp(d);});
  function porCorreo(d){
    var body='Nombre: '+d.n+'\nTeléfono: '+d.t+(d.e?'\nCorreo: '+d.e:'')+'\nServicio: '+d.s+'\n\n'+d.m;
    location.href='mailto:'+MAIL+'?subject='+encodeURIComponent('Consulta desde la web: '+d.s)+'&body='+encodeURIComponent(body);
    st.className='status';st.textContent='Abrimos tu aplicación de correo con el mensaje listo para enviar.';
  }
  form.addEventListener('submit',function(e){
    e.preventDefault();var d=datos();if(!valido(d))return;
    var b=$('send');if(b)b.disabled=true;st.className='status';st.textContent='Enviando…';
    if(sinServidor){porCorreo(d);if(b)b.disabled=false;return;}
    fetch(form.action,{method:'POST',body:new FormData(form),credentials:'same-origin',
      headers:{Accept:'application/json','X-CSRF-TOKEN':token,'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){
      return r.json().catch(function(){return{}}).then(function(j){
        if(r.ok&&j.ok){form.reset();st.className='status ok';st.textContent=j.mensaje||'Mensaje enviado. Te responderemos muy pronto.'}
        else if(r.status===422&&j.errors)erroresServidor(j.errors);
        else if(r.status===429){st.className='status err';st.textContent='Enviaste varias solicitudes seguidas. Espera un minuto e inténtalo de nuevo.'}
        else if(r.status===419){st.className='status err';st.textContent='La página estuvo abierta mucho tiempo. Recárgala e intenta de nuevo.'}
        else porCorreo(d);
      });
    })
    .catch(function(){porCorreo(d);})
    .finally(function(){if(b)b.disabled=false;});
  });
});
