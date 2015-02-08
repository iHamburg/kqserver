 $(function () {

            $('#btn').click(function () {

                var count = 60;

                //var moblie = $('#moblie').val();

                var countdown = setInterval(CountDown, 1000);

                function CountDown() {

                    $("#btn").attr("disabled", true);

                    $("#moblie").attr("readonly",true);

					$("#btn").addClass('clicka');

					$("#btn").addClass('sub_s');

					$("#btn").removeClass('btn-warning');

					$("#btn").removeClass('submit');

                    $("#btn").val(count + "秒后重新发送");

                    if (count == 0) {

                        $("#btn").val("获取验证码").removeAttr("disabled");

                        clearInterval(countdown);

                        //$("#moblie").removeAttr("disabled");

						$("#btn").addClass('btn-warning');

						$("#btn").addClass('submit');

						$("#btn").removeClass('sub_s');

						$("#btn").removeClass('clicka');

                    }

                    count--;

                }

            })

        });





        $('#btn').click(function(){

            var moblie = $('#moblie').val();

           	var len = moblie.length;

		if(len == 0){
		alert('请输入手机号');

               	$("#btn").val("获取验证码").removeAttr("disabled");

                clearInterval(countdown);

				$("#btn").addClass('btn-warning');

				$("#btn").addClass('submit');

				$("#btn").removeClass('sub_s');

				$("#btn").removeClass('clicka');

		}else if(len !== 11){

               	alert('输入的手机号码不正确');

               	$("#btn").val("获取验证码").removeAttr("disabled");

                clearInterval(countdown);

				$("#btn").addClass('btn-warning');

				$("#btn").addClass('submit');

				$("#btn").removeClass('sub_s');

				$("#btn").removeClass('clicka');

            }else{

                var url = "http://61.153.100.241/kqweb/index.php/kqapi1_1/testsms/username/"+moblie;

                $.get(url,function(data){

            		if(data){

            			

            			//alert(data);

            			//alert(data.data);

            		$('#hidd').val(data.data);

            		//$('#hidd').val('12345');

            		//alert($('#hidd').val())

            		}

            	},'json');

            }

        });

        

        

        $('#hide').hide();

        $('#cc').click(function(){

        	$('#hide').toggle();

        });

        

 $('#kk').click(function(){

//	 alert(11);

//        	

        	var maskHeight = $(document).height();

        	var maskWidth = $(document).width();

        	

        	$('#mask').show();

        	$('<div class="mask"></div>').appendTo($('body'))

        	$('div.mask').css({

        		'opacity':0.7,

        		'background':'#000',

        		'position':'absolute',

        		'left':0,

        		'top':0,

        		'height':maskHeight,

        		'width':maskWidth,

        		'z-index':2

        	});

        

        });

 

 

 $('#sd').click(function(){

 	$('#mask').hide();

 	$('.mask').remove();

 });

      