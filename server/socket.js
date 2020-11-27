'use strict';

class Socket{

	constructor(socket){

		this.io = socket
		this.io.origins("*:*");
		this.online_users = [];
		this.connection();

	}

	connection(){

		this.middleware();

		this.io.on('connection', (socket)=>{
			
			this.online_users = this.active_users();
			this.private_broadcast(socket);
			this.send_private_message(socket);
			this.send_private_file(socket);
			this.check_if_online(socket);
		});


	}

	active_users(){

		return Object.keys( this.io.sockets.connected) ;
	}

	middleware(){

		this.io.use( (socket , next)=>{
			
			if ( socket.handshake.query.role == 'user' ) {
				socket.id = 'user_' + socket.handshake.query.user_id;
			}else{
				socket.id = 'admin_' + socket.handshake.query.admin_id;
			}


			if ( socket.handshake.query.name  ) {
					socket.name = socket.handshake.query.name;
			}else{
					socket.name = '';
			}

			if ( socket.handshake.query.my_friends  ) {
					socket.my_friends = socket.handshake.query.my_friends.split(',');
			}else{
					socket.my_friends = [];
			}

			if ( socket.handshake.query.user_image  ) {
					socket.user_image = socket.handshake.query.user_image;
			}else{
					socket.user_image = '';
			}


			next();
		});
	}

	send_private_message( socket ){

		socket.on('send_private_message', (data)=> {

			this.emit(socket.id , 'new_private_message' , {name: socket.name , to : socket.id, sender:socket.id, from_user: data.to , type:data.type , color:'#c0d899' , message:data.message , image:socket.user_image});
			this.emit(data.to , 'new_private_message' , { name:socket.name , to : data.to, sender:socket.id, from_user:socket.id , type:data.type , color: 'f4f4f4' , message:data.message , image:socket.user_image});

		});

	}

	check_if_online( socket ){

		socket.on('check_if_online', (data)=> {
			
			var status = 'offline';

			if ( this.is_online(data.user_id)  ) {
				status = 'online';
			}

			if (status == 'online') {
				this.emit(socket.id , 'if_online' , {status: status , user_id:data.user_id , type:data.type});	
			};

		});

	}

	send_private_file( socket ){

		socket.on('send_private_file', (data)=> {

			this.emit(socket.id , 'new_private_file' , {name: socket.name , filename:data.filename , to : data.to, sender:socket.id , from_user: socket.id , color:'#c0d899' , file:data.file , type:data.type, image:socket.user_image});
			this.emit( data.to , 'new_private_file' , { name:socket.name , filename:data.filename , to : socket.id, sender:socket.id, from_user:socket.id , color: 'f4f4f4' , file:data.file , type:data.type, image:socket.user_image});

		});

	}

	private_broadcast(socket){

		socket.on('private_broadcast', (data) => {

			this.emit(data.to , 'broadcast' , { from_user:socket.id });

		});

	}

	emit( user_id , name_of_event , data ){

		if ( this.is_online(user_id) ) {

			this.io.sockets.connected[user_id].emit(name_of_event , data);
		}

	}

	is_online(user_id){

		return  this.active_users().indexOf(user_id) >= 0;

	}

}

module.exports = Socket;