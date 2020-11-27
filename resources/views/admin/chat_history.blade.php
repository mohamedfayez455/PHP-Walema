@extends('admin.index')

@section('content')

@push('css')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/full_chat.css') }}">

@endpush

@push('js')

	<script type="text/javascript">

		$('.mesgs .msg_history.open').scrollTop($('.mesgs .msg_history.open').prop('scrollHeight'))

		$(document).on('click' , '.chat_list' , function(e) {


                var loader =    $('body').loader({
                                    // auto check container and use the size specified below
                                        autoCheck: 32,

                                        // custom CSS styles
                                        css: {},

                                        // spinner size
                                        size: 16,

                                        // overlay color
                                        bgColor: '#FFF',

                                        // overlay opacity
                                        bgOpacity: 0.5,

                                        // font color
                                        fontColor: false,

                                        // position option
                                        position: [0, 0, 0, 0],

                                        // loading text
                                        title: '',

                                        // only one loading spinner/overlay at a time
                                        isOnly: true,

                                        // loading gif
                                        imgUrl: '{{ url("/img/loading[size].gif") }}',

                                        // callbacks
                                        onShow: function () {
                                        },
                                        onClose: function () {
                                        }
                });

			var reciever_id = $(this).data('id');

			$('.chat_list').each(function(index, el) {

				$(this).removeClass('active_chat');

			});

			$(this).addClass('active_chat');

			$.ajax({
				url: "{{ route('get_full_chat_off') }}",
				data: {
					reciever_id,
					_token:"{{ csrf_token() }}",
					sender_id:"{{ $user->id }}"
				},
			})
			.done(function(response) {

				$('.mesgs').html(response);

				$('.mesgs .msg_history.open').scrollTop($('.mesgs .msg_history.open').prop('scrollHeight'))

			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				$.loader.close();
			});

		});

	</script>
@endpush

<div class="container">
<h3 class=" text-center">Chat</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
          </div>

        	@if($user->type_profile()->friends_collection()->first())

          		@if($user->type_profile()->friends_collection()->first()->reciever_id != $user->id)

		          	@php
		          		$first = $user->type_profile()->friends_collection()->first()->reciever_id;
		          	@endphp
		        @elseif ($user->type_profile()->friends_collection()->first()->sender_id != $user->id)
		        	@php
		          		$first = $user->type_profile()->friends_collection()->first()->sender_id;
		          	@endphp
          		@endif
          	@else
		        @php
          			$first = 0;
		        @endphp
          	@endif

          	<div class="inbox_chat">

	          	@forelse( $user->type_profile()->friends_collection() as $friend )

	          		@if($friend->customerUser->id == $user->id)

	                    @php
	                        $friend = $friend->supplierUser;
	                    @endphp
	                @else

	                    @php
	                        $friend = $friend->customerUser;
	                    @endphp

	                @endif


		            <div class="chat_list {{ $first == $friend->id ? 'active_chat' : '' }}" data-id="{{  $friend->id }}" id="user_{{ $friend->id }}">
		              <div class="chat_people">
		                <div class="chat_img"> <img src="{{ asset('/img/default_user.png') }}" alt="sunil"> </div>
		                <div class="chat_ib messageCommon" user_id="{{ $friend->id }}">


		                  <h5>{{ $friend->username }} <span class="chat_date">{{ $friend->last_message_info($user->id) ? $friend->last_message_info($user->id)->created_at->diffForHumans() :'' }}</span></h5>

		                  	@if($friend->last_message_info($user->id))

	                            @if($friend->last_message_info($user->id)->type != 'message')
	                            	<span class="last_message">

	                                	<img src="{{ asset($friend->last_message_info($user->id)->content) }}" class="img-thumbnail " width="50px" height="50px">
	                     			</span>
	                            @else

	                                <p class="last_message">{{ $friend->last_message_info($user->id)->content}}.</p>

	                            @endif
	                        @endif


		                </div>
		              </div>
		            </div>

	            @empty

	            	<div class="chat_list active_chat">
		              <div class="chat_people">
		                <div class="chat_ib">
		                  <p class="text-center text-warning">You never communicated with anyone.</p>
		                </div>
		              </div>
		            </div>
	            @endforelse

          	</div>
        </div>

        <div class="mesgs">


          	<div class="msg_history open" id="full-chat-box-user_{{ $first }}">

	          	@foreach( $user->type_profile()->getMessage($first) as $message )

	          		@if ($message['type'] =='image')
	          				@php
								$content = '<a href="' . $message['content'] . '" >
								<img width="100px" height="100px" src="' . $message['content'] . '"> </a>';
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

	          		@if ( $message['sender_id'] == $user->id )

			        	<div class="incoming_msg">
			              	<div class="incoming_msg_img">
			              		<img src="{{ asset($message['sender']['image']) }}" alt="sunil">
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

        </div>
      </div>

    </div>
</div>

@stop