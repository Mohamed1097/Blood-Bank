
var urlSearchParams = new URLSearchParams(window.location.search);
var params = Object.fromEntries(urlSearchParams.entries());
$('#is_active').change(function()
{
  var key=this;
  let url=$(this).attr('url');
  this.disabled=true;
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },  
        });
  $.ajax({  
    type: 'PUT',
    url: url,
    contentType: 'application/json',
    data:JSON.stringify({
      is_active:key.checked
    }),
    success: function(data) 
    {
      if(!data.status)
      {
        key.disabled=false;
        if(key.checked)
        {
          key.checked=false
        }
        else
        {
          key.checked=true
        }
        document.querySelector('.toast-body').textContent=data.message;
        $('.toast').toast('show',10000);
      }
      else
      {
        key.disabled=false;
        key.value=data.data.is_active;
        document.querySelector('.toast-body').textContent=data.message;
        $('.toast').toast('show',10000);
        if(key.checked)
        {
          key.parentElement.querySelector('label').textContent='Active'
        }
        else
        {
          key.parentElement.querySelector('label').textContent='De-Active'
        }
      }
  }
    });
});


var filter='';
var url=window.location.pathname;
$(".select-filter").change(function(){
  filter=this.value;
  if(this.value==0)
  {
    document.querySelector('.city-div').style.display='none';
    document.querySelector('.bloodtype-div').style.display='none';
  }
  else if(this.value==1)
  {
    document.querySelector('.city-div').style.display='none';
    document.querySelector('.bloodtype-div').style.display='inline';
  }
  else if(this.value==2)
  {
    document.querySelector('.bloodtype-div').style.display='none';
    document.querySelector('.city-div').style.display='inline'; 
  }
  else if(this.value==3)
  {
    document.querySelector('.bloodtype-div').style.display='inline';
    document.querySelector('.city-div').style.display='none'; 
  }
})



$('.bloodtype-select').change(function(){
  let options=this.querySelectorAll('option');
  url+='?filter='+filter;
  for (let i = 0; i < options.length; i++) {
    const element = options[i];
    if(this.value==element.value)
    {
      url+='&blood_type_id='+this.value
      break;
    }
  }
  if(filter==1)
  {
    window.location = url;
  }
  else if(filter==3)
  {
   document.querySelector('.city-div').style.display='inline';  
  }
})
$('.city-select').change(function(){
  if (filter==2) {
    url+='?filter='+filter;
  }
  let options=this.querySelectorAll('option');
  for (let i = 0; i < options.length; i++) {
    const element = options[i];
    if(this.value==element.value)
    {
      url+='&city_id='+this.value
      break;
    }
  }
  window.location = url; 
})


var raw='';
$('.delete-btn').click(function()
{
  raw=this.parentElement.parentElement
  
  $('.modal-body').html('Are You Sure You Wanna Delete '+this.getAttribute('element'));
  $('.modal-footer .delete').attr('url',$(this).attr('url'));
})

$('.modal-footer .delete').click(function()
{
  $('#delete-modal').modal('hide')
  let url=this.getAttribute('url');
  let btn =this;
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },  
        });
  $.ajax({  
    type: 'DELETE',
    url: url,
    contentType: 'application/json',
    success:function(data)
    {
      console.log(data);
      document.querySelector('.toast-body').textContent=data.message;
      $('.toast').toast('show',1000000);
      if(data.status==1)
      {
       raw.remove(); 
      }
      else
      {
        console.log(data.status);
      }
      if (document.querySelectorAll('tr').length<3) 
      {
        url=window.location.pathname;
        if(typeof params !=='undefined')
        {
          url+='?';
         if (typeof params.page !=='undefined' ) 
         {
          if (params.page!=1) 
            params.page--;
          }
          keys=Object.keys(params);
          params=Object.values(params);
          params.forEach( function(param,index) {
            url+=keys[index]+"="+param+'&'
          });
        }
        window.location=url.substring(0, url.length - 1);
        
        
      }
    }
})
})

$('.imgbtn').click(function(){
    $('#post-image').click();
  });
$("#selectAll").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#selectAll").prop("checked", false);
  }
});
function toggle(heart,event)
{

	url=heart.getAttribute('url');
	 $.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},  
	    });
	$.post(url, {'post_id': heart.id}, function(data, textStatus, xhr) {
		console.log(data);
		if(data.status==1)
		{
			let currnetClass=$(heart).attr('class');
			if (currnetClass.includes('red-heart')) {
				$(heart).removeClass('red-heart')
			}
			else
			{
				$(heart).addClass('red-heart')
			}
		}
	});

}
$('#governorates').change(function(event) {
	event.preventDefault();
	let cities=document.querySelector('#cities');
	let placeHolder=document.querySelector('#cities option');
	let governorate_id=$(this).val();
	let url=$(this).attr('url');
	url+='?governorate_id='+governorate_id;
	$.get(url, function(data) 
	{
		cities.innerHTML = '';
		cities.appendChild(placeHolder);
		if(data.status==1)
		{
			let ids=Object.keys(data.data);
          	let names=Object.values(data.data);
          	names.forEach( function(name, index) {
          		let option=document.createElement('option');
          		option.value=ids[index];
          		option.textContent=name;
          		cities.appendChild(option);
          	});

		}
		else
		{
			cities.innerHTML = '';
			cities.appendChild(placeHolder);
		}

	});
});


