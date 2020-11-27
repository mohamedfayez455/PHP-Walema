
	function showFormBuilder(url , form1 = '.FormBuilder' , page='signup' , form2 = '.additionalData') {

		$.ajax({
			url:url,
			dataType:'json',
			type:'GET',
			data:{page:page}
		}).done(function(response) {

			var fields = response[0];
			var hasClass = false;
			var isMultiple = false;
			var classes = 'class ="form-control " ';
			var classes2 = 'class ="form-control-file" ';

			var specified = ['categories_id' , 'country_id'];

			var types =response[2];

			var values =response[3];

			var iteration = 0;

			var keys = Object.keys(values);

			var excepts = ['password' , 'password_confirmation' , 'confirmation_password'];
			
			let index = 0;
			var name = '';
			var valueOfUser = '';
			var additional_data = values.additional_data;	

			Object.entries(fields).forEach(function(field) {

				if(field[0] == ''){
					return false;
				}

				var type = types[iteration];

				isMultiple = false;
				hasClass = false;
				var MainDiv ='';
				var additionalClasses = '';
				valueOfUser = '';

				for(var key in field){

					var label = '';
					var guide = '';
					var items = [];
					var LabelValue = '';

					if (!Array.isArray(field[key]) ) {
						name = field[key];
					}

					var re = /[0-9]+/;

					name = name.split(re)[0];

					if ( keys.indexOf(name) >= 0 ) {
						valueOfUser = values[name];
						
					};


					if( Array.isArray(field[key]) ){

						var FieldAttribute = field[key];

						var AllAttributes = [] ;

						
						if (type == "dropdown" || type == "select") {

							var identeifier = "(Item)";

							if (type == "dropdown") {
								identeifier = "(Item)";
							}else{
								identeifier = "(Option)";
							}

							
							FieldAttribute.forEach(function(attribute) {
								

								if (attribute.includes(identeifier)) {

									attribute = attribute.split(identeifier)[1];
									attribute = attribute.split(":");

									var item = {value: attribute[0] , name: attribute[1]}

									items.push(item);

								}else{
									attribute = attribute.split(":");
								}

								

								var attrName = attribute[0].trim();
								var attrValue = attribute[1].trim();

								if (attrName == 'label') {

									label = `<label for="${name}">${attrValue.toUpperCase() }</label>`;

								
								}else if (attrName == 'guide') {
									guide = `<div><p class="text-info">${attrValue.toUpperCase()}</div></p>`;
									return;
								}

								if (type == "dropdown") {
									
									var lists = `<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">`;

									items.forEach(function(item) {

										list = `<li role="presentation"><a role="menuitem" tabindex="-1" href="#">${item.value}</a></li>`;

										lists += list;

									});

									MainDiv = `<div class="form-group dropdown pull-left">
											    <button id="dropdownProperties" class="btn btn-primary 
											        dropdown-toggle" type="button" data-toggle="dropdown" 
											        aria-haspopup="true" aria-expanded="false"
											    >
											        ${name} <span class="caret"></span>
											    </button>
											     ${lists}</ul>
											</div> <div class="clearfix"></div>`;

								}else{

									var options = `<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">`;

									items.forEach(function(option) {

										var checked = ''; 


										if ( valueOfUser.length == 0  && page != 'signup' && page != ''&& page != null && additionalClasses == '') {
									
											additionalClasses = 'alert alert-warning';

										}


										if (valueOfUser.indexOf( option.value ) >= 0   && page != 'signup' && page != ''&& page != null && additionalClasses == '') {
									
											checked = "checked=''";

										}

										option = `<option value="${option.value}" ${checked}>${option.name}</option>`;

										options += option;

									});

									var multiple = '';
									var bracktes = '';

									if(attrName == 'multiple' && attrValue == 'on'){
											
										multiple = 'multiple="true" ';
										bracktes = '[]';
									}

									if ( valueOfUser.length == 0  && page != 'signup' && page != ''&& page != null && additionalClasses == '') {
									
										additionalClasses = 'alert alert-warning';

									}



									if (page == 'edit_enquiry') {
										additionalClasses = '';
									};

									MainDiv = `<div class="form-group ${additionalClasses}">
												  ${label}
												  <select name="${name}${bracktes}" ${multiple} class="form-control">
											        ${options}
											      </select>
									      	  </div>`;

								}

							});

						}else{


							FieldAttribute.forEach(function(attribute) {
								
								attribute = attribute.split(":");

								var attrName = attribute[0].trim();

								var attrValue = '';

								
								for(var k = 1; k < attribute.length; k++){

									attrValue = attrValue + attribute[k]+':';

								}

								attrValue = attrValue.substring(0, attrValue.length -1).trim();

								if ( (valueOfUser ==[] || !valueOfUser  )  && excepts.indexOf(name) < 0  && page != 'signup' && page != ''&& page != null && additionalClasses == '') {
									
									additionalClasses = 'alert alert-warning'
								}


								if (attrName == 'label'){

									if (type == "checkbox" || type == "radio" ){

										LabelValue = attrValue;
										
									}else{

										label = `<label for="${name}">${attrValue.toUpperCase() }</label>`;

									}
									return;
									

								}else if (attrName == 'guide'){

										guide = `<p style="margin-bottom: 15px;margin-top: -10px;" class="text-info">${attrValue.toUpperCase()}</p>`;
										return;
									

								}else if(attrName == 'required' && attrValue == 'on'){
									attribute = 'required ';

									

									if ( (valueOfUser ==[] || valueOfUser =='' )  && excepts.indexOf(name) < 0  && page != 'signup' && page != ''&& page != null) {
										additionalClasses = 'alert alert-danger'
									};

								}else if(attrName == 'multiple' && attrValue == 'on'){
									isMultiple = true;
									attribute = 'multiple ';
								}else{

									if(attrName == 'value' && attrValue != '' && (valueOfUser == attrValue) || ( Array.isArray( valueOfUser) &&  valueOfUser.indexOf(attrValue)  >=0 ) ){
										
										valueOfUser = attrValue;
										checked = 'checked ';
									}else{
										checked = '';
									}


									if(attrName == 'class'){
										
										hasClass = true;

										if(!attrValue.includes('form-control')){


											if (type == 'file') {
												attribute = `${attrName} = "${attrValue}" ${classes2} `;
											}else{
												attribute = `${attrName} = "${attrValue}" ${classes} `;
											}
										}else{
											attribute = `${attrName} = "${attrValue}" `;
										}

										
									}else{

										attribute = `${attrName} = "${attrValue}" `;
									}
								}

								AllAttributes.push(attribute);

							});


							if (type == "textarea") {


								field = `<textarea `;

							}else{

								if (page == 'signup' ||page == null ||page == '' ) {


									field = `<input type="${type}" `;
										
								}else{

									if (type == 'password') {
										valueOfUser = '';
									}


									if (valueOfUser == '' || valueOfUser == null ) {

										if (type == 'file' && isMultiple) {

											field = `<input type="${type}" name='${name}[]' `;
											
										}else{

											field = `<input type="${type}" `;
											
										}

									}else{
										if( type != 'checkbox' && type != 'radio' ){

										

											field = `<input type="${type}" value='${valueOfUser}' `;	
										}else{
											field = `<input type="${type}" `;
										}
										
									}										
								}
								
							}




							var MainClass = "";


							if (type == "file") {

								MainClass = "form-group";


							}else if(type == "checkbox"){
							
								MainClass = "checkbox";
							
							}else{
								MainClass = "form-group";
							}

							if (!hasClass && ( type != "checkbox" && type != "radio" ) ) {
								if (type == 'file'){
									classes2 = "class='form-control-file' ";

									field += classes2;								
								}else{


									field += classes;
									
								}
							}

							AllAttributes.forEach(function(attr){								
							
								if( type != 'checkbox' || type != 'redio' )  {

								
									if ( attr.includes('name') && field.includes('name')  || ( attr.includes('value') && field.includes('value')  ) ) {

										return;

									}else if ( attr.includes('value') && ( valueOfUser == '' && valueOfUser == null )  ) {

										field = field + attr;

									}
								}

								
								field = field + attr;	
								
							});

							if (page == 'edit_enquiry') {
								additionalClasses = '';
							};


							if (type == "checkbox" || type == "radio"){


								label = `<label>
											${field} ${checked}>
											${LabelValue}
										</label>`;

								MainDiv = `<div class="${MainClass} ${additionalClasses}">
												${label}					    
										</div>`;

							}else if (type == "textarea"){

								if (page == 'signup' ||page == null ||page == '' ) {

									

									MainDiv = `<div class="${MainClass} ${additionalClasses}">
													${label}					    
												    
												   ${field}> </textarea>
											</div>`;

								}else{


									MainDiv = `<div class="${MainClass} ${additionalClasses}">
													${label}					    
												    
												   ${field}> ${valueOfUser} </textarea>
											</div>`;	
								}
							}
							else{

								if (type == 'file') {
									
									var image = '';

									if ( name == 'avatar' ) {
										image = `<img style="display:block" src="/img/default_user.png" width="100px" height="100px">`	;
									
									};

									
									if (valueOfUser != null && valueOfUser != '' && valueOfUser.length != 0 ) {

										image = `<img style="display:block" src="/storage/${valueOfUser}" width="100px" height="100px">	`;
									
									}

									MainDiv = `<div class="form-group ${additionalClasses}">
													${label}
													${image}
													${field}>
												</div>`;

								}else{


									MainDiv = `<div class="${MainClass} ${additionalClasses}">
													${label}					    
												    
												   ${field}>
											</div>`;	
								}
							}


							valueOfUser = '';
							
						}


							if (page == null) {
								$(form1).append(MainDiv);
							}
							else if ( page == 'signup' ||  keys.indexOf(name) >= 0 || excepts.indexOf(name) >= 0 ) {

								$(form1).append(MainDiv);

							}else{

								
								var match = '';

								for (var i = 0; i <= excepts.length ; i++) {
									match = excepts[i].match(name);
									break;	
								};


								if (keys.indexOf(name) < 0 && (excepts.indexOf(name) < 0 || ! match ) ) {									

									$(form1).append(MainDiv);	
								}
							}
							
							$(form1).append(guide);


					}
					
				}


				if ( specified.indexOf(name) >= 0 ) {

						var slectName = name;

						$.when( 
								$.ajax({
								// url: 'http://167.172.208.67/lara-walema/public/get-array-of/'+name,
								url: baseURI + 'get-array-of/'+name,
								type: 'get',
								dataType: 'json',
							}) 
						).then(function( response) {

							var NamesOfSelect = Object.values(response);
							var ValuesOfSelect = Object.keys(response);



							var select = $(form1 + ` select[name="${slectName}"]`);
							
							if (select.length == 0) {
								select = $(form1 + ` select[name="${slectName}[]"]`);
							}

							if ( select.find('option').length == 0 && NamesOfSelect.length > 0 && ValuesOfSelect.length > 0) {

								for (var i = 0 ; i < ValuesOfSelect.length ; i++) {

									var value = ValuesOfSelect[i];
									var name = NamesOfSelect[i];
									var selected = '';

									if (Object.keys(values).length > 0 && ( values[slectName] != [] || values[slectName] != '' ) ) {

										if ( values[slectName].length > 0 ) {

											for (var x = 0 ; x < values[slectName].length ; x++) {
											
												var id = values[slectName][x];

												if ( id == value && page != 'signup' && page != ''&& page != null) {
											
													selected = "selected=''";
													break;
												}

											};

										}else{
											var id = values[slectName];

											if ( id == value && page != 'signup' && page != ''&& page != null) {
										
												selected = "selected=''";
											}
										}

									}



									var option = `<option ${selected} value="${value}">${name}</option>`;

									select.append(option);


									if (slectName != 'country_id') {
										
										select.select2({
										  	tags: "true",
										    placeholder: {
											    text: 'Select an option',
											},
										    allowClear: true,theme: "classic"
										});
									};


								    $('.select2-search__field').css('width', '150px');
								    select.addClass('md-8');
								    select.siblings('label').addClass('md-4');

								    select.on('change', function (e) {
								      $('.select2-search__field').css('width', '150px');

								    });
									
								};


							}

						})
						.fail(function() {
							console.log("error");
						});
						

				}

				iteration = iteration+1;				

			});

			if (page != null) {
				
				var btnName = '';

				if (page == 'edit_profile') {
					btnName = 'Complete Profile';
				}else if (page == 'edit_enquiry') {
					btnName = 'Send';
				}else{

					btnName = 'Create Account';
				}

				var btn = `<div>
								<div class="row" style="margin-bottom: 20px;">
			  							<div class="form-group col-xs-12">
			  								<button type="submit" class="btn btn-primary send_enquiry create">${btnName}</button>
			  							</div>
			  						</div>
			  					</div>`;
						
				$(form1).append(btn);
	
	
			}
			

		}).fail(function(error) {
			console.log(error , "errrrrrrrrrrrrrrrrrrrrrrrrrrrrrror");
		});

	}
