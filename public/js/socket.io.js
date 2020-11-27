
var baseURI = window.location.origin;

if (baseURI == 'http://167.172.208.67') {
baseURI += '/lara-walema/public/';
}else {
baseURI += '/';
}


function status_user (class1 , class2) {

	var status_user = ['online' , 'offline' , 'dnd' , 'bys'];
}

$(document).ready(function(){
     
	 


	 var array_emit = ['status' , 'iam_online' , 'iam_offline'];


	 var arr = []; // List of users	
	
	 $('.messageCommon').on('click' , function(e) {

	 	var uid = $(this).attr('user_id');
	 	var uimage = $(this).attr('user_image');
	 	var name = $(this).attr('name');
	 	var data = '';
	 	var role = $(this).attr('user_role');

	 	if (!uimage) {


			if (role == 'supplier') {
				uimage = baseURI + 'img/default_supplier.jpg';
			}else{
				uimage = baseURI + 'img/default_user.png';
			}
	 	}

	 	private_chatbox(name , "user_" + uid , uimage);

	 	$('.box-user_' + uid +' .popup-messages').scrollTop($('.box-user_' + uid +' .popup-messages').prop('scrollHeight'))

	 });


	$(document).on('click', '.popup-head', function() {	

		var chatbox = $(this).parents().attr("rel");

		
			$('.box-' + chatbox).toggleClass('clos');


		if (! $('.box-' + chatbox).hasClass('clos'))  {

			$('.box-' + chatbox + ' .msg_wrap').css('display' , 'block');
			$('.box-' + chatbox).css('height' , '415px');

		}else{

			$('.box-' + chatbox).css('height' , '55px');
			$('.box-' + chatbox + ' .msg_wrap').css('display' , 'none');

		}

		return false;
	});
	
	
	$(document).on('click', '.close', function() {	
		var chatbox = $(this).parents().parents().parents().attr("rel") ;


		$('[rel="'+chatbox+'"]').remove();

		arr.splice($.inArray(chatbox, arr), 1);
		displayChatBox();
		return false;
	});

	socket.on('if_online' , (data)=>{

      if ( data.type == 'supplier' && active_suppliers.indexOf([data.user_id]) < 0 ) {
      	
      	active_suppliers.push(data.user_id); 	

      }else if ( data.type == 'customer' && active_customers.indexOf([data.user_id]) < 0 ) {
      
      	active_customers.push(data.user_id); 	
      
      }

      $('.number_of_active_suppliers').html( active_suppliers.length );
      $('.number_of_active_customers').html( active_customers.length );

    });

	function private_chatbox (name , uid , uimage) {
		 
		 if ($.inArray(uid, arr) != -1 && arr.length > 3)
		 {
	      arr.splice($.inArray(uid, arr), 1);
	     }
		 
		 arr.unshift(uid);

		 chatPopup =  `<div class="popup-box box-${uid} chat-popup popup-box-on" id="qnimate" rel="${uid}">
    		  <div class="popup-head">
				<div class="popup-head-left pull-left">
					<img src="${uimage}" alt="iamgurdeeposahan"> 
					<span style="font-size:20px;">${name}</span>
				</div>
					  <div class="popup-head-right pull-right">
						<button id="removeClass" class="chat-header-button pull-right close" type="button"> <i class="fa fa-power-off"></i> </button>
                      </div>
			  </div>

			<div class="msg_wrap">
			<div class="popup-messages"><div class="direct-chat-messages msg_body"></div></div>
			
			<div class="popup-messages-footer"><span class="broadcast"></span><textarea id="status_message" placeholder="Type a message..." rows="10" cols="40" name="message"></textarea>

			<div class="files" style="max-height: 100px;"></div>

			<div class="btn-footer">
			<button class="pull-right send" style="color:#2196f3;border:none;padding:5px"> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>

			<label style="padding-left: 10px;cursor:pointer"><input type="file" multiple='' accept="image/*" style="display:none;" id="image"><i class="fa fa-image"></i></label>

			<label style="padding-left: 10px;cursor:pointer"><input type="file" multiple='' style="display:none;" id="file" accept=".txt,xml,.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"><i class="fa fa-paperclip"></i></label>
			</div>
			</div>
			</div>
	  </div>`;					
					
	     $("body").append(  chatPopup  );
		 displayChatBox();

		 $.ajax({
			url: message,
			type: 'GET',
			dataType: 'json',
			data: {
				sender_id:user_id,
				reciever_id:uid.split('_')[1],
			},
		}).done(function(response) {

			Object.keys(response).forEach( function(key){

				var message = response[key];

				var imageUrl = '';

				var file = '';

				image = message.sender.avatar;

				if (!image) {
					if (message.sender.role == 'supplier') {
						imageUrl = baseURI + 'img/default_supplier.jpg';
					}else{
						imageUrl = baseURI + 'img/default_user.png';
					}

				}else{
					imageUrl = baseURI + 'storage/' + image;
				}

				created_at = new Date(message.created_at);
				now = new Date();


				let options = {};

				if ( created_at.getHours() - now.getHours() > 12 &&  created_at.getDay() - now.getDay() > 1 ) {
					
					options = {  
					    weekday: "long", year: "numeric", month: "short",  
					    day: "numeric", hour: "2-digit", minute: "2-digit"  
					};

				}  

				var hours = created_at.getHours();
				var minute = created_at.getMinutes();

				if (message.type =='image') {

					file = `<a href="/storage/${message.content}"> <img width="100px" height="100px" src="/storage/${message.content}"> </a>`;

				}else if (message.type =='file') {
					file = `<a href="/storage/${message.content}" > ${message.content.split('/')[1]} </a>`;			
				}else{
					file = message.content;
				}

				var sender_name = message.sender.firstname + ' ' + message.sender.lastname ;


				var message_body = `<div class="direct-chat-msg doted-border">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">${sender_name}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img alt="message user image" src="${imageUrl}" class="direct-chat-img"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text  message${message.id}">
                      ${file}
                      </div>
					  <div class="direct-chat-info clearfix">
                        <span class="direct-chat-timestamp pull-right"> ${created_at.toLocaleTimeString("en-us" , options)} </span>
                      </div>
						<div class="direct-chat-info clearfix"></div>
                    
                    </div>`;

		        $('.box-' + uid +' .msg_body').append(message_body);

		        if ( message.sender_id == user_id ) {

		        	$(`.message${message.id}`).css({
						background : '#c0d899',
						border : '#c0d899'
					});

		        }else{
					$(`.message${message.id}`).css({
						background : '#f4f4f4',
						border : '#f4f4f4'
					});		        	
		        }

		        

			});

			$('.box-' + uid +' .popup-messages').scrollTop($('.box-' + uid +' .popup-messages').prop('scrollHeight'))


		});

	}

	socket.on('new_private_message', (data) => {

		var sender_id = data.to.split('_')[1];
		var reciever_id = data.from_user.split('_')[1];
		var sender = data.sender.split('_')[1];
		var content = data.message;
		var type = data.type;

		if(sender == user_id){
			$.ajax({
				url: message,
				type: 'POST',
				dataType: 'json',
				data: {
					_token:token,
					sender_id:sender,
					reciever_id,
					content,
					type,

				},
			});

		}
		if (!data.image) {
			
			if (data.role == 'supplier') {
				imageUrl = baseURI + 'img/default_supplier.jpg';
			}else{
				imageUrl = baseURI + 'img/default_user.png';
			}
		}else{
			imageUrl = baseURI + 'storage/' + data.image;
		}
		
		var flag = false;

		if (! $('#qnimate').hasClass('box-' + data.from_user) ) {

			private_chatbox( data.name , data.from_user , imageUrl );
			flag = true;
		}

		if (flag == false) {
			var currenrDate = new Date();

			var message_body = `<div class="direct-chat-msg doted-border">
		                      <div class="direct-chat-info clearfix">
		                        <span class="direct-chat-name pull-left">${data.name}</span>
		                      </div>
		                      <!-- /.direct-chat-info -->
		                      <img alt="message user image" src="${imageUrl}" class="direct-chat-img"><!-- /.direct-chat-img -->
		                      <div class="direct-chat-text message">
		                      ${data.message}
		                      </div>
							  <div class="direct-chat-info clearfix">
		                        <span class="direct-chat-timestamp pull-right"> ${currenrDate.toLocaleTimeString("en-us")} </span>
		                      </div>
								<div class="direct-chat-info clearfix"></div>
		                    
		                    </div>`;

		    $('.box-user_' + reciever_id +' .msg_body').append(message_body);

				if ( sender == sender_id ) {

		        	$('.box-user_' + reciever_id + ' .msg_body .message').css({
						background : '#c0d899',
						border : '#c0d899'
					});

		        }else{
					$('.box-user_' + reciever_id + '.msg_body .message').css({
						background : '#f4f4f4',
						border : '#f4f4f4'
					});

		        }
		};

		
		$('.box-user_' + reciever_id +' .popup-messages').scrollTop($('.box-user_' + reciever_id +' .popup-messages').prop('scrollHeight'))

	});

	socket.on('broadcast', (data) => {

		$('.box-' + data.from_user + ' .broadcast').html(`<img width="60px" height="40px" src="${typingurl}">`);

		setTimeout(() => {
			$('.box-' + data.from_user + ' .broadcast').html('');			
		}, 5000);

	});

	$(document).on('keypress' , '#status_message' , function(e) {

		var to = $(this).parents().parents().parents().attr('rel');
		
		if ( e.keyCode == 13 ) {			

			var message = $(this).val().trim();

			if ( message ) {

				socket.emit('send_private_message' , {
					message:message,
					to: to,
					type:'message',
					user_image:user_image
				});	
			}

			$(this).val('');	

		}else{

			socket.emit('private_broadcast' , {
				to: to
			});	

		}

	});


	$(document).on('click' , '.send' , function(e) {

		var to = $(this).parents().parents().parents().attr('rel');


		var message = $('#status_message').val().trim();

		if ( message ) {

			socket.emit('send_private_message' , {
				message:message,
				to: to,
				type:'message',
				user_image:user_image
			});	
		}

		$(this).val('');	

	});


	socket.on('new_private_file', (data) => {

		if (!data.image) {
			
			if (data.role == 'supplier') {
				imageUrl = baseURI + 'img/default_supplier.jpg';
			}else{
				imageUrl = baseURI + 'img/default_user.png';
			}
		}else{
			imageUrl = baseURI + 'storage/' + data.image;
		}

		var flag = false;

		if (! $('#qnimate').hasClass('box-' + data.to) ) {
			private_chatbox( data.name , data.to , imageUrl);
			flag = true;
		}

		var sender_id = data.to.split('_')[1];
		var reciever_id = data.to.split('_')[1];
		var sender = data.sender.split('_')[1];
		var content = data.file;
		var type = data.type;

		var link = '';
		var i = 0;

		if(sender == user_id){

			$.ajax({
				url: message,
				type: 'POST',
				dataType: 'json',
				data: {
					_token:token,
					sender_id:sender,
					reciever_id,
					content,
					type,

				},
			})
			.done(function(response) {
				link = response.content ;

				if (type=='image') {
					$('.uploaded_image' + i).attr('href', `/storage/${link}`);
				}else{
					$('.uplaoded_file'+i).attr('href', `/storage/${link}`);
				}

			})
			.fail(function(error) {
				console.log(error);
			});
			
		}

		if (data.type =='image') {

			file = `<a href="${data.file}" class="uploaded_image${i}"> <img width="100px" height="100px" src="${data.file}"> </a>`;

		}else{
			file = `<a href="${data.file}" class="uplaoded_file${i}" > ${data.filename} </a>`;			
		}

		if ( flag == false ) {

			var currenrDate = new Date();

			var message_body = `<div class="direct-chat-msg doted-border">
			                      <div class="direct-chat-info clearfix">
			                        <span class="direct-chat-name pull-left">${data.name}</span>
			                      </div>
			                      <!-- /.direct-chat-info -->
			                      <img alt="message user image" src="${imageUrl}" class="direct-chat-img"><!-- /.direct-chat-img -->
			                      <div class="direct-chat-text message">
			                         ${file}
			                      </div>
								  <div class="direct-chat-info clearfix">
			                        <span class="direct-chat-timestamp pull-right">${currenrDate.toLocaleTimeString("en-us")}</span>
			                      </div>
									<div class="direct-chat-info clearfix"></div>
			                    
			                   </div>`;


			$('.box-' + data.to +' .msg_body').append(message_body);

			if ( data.from_user.split('_')[1] == sender ) {

			        	$('.box-' + data.to + ' .msg_body .message').css({
							background : '#c0d899',
							border : '#c0d899'
						});

			        }else{
						$('.box-' + data.to + ' .msg_body .message').css({
							background : '#f4f4f4',
							border : '#f4f4f4'
						});		        	
			        }
		}

		$('.box-' + data.to +' .popup-messages').scrollTop($('.box-' + data.to +' .popup-messages').prop('scrollHeight'))		

	});

	$(document).on('change' , '#image' , function(e) {

		var to = $(this).parent().parent().parent().parent().parent().attr('rel');

		const files = e.target.files;

		var file_elm = '';

		for (var i = 0; i < files.length; i++) {

			var reader = new FileReader();

			var filename = files[i].name;
			if (filename.length > 15) {

				filename = filename.slice( filename.length /2 , filename.length);
				
			};

			reader.onload = function (event) {

				socket.emit('send_private_file' , {
					file: event.target.result,
					to: to,
					filename:filename,
					type:'image',
					user_image:user_image
				});

			};

			reader.readAsDataURL(files[i]);

		};

	});

	$(document).on('change' , '#file' , function(e) {

		var to = $(this).parent().parent().parent().parent().parent().attr('rel');

		const files = e.target.files;

		var file_elm = '';

		for (var i = 0; i < files.length; i++) {

			var reader = new FileReader();

			var filename = files[i].name;
			if (filename.length > 15) {

				filename = filename.slice( filename.length /2 , filename.length);
				
			};

			reader.onload = function (event) {

				socket.emit('send_private_file' , {
					file: event.target.result,
					to: to,
					filename:filename,
					type:'file',
					user_image:user_image
				});

			};

			reader.readAsDataURL(files[i]);

		};

	});

		
    
	function displayChatBox(){ 
	    i = 270 ; // start position
		j = 360;  //next position
		
			
			$.each( arr, function( index, value ) {  
		   	if(index < 4 && i < 1350  ){
		         $('[rel="'+value+'"]').css("right",i);
				 $('[rel="'+value+'"]').show();
			     i = i+j;			 
			   }
			   else{
				 $('[rel="'+value+'"]').hide();
			   }
	        });				
	        
	}
	
	
	
});