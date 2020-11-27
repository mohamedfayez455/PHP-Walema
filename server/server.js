'use strict';

const express = require('express');
const http = require('http');
const socket = require('socket.io');
const socketServer = require('./socket');	

class Server{

	constructor(){
		this.port = 3000;
		this.app = express();
		this.server = http.Server(this.app);
		this.socket = socket(this.server);
	}

	runServer(){

		new socketServer( this.socket );

		this.server.listen(this.port , ()=>{
			console.log(this.server.address().address);
			console.log(`this host is running`);
		});
	}

}

const app = new Server();

app.runServer();