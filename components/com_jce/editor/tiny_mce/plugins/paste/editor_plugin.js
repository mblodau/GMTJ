(function(){var each=tinymce.each;var styleProps=new Array('background','background-attachment','background-color','background-image','background-position','background-repeat','border','border-bottom','border-bottom-color','border-bottom-style','border-bottom-width','border-color','border-left','border-left-color','border-left-style','border-left-width','border-right','border-right-color','border-right-style','border-right-width','border-style','border-top','border-top-color','border-top-style','border-top-width','border-width','outline','outline-color','outline-style','outline-width','height','max-height','max-width','min-height','min-width','width','font','font-family','font-size','font-style','font-variant','font-weight','content','counter-increment','counter-reset','quotes','list-style','list-style-image','list-style-position','list-style-type','margin','margin-bottom','margin-left','margin-right','margin-top','padding','padding-bottom','padding-left','padding-right','padding-top','bottom','clear','clip','cursor','display','float','left','overflow','position','right','top','visibility','z-index','orphans','page-break-after','page-break-before','page-break-inside','widows','border-collapse','border-spacing','caption-side','empty-cells','table-layout','color','direction','letter-spacing','line-height','text-align','text-decoration','text-indent','text-shadow','text-transform','unicode-bidi','vertical-align','white-space','word-spacing');tinymce.create('tinymce.plugins.PastePlugin',{init:function(ed,url){var t=this,cb;t.editor=ed;t.url=url;t.onPreProcess=new tinymce.util.Dispatcher(t);t.onPostProcess=new tinymce.util.Dispatcher(t);t.onBeforeInsert=new tinymce.util.Dispatcher(t);t.onAfterPaste=new tinymce.util.Dispatcher(t);t.onPreProcess.add(t._preProcess);t.onPostProcess.add(t._postProcess);t.onBeforeInsert.add(t._onBeforeInsert);t.onPreProcess.add(function(pl,o){ed.execCallback('paste_preprocess',pl,o)});t.onPostProcess.add(function(pl,o){ed.execCallback('paste_postprocess',pl,o)});ed.onKeyDown.addToTop(function(ed,e){if(((tinymce.isMac?e.metaKey:e.ctrlKey)&&e.keyCode==86)||(e.shiftKey&&e.keyCode==45))return false});t.pasteText=ed.getParam('paste_text',1);t.pasteHtml=ed.getParam('paste_html',1);function process(o){var dom=ed.dom,rng;ed.setProgressState(1);switch(t.command){case'mcePaste':if(!t.pasteHtml){t.command='mcePasteText'}break;case'mcePasteText':if(!t.pasteText){t.command='mcePaste'}break;case'mcePasteWord':if(!t.pasteWord||!t.pasteHtml){t.command='mcePasteText'}break;default:t.command='mcePaste';if(!t.pasteHtml&&t.pasteText){t.command='mcePasteText'}break}t.plainText=t.command=='mcePasteText';if(ed.getParam('paste_force_cleanup')){o.wordContent=true}t.onPreProcess.dispatch(t,o);o.node=dom.create('div',0,o.content);if(tinymce.isGecko){rng=ed.selection.getRng(true);if(rng.startContainer==rng.endContainer&&rng.startContainer.nodeType==3){if(o.node.childNodes.length===1&&/^(p|h[1-6]|pre)$/i.test(o.node.firstChild.nodeName)&&o.content.indexOf('__MCE_ITEM__')===-1)dom.remove(o.node.firstChild,true)}}t.onPostProcess.dispatch(t,o);o.content=ed.serializer.serialize(o.node,{getInner:1,forced_root_block:''});t.onBeforeInsert.dispatch(t,o);if(t.plainText){t._insertPlainText(o.content)}else{t._insert(o.content)}t.onAfterPaste.dispatch(t);ed.setProgressState(0);t.command='mcePaste'};ed.addCommand('mceInsertClipboardContent',function(u,o){process(o)});ed.onInit.add(function(){if(ed.plugins.contextmenu){ed.plugins.contextmenu.onContextMenu.add(function(th,m,e){var c=ed.selection.isCollapsed();m.add({title:'advanced.cut_desc',icon:'cut',cmd:'Cut'}).setDisabled(c);m.add({title:'advanced.copy_desc',icon:'copy',cmd:'Copy'}).setDisabled(c);if(t.pasteHtml){m.add({title:'paste.paste_desc',icon:'paste',cmd:'mcePaste'})}if(t.pasteText){m.add({title:'paste.paste_text_desc',icon:'pastetext',cmd:'mcePasteText'})}})}});function grabContent(e){var n,or,rng,oldRng,sel=ed.selection,dom=ed.dom,doc=ed.getDoc(),body=ed.getBody(),posY,textContent;if(e.clipboardData||doc.dataTransfer){textContent=(e.clipboardData||doc.dataTransfer).getData('Text');if(ed.pasteAsPlainText){e.preventDefault();process({content:textContent.replace(/\r?\n/g,'<br />')});return}}if(dom.get('_mcePaste'))return;n=dom.add(body,'div',{id:'_mcePaste','class':'mcePaste','data-mce-bogus':'1'},'\uFEFF\uFEFF');if(body!=ed.getDoc().body)posY=dom.getPos(ed.selection.getStart(),body).y;else posY=body.scrollTop+dom.getViewPort(ed.getWin()).y;dom.setStyles(n,{position:'absolute',left:tinymce.isGecko?-40:0,top:posY-25,width:1,height:1,overflow:'hidden'});if(tinymce.isIE){oldRng=sel.getRng();rng=dom.doc.body.createTextRange();rng.moveToElementText(n);rng.execCommand('Paste');dom.remove(n);if(n.innerHTML==='\uFEFF\uFEFF'){e.preventDefault();return false}sel.setRng(oldRng);sel.setContent('');setTimeout(function(){process({content:n.innerHTML})},0);tinymce.dom.Event.cancel(e);return true}else{function block(e){e.preventDefault()};dom.bind(doc,'mousedown',block);dom.bind(doc,'keydown',block);or=ed.selection.getRng();n=n.firstChild;rng=doc.createRange();rng.setStart(n,0);rng.setEnd(n,2);sel.setRng(rng);window.setTimeout(function(){var h='',nl;if(!dom.select('div.mcePaste > div.mcePaste').length){nl=dom.select('div.mcePaste');each(nl,function(n){var child=n.firstChild;if(child&&child.nodeName=='DIV'&&child.style.marginTop&&child.style.backgroundColor){dom.remove(child,1)}each(dom.select('span.Apple-style-span',n),function(n){dom.remove(n,1)});each(dom.select('br[data-mce-bogus]',n),function(n){dom.remove(n)});if(n.parentNode.className!='mcePaste')h+=n.innerHTML})}else{h='<p>'+dom.encode(textContent).replace(/\r?\n\r?\n/g,'</p><p>').replace(/\r?\n/g,'<br />')+'</p>'}each(dom.select('div.mcePaste'),function(n){dom.remove(n)});if(or)sel.setRng(or);process({content:h});dom.unbind(ed.getDoc(),'mousedown',block);dom.unbind(ed.getDoc(),'keydown',block)},0)}};if(tinymce.isOpera||/Firefox\/2/.test(navigator.userAgent)){ed.onKeyDown.addToTop(function(ed,e){if(((tinymce.isMac?e.metaKey:e.ctrlKey)&&e.keyCode==86)||(e.shiftKey&&e.keyCode==45))grabContent(e)})}else{ed.onPaste.addToTop(function(ed,e){return grabContent(e)})}if(ed.getParam('paste_block_drop')){ed.onInit.add(function(){ed.dom.bind(body,['dragend','dragover','draggesture','dragdrop','drop','drag'],function(e){e.preventDefault();e.stopPropagation();return false})})}each(['mcePasteText','mcePaste'],function(cmd){ed.addCommand(cmd,function(){t.command=cmd;if(ed.getParam('paste_use_dialog')){return t._openWin(cmd)}else{try{var doc=ed.getDoc();if(!doc.queryCommandSupported('Paste')){return t._openWin(cmd)}else{if(tinymce.isIE){if(!ed.onPaste.dispatch()){return t._openWin(cmd)}}else{doc.execCommand('Paste')}}}catch(e){return t._openWin(cmd)}}})});each(['Cut','Copy'],function(cmd){ed.addCommand(cmd,function(){var doc=ed.getDoc(),failed;try{doc.execCommand(cmd)}catch(ex){failed=true}if(failed||!doc.queryCommandSupported(cmd)){if(tinymce.isGecko){ed.windowManager.confirm(ed.getLang('clipboard_msg'),function(state){if(state)open('http://www.mozilla.org/editor/midasdemo/securityprefs.html','_blank')})}else ed.windowManager.alert(ed.getLang('clipboard_no_support'))}})});if(t.pasteHtml&&!t.pasteText){ed.addButton('paste',{title:'paste.paste_desc',cmd:'mcePaste',ui:true})}if(!t.pasteHtml&&t.pasteText){ed.addButton('paste',{title:'paste.paste_text_desc',cmd:'mcePasteText',ui:true})}},createControl:function(n,cm){var t=this,ed=t.editor;switch(n){case'paste':if(t.pasteHtml&&t.pasteText){var c=cm.createSplitButton('paste',{title:'paste.paste_desc',onclick:function(e){ed.execCommand('mcePaste')}});c.onRenderMenu.add(function(c,m){m.add({title:'paste.paste_desc',icon:'paste',onclick:function(e){ed.execCommand('mcePaste')}});m.add({title:'paste.paste_text_desc',icon:'pastetext',onclick:function(e){ed.execCommand('mcePasteText')}})});return c}break}return null},getInfo:function(){return{longname:'Paste text/word',author:'Moxiecode Systems AB / Ryan demmer',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/paste',version:'2.0.7'}},_openWin:function(cmd){var t=this,ed=this.editor;ed.windowManager.open({file:ed.getParam('site_url')+'index.php?option=com_jce&view=editor&layout=plugin&plugin=paste',width:parseInt(ed.getParam("paste_dialog_width","450")),height:parseInt(ed.getParam("paste_dialog_height","400")),inline:1,popup_css:false},{cmd:cmd})},_preProcess:function(pl,o){var ed=pl.editor,h=o.content;if(ed.settings.paste_enable_default_filters==false){return}if(tinymce.isIE&&document.documentMode>=9){h=h.replace(/(?:<br>&nbsp;[\s\r\n]+|<br>)*(<\/?(h[1-6r]|p|div|address|pre|form|table|tbody|thead|tfoot|th|tr|td|li|ol|ul|caption|blockquote|center|dl|dt|dd|dir|fieldset)[^>]*>)(?:<br>&nbsp;[\s\r\n]+|<br>)*/g,'$1');h=h.replace(/<br><br>/g,'<BR><BR>');h=h.replace(/<br>/g,' ');h=h.replace(/<BR><BR>/g,'<br>')}h=h.replace(/^\s*(&nbsp;)+/g,'');h=h.replace(/(&nbsp;|<br[^>]*>)+\s*$/g,'');if(this.plainText){return h}var ooRe=/(Version:[\d\.]+)\s*?((Start|End)(HTML|Fragment):[\d]+\s*?){4}/;if(/(content=\"OpenOffice.org[^\"]+\")/i.test(h)||ooRe.test(h)){o.wordContent=true;h=h.replace(ooRe,'','g');h=h.replace(/[\s\S]+?<meta[^>]*>/,'');h=h.replace(/<!--[\s\S]+?-->/gi,'');h=h.replace(/<style[^>]*>[\s\S]+?<\/style>/gi,'')}if(/(class=\"?Mso|style=\"[^\"]*\bmso\-|w:WordDocument)/.test(h)){o.wordContent=true}if(ed.getParam('paste_remove_styles')){h=h.replace(/\sstyle="([^"]+?)"/gi,'')}if(ed.getParam('force_p_newlines')){var blocks='';tinymce.each(h.split('<br><br>'),function(block){blocks+='<p>'+block+'</p>'});h=blocks}if(ed.getParam('force_br_newlines')){h=h.replace(/<\/p>/gi,'<br /><br />').replace(/<p([^>]*)>/g,'').replace(/(<br \/>){2}$/g,'')}if(o.wordContent){h=this._processWordContent(h)}var stripClass=ed.getParam(ed,'paste_strip_class_attributes');if(stripClass!=='none'){function removeClasses(match,g1){if(stripClass==='all'){return''}var cls=tinymce.grep(tinymce.explode(g1.replace(/^(["'])(.*)\1$/,"$2")," "),function(v){return(/^(?!mso)/i.test(v))});return cls.length?' class="'+cls.join(" ")+'"':''};h=h.replace(/ class="([^"]+)"/gi,removeClasses);h=h.replace(/ class=([\-\w]+)/gi,removeClasses)}if(ed.getParam('paste_remove_spans')){if(ed.settings.inline_styles){h=h.replace(/<\/?(u|strike)[^>]*>/gi,'');if(ed.settings.convert_fonts_to_spans){h=h.replace(/<\/?(font)[^>]*>/gi,'')}}h=h.replace(/<\/?(span)[^>]*>/gi,'')}h=h.replace(/&nbsp;/g,'\u00a0');h=h.replace(/<meta([^>]+)>/,'');h=h.replace(/Version:[\d.]+\nStartHTML:\d+\nEndHTML:\d+\nStartFragment:\d+\nEndFragment:\d+/gi,'');o.content=h},_processWordContent:function(h){var ed=this.editor,stripClass;if(ed.getParam('paste_convert_lists',true)){h=h.replace(/<!--\[if !supportLists\]-->/gi,'$&__MCE_ITEM__');h=h.replace(/(<span[^>]+:\s*symbol[^>]+>)/gi,'$1__MCE_ITEM__');h=h.replace(/(<span[^>]+mso-list:[^>]+>)/gi,'$1__MCE_ITEM__');h=h.replace(/(<p[^>]+(?:MsoListParagraph)[^>]+>)/gi,'$1__MCE_ITEM__')}h=h.replace(/<!--[\s\S]+?-->/gi,'');h=h.replace(/<style([^>]*)>([\w\W]*?)<\/style>/gi,'');h=h.replace(/<(!|script[^>]*>.*?<\/script(?=[>\s])|\/?(\?xml(:\w+)?|meta|link|\w:\w+)(?=[\s\/>]))[^>]*>/gi,'');h=h.replace(/<(\/?)s>/gi,"<$1strike>");h=h.replace(/&nbsp;/gi,"\u00a0");do{len=h.length;h=h.replace(/(<[a-z][^>]*\s)(?:id|language|type|on\w+|\w+:\w+)=(?:"[^"]*"|\w+)\s?/gi,"$1")}while(len!=h.length);if(!ed.getParam('paste_remove_styles')){h=h.replace(/<span\s+style\s*=\s*"\s*mso-spacerun\s*:\s*yes\s*;?\s*"\s*>([\s\u00a0]*)<\/span>/gi,function(str,spaces){return(spaces.length>0)?spaces.replace(/./," ").slice(Math.floor(spaces.length/2)).split("").join("\u00a0"):""});h=h.replace(/(<[a-z][^>]*)\sstyle="([^"]*)"/gi,function(str,tag,style){var n=[],i=0,s=tinymce.explode(tinymce.trim(style).replace(/&quot;/gi,"'"),";");each(s,function(v){var name,value,parts=tinymce.explode(v,":");function ensureUnits(v){return v+((v!=="0")&&(/\d$/.test(v)))?"px":""}if(parts.length==2){name=parts[0].toLowerCase();value=parts[1].toLowerCase();switch(name){case"mso-padding-alt":case"mso-padding-top-alt":case"mso-padding-right-alt":case"mso-padding-bottom-alt":case"mso-padding-left-alt":case"mso-margin-alt":case"mso-margin-top-alt":case"mso-margin-right-alt":case"mso-margin-bottom-alt":case"mso-margin-left-alt":case"mso-table-layout-alt":case"mso-height":case"mso-width":case"mso-vertical-align-alt":n[i++]=name.replace(/^mso-|-alt$/g,"")+":"+ensureUnits(value);return;case"horiz-align":n[i++]="text-align:"+value;return;case"vert-align":n[i++]="vertical-align:"+value;return;case"font-color":case"mso-foreground":n[i++]="color:"+value;return;case"mso-background":case"mso-highlight":n[i++]="background:"+value;return;case"mso-default-height":n[i++]="min-height:"+ensureUnits(value);return;case"mso-default-width":n[i++]="min-width:"+ensureUnits(value);return;case"mso-padding-between-alt":n[i++]="border-collapse:separate;border-spacing:"+ensureUnits(value);return;case"text-line-through":if((value=="single")||(value=="double")){n[i++]="text-decoration:line-through"}return;case"mso-zero-height":if(value=="yes"){n[i++]="display:none"}return}if(/^(mso|column|font-emph|lang|layout|line-break|list-image|nav|panose|punct|row|ruby|sep|size|src|tab-|table-border|text-(?!align|decor|indent|trans)|top-bar|version|vnd|word-break)/.test(name)){return}n[i++]=name+":"+parts[1]}});if(i>0){return tag+' style="'+n.join(';')+'"'}else{return tag}})}if(ed.getParam('force_p_newlines')){h=h.replace(/<br><br>/gi,'')}return h},_insertPlainText:function(h){var t=this,ed=this.editor,dom=ed.dom,entities=null;if((typeof(h)==="string")&&(h.length>0)){if(/<(?:p|br|h[1-6]|ul|ol|dl|table|t[rdh]|div|blockquote|fieldset|pre|address|center)[^>]*>/i.test(h)){h=h.replace(/[\n\r]+/g,'')}else{h=h.replace(/\r+/g,'')}h=h.replace(/<\/(?:p|h[1-6]|ul|ol|dl|table|div|blockquote|fieldset|pre|address|center)>/gi,"\n\n");h=h.replace(/<br[^>]*>|<\/tr>/gi,"\n");h=h.replace(/<\/t[dh]>\s*<t[dh][^>]*>/gi,"\t");h=h.replace(/<[a-z!\/?][^>]*>/gi,'');h=h.replace(/&nbsp;/gi," ");h=dom.decode(tinymce.html.Entities.encodeRaw(h));h=h.replace(/(?:(?!\n)\s)*(\n+)(?:(?!\n)\s)*/gi,"$1");h=h.replace(/\n{3,}/g,"\n\n");h=h.replace(/^\s+|\s+$/g,'');h=h.replace(/\u2026/g,"...");h=h.replace(/[\x93\x94\u201c\u201d]/g,'"');h=h.replace(/[\x60\x91\x92\u2018\u2019]/g,"'");if(ed.getParam("force_p_newlines")){h=h.replace(/\n\n/g,'__MCE_PARA__');var blocks='';tinymce.each(h.split('__MCE_PARA__'),function(block){blocks+='<p>'+block+'</p>'});h=blocks}h=h.replace(/\n/g,'<br />');h=h.replace(/<p><\/p>/gi,'');if((pos=h.indexOf("</p><p>"))!=-1){rpos=h.lastIndexOf("</p><p>");node=ed.selection.getNode();breakElms=[];do{if(node.nodeType==1){if(node.nodeName=="TD"||node.nodeName=="BODY"){break}breakElms[breakElms.length]=node}}while(node=node.parentNode);if(breakElms.length>0){before=h.substring(0,pos);after="";for(i=0,len=breakElms.length;i<len;i++){before+="</"+breakElms[i].nodeName.toLowerCase()+">";after+="<"+breakElms[breakElms.length-i-1].nodeName.toLowerCase()+">"}if(pos==rpos){h=before+after+h.substring(pos+7)}else{h=before+h.substring(pos+4,rpos+4)+after+h.substring(rpos+7)}}}ed.execCommand("mceInsertRawHTML",false,h+'<span id="_plain_text_marker">&nbsp;</span>');window.setTimeout(function(){var marker=dom.get('_plain_text_marker'),elm,vp,y,elmHeight;ed.selection.select(marker,false);document.execCommand("Delete",false,null);marker=null;elm=ed.selection.getStart();vp=dom.getViewPort(window);y=dom.getPos(elm).y;elmHeight=elm.clientHeight;if((y<vp.y)||(y+elmHeight>vp.y+vp.h)){document.body.scrollTop=y<vp.y?y:y-vp.h+25}},0)}},_convertToInline:function(node){var ed=this.editor,dom=ed.dom;var fontSizes=tinymce.explode(ed.settings.font_size_style_values);function replaceWithSpan(n,styles){tinymce.each(styles,function(value,name){if(value)dom.setStyle(n,name,value)});dom.rename(n,'span')};filters={font:function(n){replaceWithSpan(n,{backgroundColor:n.style.backgroundColor,color:n.color,fontFamily:n.face,fontSize:fontSizes[parseInt(n.size)-1]})},u:function(n){replaceWithSpan(n,{textDecoration:'underline'})},strike:function(n){replaceWithSpan(n,{textDecoration:'line-through'})}};if(ed.settings.convert_fonts_to_spans){tinymce.each(dom.select('font,u,strike',node),function(n){filters[n.nodeName.toLowerCase()](n)})}},_processStyles:function(node){var ed=this.editor,dom=ed.dom;var s=ed.getParam('paste_retain_style_properties');if(s&&tinymce.is(s,'string')){styleProps=tinymce.explode(s)}each(dom.select('*[style]',node),function(n){var ns={},x=0;var styles=dom.parseStyle(n.style.cssText);each(styles,function(v,k){if(tinymce.inArray(styleProps,k)!=-1){ns[k]=v;x++}});dom.setAttrib(n,'style','');if(x>0){dom.setStyles(n,ns)}else{if(n.nodeName=='SPAN'&&!n.className){dom.remove(n,true)}}if(tinymce.isWebKit){n.removeAttribute('data-mce-style')}})},_convertURLs:function(node){var ed=this.editor,dom=ed.dom;var ex='([-!#$%&\'\*\+\\./0-9=?A-Z^_`a-z{|}~]+@[-!#$%&\'\*\+\\/0-9=?A-Z^_`a-z{|}~]+\.[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+)';var ux='((news|telnet|nttp|file|http|ftp|https)://[-!#$%&\'\*\+\\/0-9=?A-Z^_`a-z{|}~]+\.[-!#$%&\'\*\+\\./0-9=?A-Z^_`a-z{|}~]+)';function processURL(h){h=h.replace(new RegExp(ex,'g'),'<a href="mailto:$1">$1</a>');h=h.replace(new RegExp(ux,'g'),'<a href="$1">$1</a>');return h}function _convert(n){each(n.childNodes,function(el){if(el&&!dom.getParent(el,'a')){if(el.nodeType==3){var s=el.innerText||el.textContent||el.data||'';if(s&&(new RegExp(ex,'g').test(s)||new RegExp(ux,'g').test(s))){var tmp=dom.create('div',{},processURL(s));dom.replace(tmp,el);dom.remove(tmp,true)}}else{if(el.nodeName!='A'){_convert(el)}}}})}_convert(node)},_postProcess:function(pl,o){var self=this,ed=this.editor,dom=ed.dom,h;if(ed.settings.paste_enable_default_filters==false){return}if(!this.plainText){each(dom.select('span.Apple-style-span',o.node),function(n){dom.remove(n,1)});if(!ed.getParam('paste_remove_spans')){if(ed.settings.inline_styles){this._convertToInline(o.node)}}if(o.wordContent){each(dom.select('a',o.node),function(a){if(!a.href||a.href.indexOf('#_Toc')!=-1)dom.remove(a,1)});each(dom.select('*[lang]',o.node),function(el){el.removeAttribute('lang')});each(dom.select('a[href*=#]',o.node),function(el){var href=el.href;dom.setAttrib(el,'href',href.substring(href.lastIndexOf('#')));if(el.name)dom.addClass(el,'mceItemAnchor')})}}if(!ed.getParam('paste_remove_styles')){this._processStyles(o.node)}if(ed.getParam('paste_convert_lists',true)){this._convertLists(o.node)}each(dom.select('img',o.node),function(el){if(/file:\/\//.test(el.src)){dom.remove(el)}});if(ed.getParam('paste_convert_urls',true)){this._convertURLs(o.node)}if(ed.getParam('paste_remove_empty_paragraphs',true)){ed.dom.remove(dom.select('p:empty',o.node));each(dom.select('p',o.node),function(n){var h=n.innerHTML;if(/^(\s|&nbsp;|\u00a0)*?$/.test(h)){dom.remove(n)}})}},_onBeforeInsert:function(pl,o){var ed=pl.editor,dom=ed.dom,h=o.content;if(ed.getParam('paste_remove_spans')){h=h.replace(/<\/?(span)([^>]*)>/gi,'')}if(ed.getParam('paste_remove_empty_spans',true)){h=h.replace(/<\/?(span)>/gi,'')}o.content=h},_convertLists:function(node){var ed=this.editor,dom=ed.dom,listElm,li,lastMargin=-1,margin,levels=[],lastType;var ULRX=/^(__MCE_ITEM__)+[\u2022\u00b7\u00a7\u00d8o\u25CF]\s*\u00a0*/;var OLRX=/^__MCE_ITEM__\s*\(?(\w+)(\.|\))?\s*\u00a0+/;each(dom.select('p',node),function(p){var sib,val='',type,html,idx,parents,s,chars,st;for(sib=p.firstChild;sib&&sib.nodeType==3;sib=sib.nextSibling){val+=sib.nodeValue}val=p.innerHTML.replace(/<\/?\w+[^>]*>/gi,'').replace(/&nbsp;/g,'\u00a0');if(ULRX.test(val)){type='ul'}if(s=val.match(OLRX)){type='ol';chars=s[1];if(!ed.getParam('paste_remove_styles')){if(chars&&chars!='__MCE_ITEM__'){if(/0[1-9]/.test(chars)){st='decimal-leading-zero'}if(/[a-z+?]/.test(chars)){st='lower-alpha'}if(/[A-Z+?]/.test(chars)){st='upper-alpha'}if(/[ivx+]/.test(chars)){st='lower-roman'}if(/[IVX+]/.test(chars)){st='upper-roman'}}}}if(type){margin=parseFloat(p.style.marginLeft||0);if(margin>lastMargin)levels.push(margin);if(!listElm||type!=lastType){listElm=dom.create(type);dom.insertAfter(listElm,p)}else{if(margin>lastMargin){listElm=li.appendChild(dom.create(type))}else if(margin<lastMargin){idx=tinymce.inArray(levels,margin);parents=dom.getParents(listElm.parentNode,type);listElm=parents[parents.length-1-idx]||listElm}}each(dom.select('span',p),function(span){var html=span.innerHTML.replace(/<\/?\w+[^>]*>/gi,'');if(type=='ul'&&ULRX.test(html)){dom.remove(span)}else if(/^(&nbsp;|\u00a0)+\s*/.test(html)){dom.remove(span)}else if(OLRX.test(html)){dom.remove(span)}});html=p.innerHTML;if(type=='ul'){html=html.replace(/__MCE_ITEM__/g,'').replace(/^[\u2022\u00b7\u00a7\u00d8o\u25CF]\s*(&nbsp;|\u00a0)+\s*/,'')}else{html=html.replace(/__MCE_ITEM__/g,'').replace(/\s*\(?(\w+)(\.|\))?\s*(&nbsp;|\u00a0)+\s*/,'')}li=listElm.appendChild(dom.create('li',0,html));dom.remove(p);if(st&&typeof st!='undefined'){dom.setStyle(listElm,'list-style-type',st)}lastMargin=margin;lastType=type}else{listElm=lastMargin=0}});html=node.innerHTML;if(html.indexOf('__MCE_ITEM__')!=-1){node.innerHTML=html.replace(/__MCE_ITEM__/g,'')}},_insert:function(h,skip_undo){var ed=this.editor,r=ed.selection.getRng();if(!ed.selection.isCollapsed()&&r.startContainer!=r.endContainer)ed.getDoc().execCommand('Delete',false,null);ed.execCommand('mceInsertContent',false,h,{skip_undo:skip_undo})}});tinymce.PluginManager.add('paste',tinymce.plugins.PastePlugin)})();