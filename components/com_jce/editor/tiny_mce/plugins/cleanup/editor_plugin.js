(function(){var each=tinymce.each;tinymce.create('tinymce.plugins.CleanupPlugin',{init:function(ed,url){var t=this;this.editor=ed;ed.onBeforeSetContent.add(function(ed,o){o.content=o.content.replace(/<pre xml:\s*(.*?)>(.*?)<\/pre>/g,'<pre class="geshi-$1">$2</pre>')});ed.onPostProcess.add(function(ed,o){if(o.set){o.content=o.content.replace(/<pre xml:\s*(.*?)>(.*?)<\/pre>/g,'<pre class="geshi-$1">$2</pre>')}if(o.get){o.content=o.content.replace(/<pre class="geshi-(.*?)">(.*?)<\/pre>/g,'<pre xml:$1>$2</pre>');o.content=o.content.replace(/<a([^>]*)class="jce(box|popup|lightbox|tooltip|_tooltip)"([^>]*)><\/a>/gi,'');o.content=o.content.replace(/<span class="jce(box|popup|lightbox|tooltip|_tooltip)">(.*?)<\/span>/gi,'$2');o.content=o.content.replace(/_mce_(src|href|style|coords|shape)="([^"]+)"\s*?/gi,'');if(ed.getParam('keep_nbsp',true)){o.content=o.content.replace(/\u00a0/g,'&nbsp;')}if(!ed.getParam('verify_html')){o.content=o.content.replace(/<p([^>]*)><\/p>/g,'<p$1>&nbsp;</p>')}if(tinymce.isGecko){o.content=o.content.replace(/<td><\/td>/g,'<td>&nbsp;</td>')}}});ed.onGetContent.add(function(ed,o){if(o.save){if(ed.getParam('cleanup_pluginmode')){o.content=o.content.replace(/&#39;/gi,"'");o.content=o.content.replace(/&apos;/gi,"'");o.content=o.content.replace(/&amp;/gi,"&");o.content=o.content.replace(/&quot;/gi,'"')}}if(tinymce.isGecko){o.content=o.content.replace(/<td><\/td>/g,'<td>&nbsp;</td>')}});ed.addButton('cleanup',{title:'advanced.cleanup_desc',cmd:'mceCleanup'})},getInfo:function(){return{longname:'Cleanup',author:'Ryan Demmer',authorurl:'http://www.joomlacontenteditor.net',infourl:'http://www.joomlacontenteditor.net',version:'2.0.7'}}});tinymce.PluginManager.add('cleanup',tinymce.plugins.CleanupPlugin)})();