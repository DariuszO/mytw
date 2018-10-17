var COA={max_size:5e3,allowed_types:['image/png','image/gif','image/jpg','image/jpeg'],upload_url:null,invite_text:null,container:null,file_select:null,init:function(upload_url){this.upload_url=upload_url;this.container=$('.coa').first();this.invite_text=mobile?'Dotknij by załadować.':'Kliknij lub przeciągnij i upuść by załadować.';if(this.supportsEnhanced()){this.createStructure();this.setupEventHandlers();this.setStatus(this.invite_text)}else this.fallback()},supportsEnhanced:function(){return!mobile&&Modernizr.json&&Modernizr.filereader&&Modernizr.draganddrop},fallback:function(){var url=COA.upload_url.replace('ajax','');this.container.append('<form method="post" action="'+url+'" enctype="multipart/form-data"><input name="image" type="file" accept="image/*" /><input type="submit" value="Upload" /></form>')},setupEventHandlers:function(){this.container.on('click',this.handleClick);this.container.on('drop',this.handleDrop);this.container.on('dragover dragenter dragleave',function(evt){if(evt.type=='dragover'&&!COA.container.hasClass('hover')){COA.container.addClass('hover')}else if(evt.type=='dragleave'&&COA.container.hasClass('hover'))COA.container.removeClass('hover');evt.preventDefault();evt.stopPropagation()});this.file_select.on('change',this.handleFileSelect)},createStructure:function(){this.container.append('<div class="msg"></div>');this.file_select=$('<input type="file" class="file-select-hidden" />');$('body').append(this.file_select)},handleDrop:function(evt){evt.preventDefault();evt.stopPropagation();if(evt.originalEvent.dataTransfer.files){var file=evt.originalEvent.dataTransfer.files[0];if(!file){COA.container.removeClass('hover');return false};COA.uploadFile(file)}},handleClick:function(){COA.file_select.click()},handleFileSelect:function(evt){COA.uploadFile(this.files[0])},uploadFile:function(file){if(file.size>COA.max_size*1024){COA.container.removeClass('hover');UI.ErrorMessage('Plik jest zbyt duży, prosimy o wybranie mniejszego.');return false};if($.inArray(file.type,COA.allowed_types)==-1){COA.container.removeClass('hover');UI.ErrorMessage('Tylko pliki .png, .jpg i .gif są dozwolone.');return false};this.setStatus('Uploading...');xhr=new XMLHttpRequest();xhr.open('post',this.upload_url,true);xhr.setRequestHeader('Content-Type',"text/plain");xhr.setRequestHeader('X-File-Name',file.fileName);xhr.setRequestHeader('X-File-Size',file.fileSize);xhr.setRequestHeader('X-File-Type',file.type);xhr.addEventListener('error',function(e){document.location.reload()});xhr.addEventListener('load',function(){if(xhr.status==200){var response=JSON.parse(xhr.responseText);if(response.error){COA.error(response.error);return};document.location.reload()}else if(xhr.status==413){COA.error('Plik jest zbyt duży, prosimy o wybranie mniejszego.')}else COA.error('Wystąpił nieznany błąd, prosimy spróbować później.')},false);xhr.send(file)},error:function(text){COA.setStatus(this.invite_text);COA.container.removeClass('hover');UI.ErrorMessage(text)},setStatus:function(status){this.container.find('.msg').text(status)}}