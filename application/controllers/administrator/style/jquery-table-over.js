//��������ƹ���ʽ
$(function(){
  $(".forumRow").hover(
		function(){$(this).find("td").css({"background-color":"#fff"});}
												   ,
		function(){$(this).find("td").css({"background-color":""});
		});
  
//ȫѡ��ȡ���б���
  $("#del_checkbox").click(function(){
	 var thischeck=$(this).attr("checked");
		 $(".del_id").attr("checked",thischeck);
	 });
  
  $("#Submit_delsel").click(function(){
	 if(ischecked()){
		if(confirm("ȷ��Ҫɾ��ѡ����?")){
			return true;
		}else{
			return false;	
		}
	 }else{
			return false;
		 }
	 });
  
					   
  
   });

/*�ж��Ƿ�ѡ����*/
function ischecked(){
	var thisis=false;
	$(".del_id").each(function(){
		if(thisis==false){
			var thischecked=$(this).attr("checked");
			if(thischecked){thisis=true;}
			}
		});
	if(thisis==false){alert("����Ҫѡ��һ��!");	}
	return thisis;
	}