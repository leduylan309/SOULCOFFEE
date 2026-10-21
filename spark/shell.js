/* Spark site-v2 — shared header + footer. Nav mirrors the live sparkvn.edu.vn menu exactly. Include once at the end of <body>, before spark.js. */
(function(){
var NAV=[
['Home','index.html'],
['About','about.html',[['Our Story','our-story.html'],['Joe Evans','joe-evans.html'],['English Support','english-support.html'],['The Spark Method','the-spark-method.html'],['Class Size','class-size.html'],['Community','community.html']]],
['Assessment','assessment.html'],
['Programs','programs.html',[['Phonics','phonics.html'],['ESL','esl.html'],['IB English','ib-english.html'],['Tides','tides.html'],['IELTS','ielts-program.html'],['Policy','policy.html']]],
['Exclusive','access.html',[
 ['Teachers Corner','teachers-corner.html',[['Ask a Teacher','ask-a-teacher.html'],['Teacher Blogs','teacher-blogs.html']]],
 ['Parent Center','parent-center.html',[['Why Academic English Matters','why-academic-english-matters.html'],['Academic Roadmap','academic-roadmap.html'],['Results Dashboard','results-dashboard.html'],['Parent Success Roadmap','parent-success-roadmap.html']]],
 ['Resource Library','resource-library.html',[['International School Support Guide','international-school-support-guide.html'],['IB School Guide','ib-school-guide.html'],["Parent's Guide",'ask-a-teacher.html'],['Reading Age Growth Center','reading-age-growth-center.html']]],
 ['Student Portal','student-portal.html'],['Spark Store','spark-store.html']]],
['Contact','contact.html'],
['Blog','blog.html']];
var here=(location.pathname.split('/').pop()||'index.html');
function cur(h){return h===here?' aria-current="page"':''}
function inTree(item){if(item[1]===here)return true;return (item[2]||[]).some(inTree)}
function desk(){return NAV.map(function(it){
 if(!it[2])return '<a href="'+it[1]+'"'+cur(it[1])+'>'+it[0]+'</a>';
 var sub=it[2].map(function(s){
  var kids=s[2]?'<div class="nav-drop-sub">'+s[2].map(function(k){return '<a href="'+k[1]+'"'+cur(k[1])+'>'+k[0]+'</a>'}).join('')+'</div>':'';
  return '<div class="nav-drop-item'+(s[2]?' has-sub':'')+'"><a href="'+s[1]+'"'+cur(s[1])+'>'+s[0]+'</a>'+kids+'</div>'}).join('');
 return '<div class="nav-item"><a href="'+it[1]+'"'+(inTree(it)?' aria-current="page"':'')+'>'+it[0]+'<span class="care"></span></a><div class="nav-drop">'+sub+'</div></div>'}).join('')}
function mob(){return NAV.map(function(it){
 if(!it[2])return '<a href="'+it[1]+'" data-close>'+it[0]+'</a>';
 var sub=it[2].map(function(s){
  var kids=s[2]?s[2].map(function(k){return '<a class="sub2" href="'+k[1]+'" data-close>'+k[0]+'</a>'}).join(''):'';
  return '<a href="'+s[1]+'" data-close>'+s[0]+'</a>'+kids}).join('');
 return '<details class="mnav-group"'+(inTree(it)?' open':'')+'><summary>'+it[0]+'<span class="chev"></span></summary><div class="mnav-sub"><a href="'+it[1]+'" data-close>All '+it[0]+'</a>'+sub+'</div></details>'}).join('')}
var solid=document.body.hasAttribute('data-solid-header');
var header='<header class="site-header'+(solid?' solid':'')+'" id="top"><div class="container nav"><a class="brand" href="index.html" aria-label="Spark English Center home"><img class="logo-white" src="assets/logo-white.png" alt="Spark English Center" /><img class="logo-purple" src="assets/logo-purple.png" alt="Spark English Center" /></a><nav class="nav-links" aria-label="Primary">'+desk()+'</nav><a href="assessment.html" class="btn btn-primary btn-sm nav-cta">Assessment</a><button class="nav-toggle" id="navToggle" aria-label="Open menu" aria-expanded="false"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button></div></header>'+
'<div class="mnav" id="mnav"><div class="mnav__scrim" data-close></div><div class="mnav__panel"><div class="mnav__top"><img src="assets/logo-purple.png" alt="Spark English Center" /><button class="mnav__close" data-close aria-label="Close menu"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg></button></div><nav class="mnav__links" aria-label="Mobile">'+mob()+'</nav><a href="assessment.html" class="btn btn-primary" data-close>Book a Free Assessment</a></div></div>'+
(solid?'<div class="page-top"></div>':'');
var footer='<footer class="site-footer"><div class="container"><div class="footer-top"><div><a class="brand" href="index.html"><img src="assets/logo-white.png" alt="Spark English Center" /></a><p class="footer-about">204B7/12 Nguyễn Văn Hưởng,<br />Phường An Khánh, TP.HCM.</p></div><div class="footer-col"><h4>Spark</h4><ul><li><a href="index.html">Home</a></li><li><a href="assessment.html">Assessment</a></li><li><a href="our-story.html">Our Story</a></li></ul></div><div class="footer-col"><h4>More</h4><ul><li><a href="access.html">Exclusive</a></li><li><a href="contact.html">Contact</a></li><li><a href="blog.html">Blog</a></li></ul></div><div class="footer-col"><h4>Get in touch</h4><ul><li><a href="tel:0398143487">Phone: 0398143487</a></li><li><a href="mailto:hello@sparkvn.com">Email: hello@sparkvn.com</a></li></ul></div></div><div class="footer-bottom"><span>© <span id="yr">2026</span> Spark English Center. All rights reserved.</span><div class="footer-social"><a href="https://www.facebook.com/people/Spark-English-Center-Vietnam/61582302060780/" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3V6h-3c-2 0-3 1.4-3 3.3V11H8v3h3v7h3v-7h2.5l.5-3H14V9.6c0-.4.3-.6.7-.6z"/></svg></a><a href="https://tiktok.com/@sparkvietnam" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M16.5 3c.3 2.3 1.7 3.8 4 4v3c-1.5 0-2.9-.5-4-1.3V15a6 6 0 1 1-6-6c.3 0 .7 0 1 .1v3.1a3 3 0 1 0 2 2.8V3h3z"/></svg></a><a href="https://youtube.com/@SparkVN" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12s0-3-.4-4.4a2.6 2.6 0 0 0-1.8-1.8C18.4 5.4 12 5.4 12 5.4s-6.4 0-7.8.4A2.6 2.6 0 0 0 2.4 7.6C2 9 2 12 2 12s0 3 .4 4.4a2.6 2.6 0 0 0 1.8 1.8c1.4.4 7.8.4 7.8.4s6.4 0 7.8-.4a2.6 2.6 0 0 0 1.8-1.8C22 15 22 12 22 12zm-12 2.8V9.2L15 12z"/></svg></a></div></div></div></footer>';
document.body.insertAdjacentHTML('afterbegin',header);
document.body.insertAdjacentHTML('beforeend',footer);
})();
