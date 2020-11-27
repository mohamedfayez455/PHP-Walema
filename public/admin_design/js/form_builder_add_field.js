
            var child_num = 1;
            var name = "";
            var type = "";
            var input_id = "";

            $('.select').on('change' , function() {

                

                $('#addAttr').empty();

                input_id = $('.select').val();
                
                 makeAjaxAdd("/admin/suppliers_profile_builder/get_input_attribute",
                  {input_id:input_id} );
                
            });

            $(document).on('click', '.add_more_radio', function () {
                        var newRadio =   `<div class="col-md-12">
                                    <div class="col-md-12"><div>
                                        <div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input name="${name}${child_num++}" type="text" placeholder="Value" class="r_val form-control">
                                                </div>
                                            </div>
                                        <div class="col-md-4">
                                        <i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="2638"></i>
                                        <i class="margin-top-5 fa fa-minus-circle fa-2x default_blue delete_radio" data-field="2638"></i>
                                        </div></div></div></div>
                                    </div>`;

                        if ( $('.publishedOnProfileBlock').length > 0 ) {

                            $(newRadio).insertBefore('.publishedOnProfileBlock');

                        }else{

                            $(newRadio).insertBefore('.publish');                            
                        }

            });

            $(document).on('click', '.delete_radio', function () {
                        
                $(this).parentsUntil('div.col-md-12').remove();

            });


            $(document).on('click', '.is_confirm', function() {

                        if($('.is_confirm:checked').length > 0){


                            var newPasswordField =   `<div class="col-md-12 newPasswordField">
                                                                <div class="col-md-12">
                                                                    <label class="col-sm-2 control-label" for="label">Label</label>
                                                                    <div class="form-group col-sm-10">
                                                                        <input type="text" name="confirmation_labelAttr" placeholder="Label Of Password Confirmation" class="r_opt form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <label class="col-sm-2 control-label" for="name">Name</label>
                                                                    <div class="form-group col-sm-10">
                                                                        <input type="text" name="confirmation_name" placeholder="Name Of Password Confirmation " class="r_opt form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <label class="col-sm-2 control-label" for="Placeholder">Placeholder</label>
                                                                    <div class="form-group col-sm-10">
                                                                        <input name="confirmation_placeholder" type="text" placeholder="Placeholder Of Password Confirmation" class="r_val form-control">
                                                                    </div>
                                                                </div>
                                                    </div>`;

                            $(newPasswordField).insertBefore('.publishedOnProfileBlock');
                        }else{

                            $('.newPasswordField').remove();

                        }

            })

            $(document).on('click' , '.add' , function(){

                $('#addAttr').submit();
                child_num = 1;

            });

            $('.closeForm').on('click' , function(){

                $('#addAttr').empty();
                child_num = 1;

            });


                function makeAjaxAdd(url, data ) {


                    $.ajax({

                        url:url,
                        dataType:'json',
                        type:'GET',
                        data:data
                    }).done(function(attributes) {


                        attributes = Object.keys(attributes).map(function(key) {
                          return attributes[key];
                        
                        });


                        var token = $('input[name="_token"]').val();
                        
                        child_num = 1;


                        for (var i = 0; i < attributes.length; i++) {
                            
                            
                            
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

                            
                            if (attributeType == "text") {
                                var attrVal = `<div class="col-sm-10"> <input id="${attribute}" name="${attribute}" class="form-control ${attribute}" type="${attributeType}"> </div>`;

                                var formGroup = `<div class="form-group">
                                                ${attr}
                                                ${attrVal}
                                            </div>`;

                            }else if(attributeType == "checkbox"){

                                var attrVal = `<div class="col-sm-10"><input id="${attribute}" name="${attribute}" class="checkbox ${attribute}"name="${attribute}" type="${attributeType}"> </div>`;


                                var formGroup = `<div class="form-check">
                                                ${attr}
                                                ${attrVal}
                                            </div>`;

                            }else if(attributeType=="item" || attributeType=="option" || attributeType=="option"){

                                name = attributes[i].type;

                                var button = `<div class="col-md-12">
                                <div class="col-md-12"><div><div><div class="col-md-4"><div class="form-group"></div></div><div class="col-md-4"><div class="form-group"><input name="${name}${child_num++}" type="text" placeholder="Value" class="r_val form-control"></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="2638"></i></div></div></div></div>
                                </div>`;


                                var formGroup = `<div class="form-check">
                                                ${attr}
                                                ${button}
                                            </div>`;

                            }

                            $("#addAttr").append(formGroup);



                        }

                        current_url = $("#addAttr").attr('action').split('/')[4];

                        if ( current_url != 'enquiry_form_builder' ) {

                            var publishedOnProfileLabel = `<label class="col-sm-2 control-label" for="published_on_profile">Published On Profile</label>`;

                            var publishedOnProfileVal= `<div class="col-sm-10"> <input class="checkbox published_on_profile" name="published_on_profile" id="published_on_profile" type="checkbox"> </div>`;

                            var publishedOnProfileBlock = `<div class="form-check publishedOnProfileBlock">
                                                ${publishedOnProfileLabel}
                                                ${publishedOnProfileVal}
                                            </div>`;

                            $("#addAttr").append(publishedOnProfileBlock);

                             $("#addAttr").append(`<div class="clearfix"></div>`);

                            var publishedOnSignUpLabel = `<label class="col-sm-2 control-label" for="published_on_signup">Published On SignUp</label>`;

                            var publishedOnSignUpVal= `<div class="col-sm-10"> <input class="checkbox published_on_signup" name="published_on_signup" id="published_on_signup" type="checkbox"> </div>`;

                            var publishedOnSignUpBlock = `<div class="form-check publishedOnSignUpBlock">
                                                ${publishedOnSignUpLabel}
                                                ${publishedOnSignUpVal}
                                            </div>`;

                            $("#addAttr").append(publishedOnSignUpBlock);

                        }else{

                            var publishLabel = `<label class="col-sm-2 control-label" for="publish">Publish</label>`;

                            var publishVal= `<div class="col-sm-10"> <input class="checkbox" name="publish" id="publish" type="checkbox"> </div>`;

                            var publish = `<div class="form-check publish">
                                                ${publishLabel}
                                                ${publishVal}
                                            </div>`;

                            $("#addAttr").append(publish);

                        }

                        


                        var hiddenType = `<input type='hidden' name='input_id' value="${input_id}">`

                        $("#addAttr").append(hiddenType);

                                            
                        var hiddenToken = `<input type='hidden' name='_token' value="${token}">`

                        $("#addAttr").append(hiddenToken);
                        


                    }).fail(function(error){
                        console.log('error')
                    });



                }
