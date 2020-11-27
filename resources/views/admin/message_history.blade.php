<div class="msg_history open" id="full-chat-box-user_{{ $reciever->id }}">


	          	@foreach($messages as $message )

	          		@if ($message['type'] =='image')
	          				@php
								$content = '<a href="' . Storage::url($message['content']) . '" >
								<img width="100px" height="100px" src="' . Storage::url($message['content']) . '"> </a>';
							@endphp

					@elseif ($message['type'] =='file')

							@php
								$content = '<a href="' . $message['content'] . '" >
								<img width="100px" height="100px" src="' . explode('/',  $message['content'])[1] . '"> </a>';
							@endphp

					@else

							@php
								$content = $message['content'];
							@endphp

					@endif

	          		@if ( $message['sender_id'] == $user )

			        	<div class="incoming_msg">
			              	<div class="incoming_msg_img">

			              		@if($message['sender']['role'] == 'supplier')
			              			<img class="user_img" src="{{ asset('/img/default_supplier.jpg') }}" width="70px" height="70px" class="user-image" alt="User Image">
			              		@else
                              		<img class="user_img" src="{{ asset('/img/default_user.png') }}" width="70px" height="70px" class="user-image" alt="User Image">
			              		@endif

			              	</div>
			              	<div class="received_msg">
			                <div class="received_withd_msg">
			                	<p>{!! $content !!}</p>
			                  	<span class="time_date"> {{ $message['created_at'] }}</span></div>
			              	</div>
			            </div>

			        @else
						<div class="outgoing_msg">
			              <div class="sent_msg">
			                <p>{!! $content !!}</p>
			                <span class="time_date"> {{ $message['created_at'] }}</span> </div>
			            </div>
			        @endif

	            @endforeach

          	</div>

			  @if(!$from_admin)

          	<div class="type_msg">
          		<div class="broadcast"></div>
            	<div class="input_msg_write">
              	<textarea class="write_msg form-control" id="full_chat_message" placeholder="Type a message"></textarea>

              	<div class="btn-footer">
					<button class="pull-right full_chat_send"  data-to="user_{{ $reciever->id }}" style="color:#2196f3;border:none;margin-bottom: 10px;"> <i class="full_chat_send fa fa-paper-plane" aria-hidden="true"></i></button>

					<label style="padding-left: 10px;cursor:pointer">
						<input type="file" multiple='' accept="image/*" style="display:none;" id="full_chat_image"><i class="fa fa-upload"></i>
					</label>

				</div>

            	</div>
          	</div>

			@endif