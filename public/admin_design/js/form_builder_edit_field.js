

				function makeAjaxEdit(url , input_id) {
                    
                    

                    var token = $('input[name="_token"]').val();
                    


                    $.ajax({

                        url:url,
                        dataType:'json',
                        type:'GET',
                        data:{input_id:input_id}
                    }).done(function(response) {

                        var published_on_profile = "";
                        var published_on_signup = "";
                        var published = "";


                        if(response[1] == 1){
                            published_on_profile = "checked=''";
                            published = "checked=''";
                        }

                        if(response[2] == 1){
                            published_on_signup = "checked=''";
                        }


                        var attributes = response[0];

                        
                        
                        child_num = 1;
                        
                        for (var i = 0; i < attributes.length; i++) {

                            var checked = "";
                            
                            if ( ( attributes[i].attribute == 'required' || attributes[i].attribute == 'is_confirm' || attributes[i].attribute == 'multiple' ) && attributes[i].value == 'on') {
                                checked = "checked=''";
                            }

                            var minusBtn = '';

                            var ValueOfInput = attributes[i].value;
                            
                            var attributeType = attributes[i].type;

                            var attribute = '';

                            if(attributes[i].name){

                                attribute = attributes[i].name;

                            }else if (attributes[i].attribute) {

                                attribute = attributes[i].attribute;

                            }
                            


                            var attributeArray = attribute.split('_');

                            var label = '';

                            for (var n = 0 ; n < attributeArray.length ; n++) {

                                label = label + ' ' + attributeArray[n];
                                
                            }

                             var attr = `<label class="col-sm-2 control-label" for="${label}">
                                            ${label}
                             
                                   </label>`;

                            var formGroup = '';

                            if (attributeType == "text") {
                                var attrVal = `<div class="col-sm-10"> <input id="${attribute}" name="${attribute}" value="${ValueOfInput}" class="form-control ${attribute}" type="${attributeType}"> </div>`;

                                                                                formGroup = `<div class="form-group">
                                                                            ${attr}
                                                                            ${attrVal}
                                                                        </div>`;

                            }else if(attributeType == "checkbox"){

                                var attrVal = `<div class="col-sm-10"><input id="${attribute}" name="${attribute}" class="checkbox ${attribute}" ${checked} name="${attribute}" type="${attributeType}"> </div>`;

                                formGroup = `<div class="form-check">
                                                ${attr}
                                                ${attrVal}
                                            </div>`;

                            }else if(attributeType=="item" || attributeType=="option"){

                                name = attributes[i].type;

                                if (child_num != 1) {
                                    minusBtn = `<i class="margin-top-5 fa fa-minus-circle fa-2x default_blue delete_radio" data-field="2638"></i>`;

                                }

                                var button = `<div class="col-md-12">
                                <div class="col-md-12"><div><div><div class="col-md-4"><div class="form-group"></div></div><div class="col-md-4"><div class="form-group"><input  value=${ValueOfInput} name="${name}${child_num++}" type="text" value="Value" class="r_val form-control"></div></div><div class="col-md-4">
                                
                                <i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="2638"></i>
                                ${minusBtn}

                                </div></div></div></div>
                                </div>`;


                                formGroup = `<div class="form-check">
                                                ${attr}
                                                ${button}
                                            </div>`;

                            }
                            

                            $('#EditAttr-' + input_id).append(formGroup);

                        }



                        current_url = $("#EditAttr-" + input_id).attr('action').split('/')[4];

                        if ( current_url != 'enquiry_form_builder' ) {


                            var publishedOnProfileLabel = `<label class="col-sm-2 control-label" for="published_on_profile">Published On Profile</label>`;

                            var publishedOnProfileVal= `<div class="col-sm-10"> <input class="checkbox published_on_profile" name="published_on_profile" ${published_on_profile} id="published_on_profile" type="checkbox"> </div>`;

                            var publishedOnProfileBlock = `<div class="form-check publishedOnProfileBlock">
                                                ${publishedOnProfileLabel}
                                                ${publishedOnProfileVal}
                                            </div>`;

                            $("#EditAttr-" + input_id).append(publishedOnProfileBlock);

                             $("#EditAttr-" + input_id).append(`<div class="clearfix"></div>`);

                            var publishedOnSignUpLabel = `<label class="col-sm-2 control-label" for="published_on_signup">Published On SignUp</label>`;

                            var publishedOnSignUpVal= `<div class="col-sm-10"> <input class="checkbox published_on_signup" name="published_on_signup" ${published_on_signup} id="published_on_signup" type="checkbox"> </div>`;

                            var publishedOnSignUpBlock = `<div class="form-check publishedOnSignUpBlock">
                                                ${publishedOnSignUpLabel}
                                                ${publishedOnSignUpVal}
                                            </div>`;



                            $('#EditAttr-' + input_id).append(publishedOnSignUpBlock);

                        }else{

                            var publishLabel = `<label class="col-sm-2 control-label" for="publish">Publish</label>`;

                            var publishVal= `<div class="col-sm-10"> <input class="checkbox" name="publish" ${published} id="publish" type="checkbox"> </div>`;

                            var publish = `<div class="form-check publish">
                                                ${publishLabel}
                                                ${publishVal}
                                            </div>`;

                            $('#EditAttr-' + input_id).append(publish);

                        }



                        var hiddenType = `<input type='hidden' name='input_id' value="${input_id}">`

                        $('#EditAttr-' + input_id).append(hiddenType);

                                            
                        var hiddenToken = `<input type='hidden' name='_token' value="${token}">`

                        $('#EditAttr-' + input_id).append(hiddenToken);

                        var hiddenMethod = `<input type='hidden' name='_method' value="PUT">`

                        $('#EditAttr-' + input_id).append(hiddenMethod);
                        

                        $(document).on('click' , '.edit-' + input_id , function(){

                            $('#EditAttr-' + input_id).submit();
                                child_num = 1;

                        });

                        $(document).on('click' , '.closeFormEdit-' + input_id , function(){

                            $('#EditAttr-' + input_id).empty();
                                child_num = 1;

                        });




                        

                    }).fail(function(error){
                        console.log('error');
                    });

                }

				